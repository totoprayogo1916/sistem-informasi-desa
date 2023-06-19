<?php

namespace App\Controllers;

use Kenjis\CI3Compatible\Core\CI_Controller as BaseController;

class Analisis_kategori extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('analisis_kategori_model');
        $this->load->model('user_model');
        $this->load->model('header_model');
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== '1') {
            return redirect()->to('siteman');
        }
        $_SESSION['submenu']  = 'Data Kategori';
        $_SESSION['asubmenu'] = 'analisis_kategori';
    }

    public function clear()
    {
        session()->remove('cari');

        return redirect()->to('analisis_kategori');
    }

    public function leave()
    {
        $id = $_SESSION['analisis_master'];
        session()->remove('analisis_master');
        redirect("analisis_master/menu/{$id}");
    }

    public function index($p = 1, $o = 0)
    {
        session()->remove('cari2');
        $data['p'] = $p;
        $data['o'] = $o;

        if (isset($_SESSION['cari'])) {
            $data['cari'] = $_SESSION['cari'];
        } else {
            $data['cari'] = '';
        }

        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging']          = $this->analisis_kategori_model->paging($p, $o);
        $data['main']            = $this->analisis_kategori_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword']         = $this->analisis_kategori_model->autocomplete();
        $data['analisis_master'] = $this->analisis_kategori_model->get_analisis_master();
        $header                  = $this->header_model->get_data();

        echo view('header', $header);
        echo view('analisis_master/nav');
        echo view('analisis_kategori/table', $data);
        echo view('footer');
    }

    public function form($p = 1, $o = 0, $id = '')
    {
        $data['p'] = $p;
        $data['o'] = $o;

        if ($id) {
            $data['analisis_kategori'] = $this->analisis_kategori_model->get_analisis_kategori($id);
            $data['form_action']       = site_url("analisis_kategori/update/{$p}/{$o}/{$id}");
        } else {
            $data['analisis_kategori'] = null;
            $data['form_action']       = site_url('analisis_kategori/insert');
        }

        // view('header', $header);
        // view('analisis_master/nav');
        echo view('analisis_kategori/ajax_form', $data);
        // view('footer');
    }

    public function search()
    {
        $cari = $this->input->post('cari');
        if ($cari !== '') {
            $_SESSION['cari'] = $cari;
        } else {
            session()->remove('cari');
        }

        return redirect()->to('analisis_kategori');
    }

    public function insert()
    {
        $this->analisis_kategori_model->insert();

        return redirect()->to('analisis_kategori');
    }

    public function update($p = 1, $o = 0, $id = '')
    {
        $this->analisis_kategori_model->update($id);
        redirect("analisis_kategori/index/{$p}/{$o}");
    }

    public function delete($p = 1, $o = 0, $id = '')
    {
        $this->analisis_kategori_model->delete($id);
        redirect("analisis_kategori/index/{$p}/{$o}");
    }

    public function delete_all($p = 1, $o = 0)
    {
        $this->analisis_kategori_model->delete_all();
        redirect("analisis_kategori/index/{$p}/{$o}");
    }
}