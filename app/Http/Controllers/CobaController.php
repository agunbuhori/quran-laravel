<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CobaController extends Controller
{
    public function index()
    {
        return [
            "token" => Str::random(100)
        ];
    }

    public function login(Request $request)
    {

        $request->validate([
            "email" => "required",
            "password" => "required"
        ]);

        if (auth()->attempt($request->only('email', 'password'))) {
            return [
                "message" => "Login sukses",
                "token" => auth()->user()->createToken('Token Name')->accessToken
            ];
        }

        return response()->json(['message' => "login gagal"], 401);
    }

    public function logout()
    {
        return auth()->logout();
    }
}
