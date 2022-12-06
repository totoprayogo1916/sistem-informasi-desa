<?php

namespace App\Controllers;

use App\Libraries\Install;

class Main extends BaseController
{
    public function __construct()
    {
        // $this->load->model('header_model');
        // $this->load->model('user_model');
        // $this->load->model('config_model');
    }

    public function index()
    {
        // code...
    }

    public function install()
    {
        $install = new Install();
        $out     = $install->run();

        if (null === $out) {
            redirect('/');
        }

        view('init', $out);
    }

    public function init($out = null)
    {
        view('init', $out);
    }

    public function auth()
    {
        $this->user_model->login();
        $header = [
            'desa' => $this->config_model->get_data(),
        ];
        view('siteman', $header);
    }

    public function logout()
    {
        $this->config_model->opt();
        $this->user_model->logout();
        $header = [
            'desa' => $this->config_model->get_data(),
        ];

        view('siteman', $header);
    }
}
