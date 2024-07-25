<?php


namespace App\Http\Controllers\Web;


use App\Helper\CustomController;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = User::with([])
                ->where('role', '!=', 'customer')
                ->where('role', '!=', 'owner')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('users.index');
    }

    public function add()
    {
        if ($this->request->method() === 'POST') {
            return $this->store();
        }
        return view('users.add');
    }

    public function edit($id)
    {
        $data = User::with([])
            ->findOrFail($id);
        if ($this->request->method() === 'POST') {
            return $this->patch($data);
        }
        return view('users.edit')->with(['data' => $data]);
    }

    public function delete($id)
    {
        try {
            User::destroy($id);
            return $this->jsonSuccessResponse('Berhasil menghapus data...');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse();
        }
    }

    private $rule = [
        'password' => 'required',
        'username' => 'required',
    ];

    private $message = [
        'username.required' => 'kolom username wajib diisi',
        'password.required' => 'kolom password wajib diisi',
    ];

    private function store()
    {
        try {
            $validator = Validator::make($this->request->all(), $this->rule, $this->message);
            if ($validator->fails()) {
                return redirect()->back()->with('failed', 'please filled correct field')->withErrors($validator)->withInput();
            }
            $data_user = [
                'username' => $this->postField('username'),
                'password' => Hash::make($this->postField('password')),
                'role' => 'admin',
            ];

            User::create($data_user);
            return redirect()->back()->with('success', 'Successfully create user');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('failed', 'internal server error...');
        }
    }

    /**
     * @param Model $data
     * @return \Illuminate\Http\RedirectResponse
     */
    private function patch($data)
    {
        try {
            $newRule = Arr::except($this->rule, ['password']);
            $validator = Validator::make($this->request->all(), $newRule, $this->message);
            if ($validator->fails()) {
                return redirect()->back()->with('failed', 'please filled correct field')->withErrors($validator)->withInput();
            }
            $data_user = [
                'username' => $this->postField('username'),
            ];

            if ($this->postField('password') !== '') {
                $data_user['password'] = Hash::make($this->postField('password'));
            }


            $data->update($data_user);
            return redirect()->back()->with('success', 'Successfully patch user');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('failed', 'internal server error...');
        }
    }
}
