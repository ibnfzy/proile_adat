<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to('/Admin');
        }

        return view('auth/login', [
            'pageTitle' => 'Masuk Admin',
        ]);
    }

    public function authenticate()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = (string) $this->request->getPost('username');
        $password = (string) $this->request->getPost('password');

        $user = $this->userModel->where('username', $username)->first();

        if (! $user) {
            return redirect()->back()->withInput()->with('error', 'Username atau password tidak valid.');
        }

        $storedPassword = (string) $user['password'];
        $isValidPassword = password_verify($password, $storedPassword) || hash_equals($storedPassword, $password);

        if (! $isValidPassword) {
            return redirect()->back()->withInput()->with('error', 'Username atau password tidak valid.');
        }

        $this->session->set([
            'userId'      => $user['id'],
            'username'    => $user['username'],
            'namaLengkap' => $user['nama_lengkap'] ?? $user['username'],
            'email'       => $user['email'] ?? null,
            'role'        => $user['role'] ?? null,
            'isLoggedIn'  => true,
        ]);

        return redirect()->to('/Admin')->with('message', 'Selamat datang kembali, ' . ($user['nama_lengkap'] ?? $user['username']) . '!');
    }

    public function logout()
    {
        $this->session->destroy();

        return redirect()->to('/login')->with('message', 'Anda telah keluar dari sesi.');
    }
}
