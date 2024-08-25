<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Category;
use App\Models\Product;

class CategoriesController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            $data = Category::with([])
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
            $data = Category::with([])
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

    public function productByCategoryID($id)
    {
        try {
            $param = $this->field('param');
            $data = Product::with([])
                ->where('category_id', '=', $id)
                ->where('name', 'LIKE', '%' . $param . '%')
                ->orderBy('name', 'ASC')
                ->get();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }
}
