<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(UserRequest $request)
    {
        return "Login berhasil!";
    }

    public function submit(UserRequest $request)
    {
        return "Login berhasil!";
    }
}

