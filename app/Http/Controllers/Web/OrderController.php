<?php


namespace App\Http\Controllers\Web;


use App\Helper\CustomController;
use App\Models\Cart;
use App\Models\Order;

class OrderController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $status = $this->field('status');
            $data = [];
            if ($status === '1') {
                $data = Order::with([])
                    ->where('status', '=', 1)
                    ->orderBy('updated_at', 'ASC')
                    ->get();
            }

            if ($status === '2') {
                $data = Order::with([])
                    ->where('status', '=', 2)
                    ->orderBy('updated_at', 'ASC')
                    ->get();
            }

            if ($status === '3') {
                $data = Order::with([])
                    ->where('status', '=', 3)
                    ->orderBy('updated_at', 'ASC')
                    ->get();
            }

            if ($status === '4') {
                $data = Order::with([])
                    ->where('status', '=', 4)
                    ->orderBy('updated_at', 'ASC')
                    ->get();
            }

            return $this->basicDataTables($data);
        }
        return view('order.index');
    }

    public function detail_new($id)
    {
        if ($this->request->ajax()) {
            if ($this->request->method() === 'POST') {
                return $this->submit_to_packing($id);
            }
            $data = Cart::with(['product'])
                ->where('order_id', '=', $id)
                ->get();
            return $this->basicDataTables($data);
        }
        $data = Order::with(['cart'])
            ->findOrFail($id);
        return view('order.detail.new')->with([
            'data' => $data
        ]);
    }

    public function detail_packing($id)
    {
        if ($this->request->ajax()) {
            if ($this->request->method() === 'POST') {
                return $this->submit_to_sent($id);
            }
            $data = Cart::with(['product'])
                ->where('order_id', '=', $id)
                ->get();
            return $this->basicDataTables($data);
        }
        $data = Order::with(['cart'])
            ->findOrFail($id);
        return view('order.detail.packing')->with([
            'data' => $data
        ]);
    }

    public function detail_sent($id)
    {
        if ($this->request->ajax()) {
            if ($this->request->method() === 'POST') {
                return $this->submit_to_finish($id);
            }
            $data = Cart::with(['product'])
                ->where('order_id', '=', $id)
                ->get();
            return $this->basicDataTables($data);
        }
        $data = Order::with(['cart'])
            ->findOrFail($id);
        return view('order.detail.sent')->with([
            'data' => $data
        ]);
    }

    public function detail_finish($id)
    {
        if ($this->request->ajax()) {
            $data = Cart::with(['product'])
                ->where('order_id', '=', $id)
                ->get();
            return $this->basicDataTables($data);
        }
        $data = Order::with(['cart'])
            ->findOrFail($id);
        return view('order.detail.finish')->with([
            'data' => $data
        ]);
    }

    private function submit_to_packing($id)
    {
        try {
            $order = Order::with([])
                ->where('id', '=', $id)
                ->first();
            if (!$order) {
                return $this->jsonNotFoundResponse('data tidak ditemukan...');
            }
            $data_request_order = [
                'status' => 2,
            ];

            $order->update($data_request_order);
            return $this->jsonSuccessResponse('success', 'Berhasil merubah data pesanan...');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }

    private function submit_to_sent($id)
    {
        try {
            $order = Order::with([])
                ->where('id', '=', $id)
                ->first();
            if (!$order) {
                return $this->jsonNotFoundResponse('data tidak ditemukan...');
            }
            $data_request_order = [
                'status' => 3,
            ];

            $order->update($data_request_order);
            return $this->jsonSuccessResponse('success', 'Berhasil merubah data pesanan...');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }

    private function submit_to_finish($id)
    {
        try {
            $order = Order::with([])
                ->where('id', '=', $id)
                ->first();
            if (!$order) {
                return $this->jsonNotFoundResponse('data tidak ditemukan...');
            }
            $data_request_order = [
                'status' => 4,
            ];

            $order->update($data_request_order);
            return $this->jsonSuccessResponse('success', 'Berhasil merubah data pesanan...');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }
}
