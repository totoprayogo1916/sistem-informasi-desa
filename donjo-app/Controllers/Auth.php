<?php

namespace App\Controllers;

use App\Models\ConfigModel;
use App\Models\User_model;

class Auth extends BaseController
{
    /**
     * Tampil halaman login
     */
    public function getView(): string
    {
        $config = new ConfigModel();
        $title  = 'Masuk';
        $desa   = $config->first();

        return view('auth/login', compact('title', 'desa'));
    }

    /**
     * Proses login
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function postLogin()
    {
        $validation = \Config\Services::validation();

        if ($this->request->getPost()) {
            // make rules validation for signin
            $validation->setRules([
                'username' => ['label' => 'nama pengguna', 'rules' => 'required'],
                'password' => ['label' => 'kata sandi', 'rules' => 'required'],
            ]);
        }

        if (! $validation->withRequest($this->request)->run()) {
            return $this->getView();
        }

        $userModel = new User_model();
        $username  = $this->request->getPost('username');
        $password  = $this->request->getPost('password');

        $getUser = $userModel->where(['username' => $username])->first();

        if ($getUser !== null) {
            if ($getUser->password === hash_password($password)) {
                $sesi_login = [
                    'userid'    => $getUser->id,
                    'username'  => $getUser->username,
                    'is_logged' => true,
                ];

                session()->set($sesi_login);

                return redirect()->to('admin/dasbor')->with('alert_success', 'Halo, selamat datang kembali.');
            }

            return redirect()->to('siteman')->with('alert_warning', 'Kata sandi/nama pengguna salah.');
        }

        return redirect()->to('siteman')->with('alert_danger', 'Harap coba dengan akun lain.');
    }
}
