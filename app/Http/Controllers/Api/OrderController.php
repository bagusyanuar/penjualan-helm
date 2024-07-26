<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Order;

class OrderController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            $userID = auth()->id();
            $orders = Order::with([])
                ->where('user_id', '=', $userID)
                ->orderBy('created_at', 'DESC')
                ->get();
            return $this->jsonSuccessResponse('success', $orders);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }

    public function findByID($id)
    {
        try {
            $order = Order::with([])
                ->where('id', '=', $id)
                ->first();
            return $this->jsonSuccessResponse('success', $order);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }
}
