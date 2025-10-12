<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;
use App\Models\GaleriModel;
use App\Models\InformasiModel;
use App\Models\UserModel;

class AdminController extends BaseController
{
    public function index()
    {
        $artikelModel   = new ArtikelModel();
        $informasiModel = new InformasiModel();
        $galeriModel    = new GaleriModel();

        return view('admin/index', [
            'pageTitle'      => 'Dashboard',
            'artikelCount'   => $artikelModel->countAll(),
            'informasiCount' => $informasiModel->countAll(),
            'galeriCount'    => $galeriModel->countAll(),
        ]);
    }

    public function updateProfile()
    {
        if (! $this->session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'username'     => 'required|min_length[3]',
            'email'        => 'required|valid_email',
            'password'     => 'permit_empty|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->to('/Admin')
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('openSettingsModal', true);
        }

        $userId = (int) $this->session->get('userId');

        if (! $userId) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();

        $data = [
            'nama_lengkap' => (string) $this->request->getPost('nama_lengkap'),
            'username'     => (string) $this->request->getPost('username'),
            'email'        => (string) $this->request->getPost('email'),
        ];

        $password = (string) $this->request->getPost('password');

        if ($password !== '') {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        try {
            $updated = $userModel->update($userId, $data);
        } catch (\Throwable $exception) {
            return redirect()
                ->to('/Admin')
                ->withInput()
                ->with('openSettingsModal', true)
                ->with('errors', ['Terjadi kesalahan saat menyimpan data.'])
                ->with('error', 'Gagal memperbarui data pengguna. Silakan coba lagi.');
        }

        if (! $updated) {
            $modelErrors = $userModel->errors();

            return redirect()
                ->to('/Admin')
                ->withInput()
                ->with('openSettingsModal', true)
                ->with('errors', ! empty($modelErrors) ? $modelErrors : ['Gagal memperbarui data pengguna.'])
                ->with('error', 'Gagal memperbarui data pengguna. Silakan periksa kembali data Anda.');
        }

        $this->session->set([
            'username'    => $data['username'],
            'namaLengkap' => $data['nama_lengkap'],
            'email'       => $data['email'],
        ]);

        return redirect()->to('/Admin')->with('message', 'Informasi akun berhasil diperbarui.');
    }
}
