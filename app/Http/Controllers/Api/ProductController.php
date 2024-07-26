<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Product;

class ProductController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            $data = Product::with(['category'])
                ->orderBy('name', 'ASC')
                ->get();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }

    public function findByID($id)
    {
        try {
            $data = Product::with(['category'])
                ->where('id', '=', $id)
                ->first();
            if (!$data) {
                return $this->jsonNotFoundResponse('item not found...');
            }
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }
}
