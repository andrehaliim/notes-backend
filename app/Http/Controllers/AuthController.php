<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use Config;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RecruiterLoginRequest;
use App\Http\Traits\ApiResponse;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(LoginRequest $request) {
        $rules_array = collect(Config::get('boilerplate.user_login.validation_rules'));
        $rule_keys = $rules_array->keys()->toArray();

        $params = $request->only($rule_keys);
        $user = User::where('username', $params['username'])->first();

        $is_valid_password = $user ? Hash::check($params['password'], $user->password) : false;
        if ($user && $is_valid_password) {
            Auth::login($user);
            return $this->success([
              'token' => auth()->user()->createToken('API Token')->plainTextToken
            ]);
        } else {
            throw new HttpException(400, 'Invalid email or password !');
        }

        return $this->success($params);
    }

    public function me()
    {
        $result = (object)['id' => '', 'nik'  => '', 'name'  => ''];
        $user = User::find(Auth::id());
        $result->id = $user->uid;
        $result->name = $user->name;
        $result->nik = $user->nik;

        return $this->success($result);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }
}