<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Validator;

class PenggunaController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();

        return view('kelola.pengguna.list', [
            'title' => 'List Pengguna',
            'users' => $users,
        ]);
    }

    public function create()
    {
        $roles = Role::all();

        return view('kelola.pengguna.create', [
            'title' => 'Tambah Pengguna',
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'nip' => 'nullable|numeric|unique:users',
            'nama' => 'required|string',
            'email' => 'nullable|email|unique:users',
            'hp' => 'nullable|numeric|unique:users',
            'peran' => 'required|string',
            'username' => 'required|string|unique:users',
            'password' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        User::create([
            'nip' => $request->input('nip'),
            'nama' => $request->input('nama'),
            'email' => $request->input('email'),
            'hp' => $request->input('hp'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
        ])->assignRole($request->input('peran'));

        return redirect()->route('pengguna.index')->with('message', 'Data Berhasil Ditambahkan!');
    }

    public function show($id)
    {
        //
    }

    public function edit(int $id)
    {
        $roles = Role::all();
        $user = User::with('roles')->firstWhere('id', $id);

        return view('kelola.pengguna.edit', [
            'title' => 'Edit Pengguna',
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $user = User::with('roles')->firstWhere('id', $id);

        $rules = [
            'nip' => 'nullable|numeric|unique:users,nip,'.$user->id,
            'nama' => 'required|string',
            'email' => 'nullable|email|unique:users,email,'.$user->id,
            'hp' => 'nullable|numeric|unique:users,hp,'.$user->id,
            'peran' => 'required|string',
            'username' => 'required|string|unique:users,username,'.$user->id,
            'password' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->nip = $request->input('nip');
        $user->nama = $request->input('nama');
        $user->email = $request->input('email');
        $user->hp = $request->input('hp');
        $user->username = $request->input('username');
        $user->save();
        $user->assignRole($request->input('peran'));

        return redirect()->route('pengguna.index')->with('message', 'Data Berhasil Diperbarui!');
    }

    public function destroy(int $id)
    {
        $user = User::with('roles')->firstWhere('id', $id);
        $user->delete();

        return redirect()->route('pengguna.index')->with('message', 'Data Berhasil Dihapus!');
    }
}
