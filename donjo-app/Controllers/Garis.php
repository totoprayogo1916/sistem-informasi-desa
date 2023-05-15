<?php

namespace App\Controllers;

use Kenjis\CI3Compatible\Core\CI_Controller as BaseController;

class Garis extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('config_model');
        $this->load->model('header_model');
        $this->load->model('plan_garis_model');
    }

    public function clear()
    {
        session()->remove(['cari', 'filter', 'line', 'subline']);

        return redirect()->to('garis');
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
        if (isset($_SESSION['line'])) {
            $data['line'] = $_SESSION['line'];
        } else {
            $data['line'] = '';
        }
        if (isset($_SESSION['subline'])) {
            $data['subline'] = $_SESSION['subline'];
        } else {
            $data['subline'] = '';
        }
        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging']       = $this->plan_garis_model->paging($p, $o);
        $data['main']         = $this->plan_garis_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword']      = $this->plan_garis_model->autocomplete();
        $data['list_line']    = $this->plan_garis_model->list_line();
        $data['list_subline'] = $this->plan_garis_model->list_subline();
        $header               = $this->header_model->get_data();
        $nav['act']           = 1;

        echo view('header-gis', $header);
        echo view('plan/nav', $nav);
        echo view('garis/table', $data);
        echo view('footer');
    }

    public function form($p = 1, $o = 0, $id = '')
    {
        $data['desa']      = $this->config_model->get_data();
        $data['list_line'] = $this->plan_garis_model->list_line();
        $data['dusun']     = $this->plan_garis_model->list_dusun();

        if ($id) {
            $data['garis']       = $this->plan_garis_model->get_garis($id);
            $data['form_action'] = site_url("garis/update/{$id}/{$p}/{$o}");
        } else {
            $data['garis']       = null;
            $data['form_action'] = site_url('garis/insert');
        }
        $header = $this->header_model->get_data();

        $nav['act'] = 1;
        echo view('header-gis', $header);

        echo view('plan/nav', $nav);
        echo view('garis/form', $data);
        echo view('footer');
    }

    public function ajax_garis_maps($p = 1, $o = 0, $id = '')
    {
        $data['p'] = $p;
        $data['o'] = $o;
        if ($id) {
            $data['garis'] = $this->plan_garis_model->get_garis($id);
        } else {
            $data['garis'] = null;
        }

        $data['desa']        = $this->config->get_data();
        $data['form_action'] = site_url("garis/update_maps/{$p}/{$o}/{$id}");
        echo view('garis/maps', $data);
    }

    public function update_maps($p = 1, $o = 0, $id = '')
    {
        $this->plan_garis_model->update_position($id);
        redirect("garis/index/{$p}/{$o}");
    }

    public function search()
    {
        $cari = $this->input->post('cari');
        if ($cari !== '') {
            $_SESSION['cari'] = $cari;
        } else {
            session()->remove('cari');
        }

        return redirect()->to('garis');
    }

    public function filter()
    {
        $filter = $this->input->post('filter');
        if ($filter !== 0) {
            $_SESSION['filter'] = $filter;
        } else {
            session()->remove('filter');
        }

        return redirect()->to('garis');
    }

    public function line()
    {
        $line = $this->input->post('line');
        if ($line !== 0) {
            $_SESSION['line'] = $line;
        } else {
            session()->remove('line');
        }

        return redirect()->to('garis');
    }

    public function subline()
    {
        session()->remove('line');
        $subline = $this->input->post('subline');
        if ($subline !== 0) {
            $_SESSION['subline'] = $subline;
        } else {
            session()->remove('subline');
        }

        return redirect()->to('garis');
    }

    public function insert($tip = 1)
    {
        $this->plan_garis_model->insert($tip);
        redirect("garis/index/{$tip}");
    }

    public function update($id = '', $p = 1, $o = 0)
    {
        $this->plan_garis_model->update($id);
        redirect("garis/index/{$p}/{$o}");
    }

    public function delete($p = 1, $o = 0, $id = '')
    {
        $this->plan_garis_model->delete($id);
        redirect("garis/index/{$p}/{$o}");
    }

    public function delete_all($p = 1, $o = 0)
    {
        $this->plan_garis_model->delete_all();
        redirect("garis/index/{$p}/{$o}");
    }

    public function garis_lock($id = '')
    {
        $this->plan_garis_model->garis_lock($id, 1);
        redirect("garis/index/{$p}/{$o}");
    }

    public function garis_unlock($id = '')
    {
        $this->plan_garis_model->garis_lock($id, 2);
        redirect("garis/index/{$p}/{$o}");
    }
}