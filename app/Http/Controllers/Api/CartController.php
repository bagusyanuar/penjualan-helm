<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingCity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CartController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');
    }

    public function index()
    {
        try {
            if ($this->request->method() === 'POST') {
                return $this->store();
            }
            $data = Cart::with(['product'])
                ->where('user_id', '=', auth()->id())
                ->whereNull('order_id')
                ->orderBy('created_at', 'DESC')
                ->get();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }

    private function store()
    {
        try {
            $userID = auth()->id();
            $productID = $this->postField('product_id');
            $qty = (int)$this->postField('qty');

            $product = Product::with([])
                ->where('id', '=', $productID)
                ->first();

            if (!$product) {
                return $this->jsonNotFoundResponse('item not found...');
            }

            $price = $product->price;
            $total = $price * $qty;

            $data_request = [
                'user_id' => $userID,
                'product_id' => $productID,
                'price' => $price,
                'qty' => $qty,
                'total' => $total
            ];

            Cart::create($data_request);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }

    public function checkout()
    {
        try {
            DB::beginTransaction();
            $carts = Cart::with(['user'])
                ->where('user_id', '=', auth()->id())
                ->whereNull('order_id')
                ->get();


            if (count($carts) <= 0) {
                return $this->jsonBadRequestResponse('no cart attached');
            }

            $user = User::with([])
                ->where('id', '=', auth()->id())
                ->first();

            if (!$user) {
                return $this->jsonBadRequestResponse('user not found');
            }

            $username = $user->username;
            $shippingID = $this->postField('shipping_id');
            $isSent = '1';

            $shippingPrice = 0;
            $shippingAddress = '-';
            $shippingCity = '';

//            if ($isSent === '1') {
            $shipping = ShippingCity::with([])
                ->where('id', '=', $shippingID)
                ->first();

            if (!$shipping) {
                return $this->jsonNotFoundResponse('shipping not found');
            }

            $shippingPrice = $shipping->price;
            $shippingCity = $shipping->city;
            $shippingAddress = $this->postField('address');
//            }

            $subTotal = $carts->sum('total');
            $total = ($subTotal + $shippingPrice);

            $resultToken = $this->createToken($total, 'user');

            if ($resultToken['error'] === true) {
                return $this->jsonErrorResponse('failed create snap token');
            }

            $snapToken = $resultToken['token'];
            $data_order = [
                'user_id' => auth()->id(),
                'date' => Carbon::now()->format('Y-m-d'),
                'reference_number' => 'PH-' . date('YmdHis'),
                'sub_total' => $subTotal,
                'shipping' => $shippingPrice,
                'total' => ($subTotal + $shippingPrice),
                'is_sent' => true,
                'shipping_city' => $shippingCity,
                'shipping_address' => $shippingAddress,
                'status' => 0,
                'snap_token' => null
            ];
            $order = Order::create($data_order);
            $orderID = $order->id;

            foreach ($carts as $cart) {
                $cart->update([
                    'order_id' => $orderID
                ]);
            }
            DB::commit();
            return $this->jsonSuccessResponse('success', [
                'snap_token' => $snapToken,
                'order_id' => $orderID
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonErrorResponse($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            Cart::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }

    private function createToken($total, $dataUser)
    {
        $payload = [
            'transaction_details' => [
                'order_id' => 'orders-' . date('YmdHis'),
                'gross_amount' => $total,
            ],
            'customer_details' => [
                'first_name' => 'user sadean',
                'email' => 'usersadean@gmail.com',
            ],
            'item_details' => [
                [
                    'id' => 1,
                    'price' => $total,
                    'quantity' => 1,
                    'name' => 'Order Payment ',
                    'brand' => 'Sadean Helm',
                    'category' => 'Helmet',
                    'merchant_name' => 'Nevermore',
                ],
            ],
        ];
        $error = true;
        $token = null;
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode('SB-Mid-server-YavqmAb3nBEECNiaFgfYXFYU') . ':'
            ])->withBody(json_encode($payload), 'application/json')->post('https://app.sandbox.midtrans.com/snap/v1/transactions');
            if ($response->successful()) {
                $bodyString = json_decode($response->body(), true);
                $token = $bodyString['token'];
                $error = false;
            }
            return [
                'error' => $error,
                'token' => $token,
                'message' => 'oke'
            ];
        } catch (\Exception $e) {
            return [
                'error' => $error,
                'token' => $token,
                'message' => $e->getMessage()
            ];
        }
    }

    public function check_token()
    {
        try {
            $payload = [
                'transaction_details' => [
                    'order_id' => 'orders-' . date('YmdHis'),
                    'gross_amount' => 100000,
                ],
                'customer_details' => [
                    'first_name' => 'joni',
                    'email' => 'joni@gmail.com',
                ],
                'item_details' => [
                    [
                        'id' => 1,
                        'price' => 100000,
                        'quantity' => 1,
                        'name' => 'Order Payment ',
                        'brand' => 'Sadean Helm',
                        'category' => 'Helmet',
                        'merchant_name' => 'Nevermore',
                    ],
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($payload);
            return $this->jsonSuccessResponse('success', $snapToken);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }
}
