<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register()
    {
        $data = $this->registerValidation();
        $user = User::create($data);
        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    public function login()
    {
        $data = $this->registerValidation();

        if (!$token = auth()->attempt($data)) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    protected function registerValidation()
    {
        return request()->validate([
            'username' => 'string|required',
            'password' => 'required'
        ]);
    }
}
