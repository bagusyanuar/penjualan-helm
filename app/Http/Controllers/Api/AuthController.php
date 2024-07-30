<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function register()
    {
        try {
            DB::beginTransaction();
            $username = $this->postField('username');
            $password = Hash::make($this->postField('password'));
            $name = $this->postField('name');
            $phone = $this->postField('phone');

            $data_user = [
                'username' => $username,
                'password' => $password,
                'role' => 'customer'
            ];

            $user = User::create($data_user);

            $data_customer = [
                'user_id' => $user->id,
                'name' => $name,
                'phone' => $phone
            ];

            Customer::create($data_customer);
            $token = auth('api')->setTTL(null)->tokenById($user->id);
            DB::commit();
            return $this->jsonSuccessResponse('success', [
                'access_token' => $token
            ]);
        }catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonErrorResponse($e->getMessage());
        }
    }

    public function login()
    {
        try {
            $username = $this->postField('username');
            $password = $this->postField('password');

            $user = User::with([])
                ->where('username', '=', $username)
                ->first();
            if (!$user) {
                return $this->jsonNotFoundResponse('user not found!');
            }

            $isPasswordValid = Hash::check($password, $user->password);
            if (!$isPasswordValid) {
                return $this->jsonUnauthorizedResponse('username and password did not match...');
            }

            $token = auth('api')->setTTL(null)->tokenById($user->id);
            return $this->jsonSuccessResponse('success', [
                'access_token' => $token
            ]);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }
}
