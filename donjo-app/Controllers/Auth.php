<?php

namespace App\Controllers;

class Auth extends BaseController
{
    /**
     * Tampil halaman login
     */
    public function getView()
    {
        return view('auth/login');
    }

    /**
     * Proses login
     *
     */
    public function postLogin()
    {
    }

    protected function index()
    {
        $this->user_model->logout();
        $header = $this->header_model->get_config();

        if (! isset($_SESSION['siteman'])) {
            $_SESSION['siteman'] = 0;
        }
        $_SESSION['success']    = 0;
        $_SESSION['per_page']   = 10;
        $_SESSION['cari']       = '';
        $_SESSION['pengumuman'] = 0;
        $_SESSION['sesi']       = 'kosong';
        $_SESSION['timeout']    = 0;

        $this->load->view('siteman', $header);
        $_SESSION['siteman'] = 0;
    }

    protected function auth()
    {
        $this->config_model->do_reg();
        $this->user_model->siteman();
        redirect('main');
    }

    protected function login()
    {
        $this->user_model->logout();
        redirect('siteman');
    }
}
