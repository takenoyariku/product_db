<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request) {

        $credentials = $request->only('email', 'password');

        if(auth()->attempt($credentials)) {

            $user = auth()->user();
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            return ['token' => $token];

        }

        return response([
            'message' => 'Unauthenticated.'
        ], 401);

    }
}
