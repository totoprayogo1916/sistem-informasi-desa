<?php

namespace App\Controllers;

class Install extends BaseController
{
    public function index()
    {
        $data = [];

        return view('publik/install', $data);
    }
}
