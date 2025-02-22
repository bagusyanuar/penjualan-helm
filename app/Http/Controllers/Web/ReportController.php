<?php


namespace App\Http\Controllers\Web;


use App\Helper\CustomController;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class ReportController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function report_order()
    {
        if ($this->request->ajax()) {
            $start = $this->field('start');
            $end = $this->field('end');
            $data = Order::with([])
                ->where('status', '=', 4)
                ->whereBetween('date', [$start, $end])
                ->orderBy('updated_at', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('laporan.penjualan.index');
    }

    public function print_report_order()
    {
        $start = $this->field('start');
        $end = $this->field('end');
        $data = Order::with([])
            ->where('status', '=', 4)
            ->whereBetween('date', [$start, $end])
            ->orderBy('updated_at', 'ASC')
            ->get();
        return $this->convertToPdf('laporan.penjualan.cetak', [
            'data' => $data,
            'start' => $start,
            'end' => $end
        ]);
    }


    public function report_stock()
    {
        if ($this->request->ajax()) {
            $data = Product::with(['category'])
                ->orderBy('qty', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('laporan.stok.index');
    }

    public function print_report_stock()
    {
        $data = Product::with(['category'])
            ->orderBy('qty', 'ASC')
            ->get();
        return $this->convertToPdf('laporan.stok.cetak', [
            'data' => $data,
        ]);
    }

    public function report_customer()
    {
        if ($this->request->ajax()) {
            $data = Customer::with(['user'])
                ->get();
            return $this->basicDataTables($data);
        }
        return view('laporan.customer.index');
    }

    public function print_report_customer()
    {
        $data = Customer::with(['user'])
            ->get();
        return $this->convertToPdf('laporan.customer.cetak', [
            'data' => $data,
        ]);
    }
}
