<?php


namespace App\Http\Controllers\Web;


use App\Helper\CustomController;

class DashboardController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('dashboard');
    }

}
