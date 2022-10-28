<?php

namespace App\Models;

use CodeIgniter\Model as CI_Model;

class Apis extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function view($page = 'indeks')
    {
        if (! file_exists(APPPATH . '/views/apis/' . $page . '.php')) {
            echo $page;
        }
    }
}
