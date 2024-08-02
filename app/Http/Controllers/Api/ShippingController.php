<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\ShippingCity;

class ShippingController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            $data = ShippingCity::with([])
                ->orderBy('created_at', 'DESC')
                ->get();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }
}
