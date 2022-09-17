<?php

namespace App\Controllers;

class Dokumen extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if (! in_array($grup, ['1', '2', '3', '4'], true)) {
            return redirect()->to('siteman');
        }
    }

    public function clear()
    {
        unset($_SESSION['cari'], $_SESSION['filter']);

        return redirect()->to('dokumen');
    }

    public function index($p = 1, $o = 0)
    {
        $data['p'] = $p;
        $data['o'] = $o;

        if (isset($_SESSION['cari'])) {
            $data['cari'] = $_SESSION['cari'];
        } else {
            $data['cari'] = '';
        }

        if (isset($_SESSION['filter'])) {
            $data['filter'] = $_SESSION['filter'];
        } else {
            $data['filter'] = '';
        }
        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging']  = $this->web_dokumen_model->paging($p, $o);
        $data['main']    = $this->web_dokumen_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword'] = $this->web_dokumen_model->autocomplete();
        $header          = $this->header_model->get_data();
        $nav['act']      = 4;

        echo view('header', $header);
        echo view('web/nav', $nav);
        echo view('dokumen/table', $data);
        echo view('footer');
    }

    public function form($p = 1, $o = 0, $id = '')
    {
        $data['p'] = $p;
        $data['o'] = $o;

        if ($id) {
            $data['dokumen']     = $this->web_dokumen_model->get_dokumen($id);
            $data['form_action'] = site_url("dokumen/update/{$id}/{$p}/{$o}");
        } else {
            $data['dokumen']     = null;
            $data['form_action'] = site_url('dokumen/insert');
        }

        $header = $this->header_model->get_data();

        $nav['act'] = 4;
        echo view('header', $header);
        echo view('web/nav', $nav);
        echo view('dokumen/form', $data);
        echo view('footer');
    }

    public function search()
    {
        $cari = $this->request->getPost('cari');
        if ($cari !== '') {
            $_SESSION['cari'] = $cari;
        } else {
            unset($_SESSION['cari']);
        }

        return redirect()->to('dokumen');
    }

    public function filter()
    {
        $filter = $this->request->getPost('filter');
        if ($filter !== 0) {
            $_SESSION['filter'] = $filter;
        } else {
            unset($_SESSION['filter']);
        }

        return redirect()->to('dokumen');
    }

    public function insert()
    {
        $this->web_dokumen_model->insert();

        return redirect()->to('dokumen');
    }

    public function update($id = '', $p = 1, $o = 0)
    {
        $this->web_dokumen_model->update($id);

        return redirect()->to("dokumen/index/{$p}/{$o}");
    }

    public function delete($p = 1, $o = 0, $id = '')
    {
        $this->web_dokumen_model->delete($id);

        return redirect()->to("dokumen/index/{$p}/{$o}");
    }

    public function delete_all($p = 1, $o = 0)
    {
        $this->web_dokumen_model->delete_all();

        return redirect()->to("dokumen/index/{$p}/{$o}");
    }

    public function dokumen_lock($id = '')
    {
        $this->web_dokumen_model->dokumen_lock($id, 1);

        return redirect()->to('dokumen/index/');
    }

    public function dokumen_unlock($id = '')
    {
        $this->web_dokumen_model->dokumen_lock($id, 2);

        return redirect()->to('dokumen/index/');
    }
}