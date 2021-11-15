<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile');
    }

    public function update(Request $request)
    {
        $request->validate([
            'nip' => 'nullable|numeric|max:255|unique:users,nip,'.Auth::user()->id,
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,'.Auth::user()->id,
            'hp' => 'nullable|numeric|max:255|unique:users,hp,'.Auth::user()->id,
            'username' => 'required|string|max:255|unique:users,username,'.Auth::user()->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|max:12|required_with:current_password',
            'password_confirmation' => 'nullable|min:8|max:12|required_with:new_password|same:new_password',
        ]);

        $user = User::findOrFail(Auth::user()->id);
        $user->nip = $request->input('nip');
        $user->nama = $request->input('nama');
        $user->email = $request->input('email');
        $user->hp = $request->input('hp');
        $user->username = $request->input('username');

        if (! is_null($request->input('current_password'))) {
            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = Hash::make($request->input('new_password'));
            } else {
                return redirect()->back()->withInput();
            }
        }

        $user->save();

        return redirect()->route('profile');
    }
}
