<?php


namespace App\Http\Controllers\Web;


use App\Helper\CustomController;
use App\Models\Category;
use App\Models\ShippingCity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ShippingController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = ShippingCity::with([])
                ->orderBy('created_at', 'DESC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('shippings.index');
    }

    public function add()
    {
        if ($this->request->method() === 'POST') {
            return $this->store();
        }
        return view('shippings.add');
    }

    public function edit($id)
    {
        $data = ShippingCity::with([])
            ->findOrFail($id);
        if ($this->request->method() === 'POST') {
            return $this->patch($data);
        }
        return view('shippings.edit')->with(['data' => $data]);
    }

    public function delete($id)
    {
        try {
            ShippingCity::destroy($id);
            return $this->jsonSuccessResponse('Berhasil menghapus data...');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse();
        }
    }

    private $rule = [
        'city' => 'required',
        'price' => 'required',
    ];

//    private $message = [
//        'city.required' => 'kolom nama wajib diisi',
//        'price.required' => 'kolom price wajib diisi',
//    ];


    private function store()
    {
        try {
            $validator = Validator::make($this->request->all(), $this->rule);
            if ($validator->fails()) {
                return redirect()->back()->with('failed', 'please fill with correct value')->withErrors($validator)->withInput();
            }
            $data_request = $this->getDataRequest();
            ShippingCity::create($data_request);
            return redirect()->back()->with('success', 'Successfully create shipping setting');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('failed', 'internal server error..');
        }
    }

    /**
     * @param $data Model
     * @return \Illuminate\Http\RedirectResponse
     */
    private function patch($data)
    {
        try {
            $validator = Validator::make($this->request->all(), $this->rule);
            if ($validator->fails()) {
                return redirect()->back()->with('failed', 'please fill with correct value')->withErrors($validator)->withInput();
            }
            $data_request = $this->getDataRequest();
            $data->update($data_request);
            return redirect()->back()->with('success', 'Successfully patch shipping setting');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('failed', 'internal server error');
        }
    }

    private function getDataRequest()
    {
        return [
            'city' => $this->postField('city'),
            'price' => $this->postField('price'),
        ];
    }
}
