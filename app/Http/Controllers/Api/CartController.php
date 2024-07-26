<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingCity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CartController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            if ($this->request->method() === 'POST') {
                return $this->store();
            }
            $data = Cart::with(['product'])
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
            $carts = Cart::with([])
                ->where('user_id', '=', auth()->id())
                ->whereNull('order_id')
                ->get();


            if (count($carts) <= 0) {
                return $this->jsonBadRequestResponse('no cart attached');
            }

            $shippingID = $this->postField('shipping_id');
            $isSent = $this->postField('is_sent');

            $shippingPrice = 0;
            $shippingAddress = '-';
            $shippingCity = '';

            if ($isSent === '1') {
                $shipping = ShippingCity::with([])
                    ->where('id', '=', $shippingID)
                    ->first();

                if (!$shipping) {
                    return $this->jsonNotFoundResponse('shipping not found');
                }

                $shippingPrice = $shipping->price;
                $shippingCity = $shipping->city;
                $shippingAddress = $this->postField('address');
            }

            $subTotal = $carts->sum('total');
            $data_order = [
                'user_id' => auth()->id(),
                'date' => Carbon::now()->format('Y-m-d'),
                'reference_number' => 'PH-' . date('YmdHis'),
                'sub_total' => $subTotal,
                'shipping' => $shippingPrice,
                'total' => ($subTotal + $shippingPrice),
                'is_sent' => $this->postField('is_sent'),
                'shipping_city' => $shippingCity,
                'shipping_address' => $shippingAddress,
                'status' => 0
            ];
            $order = Order::create($data_order);
            $orderID = $order->id;

            foreach ($carts as $cart) {
                $cart->update([
                    'order_id' => $orderID
                ]);
            }
            DB::commit();
            return $this->jsonSuccessResponse('success');
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
}
