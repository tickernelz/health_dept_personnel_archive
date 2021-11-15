<?php

namespace App\Http\Controllers;

use Auth;
use Session;

class AuthController extends Controller
{
    public function formlogin()
    {
        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            return redirect()->route('home');
        }

        return view('auth.login');
    }
}
