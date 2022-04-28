<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Analisis_respon_penduduk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('analisis_respon_penduduk_model');
        $this->load->model('user_model');
        $this->load->model('header_model');
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== 1) {
            redirect('siteman');
        }
    }

    public function clear($id = 0)
    {
        $_SESSION['analisis_master'] = $id;
        unset($_SESSION['cari']);
        $_SESSION['per_page'] = 50;
        redirect('analisis_respon_penduduk');
    }

    public function leave()
    {
        $id = $_SESSION['analisis_master'];
        unset($_SESSION['analisis_master']);
        redirect("analisis_master/menu/{$id}");
    }

    public function index($p = 1, $o = 0)
    {
        unset($_SESSION['cari2']);
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

        $data['paging']           = $this->analisis_respon_penduduk_model->paging($p, $o);
        $data['main']             = $this->analisis_respon_penduduk_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword']          = $this->analisis_respon_penduduk_model->autocomplete();
        $data['analisis_master']  = $this->analisis_respon_penduduk_model->get_analisis_master();
        $data['analisis_periode'] = $this->analisis_respon_penduduk_model->get_periode();

        $header = $this->header_model->get_data();

        $this->load->view('header', $header);
        $this->load->view('analisis_master/nav');
        $this->load->view('analisis_respon_penduduk/table', $data);
        $this->load->view('footer');
    }

    public function kuisioner($p = 1, $o = 0, $id = '')
    {
        $data['p'] = $p;
        $data['o'] = $o;

        $data['analisis_master'] = $this->analisis_respon_penduduk_model->get_analisis_master();
        $data['subjek']          = $this->analisis_respon_penduduk_model->get_subjek($id);
        $data['list_jawab']      = $this->analisis_respon_penduduk_model->list_indikator($id);
        $data['form_action']     = site_url("analisis_respon_penduduk/update_kuisioner/{$p}/{$o}/{$id}");

        $header = $this->header_model->get_data();
        $this->load->view('header', $header);
        $this->load->view('analisis_master/nav');
        $this->load->view('analisis_respon_penduduk/manajemen_kuisioner_form', $data);
        $this->load->view('footer');
    }

    public function update_kuisioner($p = 1, $o = 0, $id = '')
    {
        $this->analisis_respon_penduduk_model->update_kuisioner($id);
        redirect("analisis_respon_penduduk/index/{$p}/{$o}");
    }

    public function form($p = 1, $o = 0, $id = '')
    {
        $data['p'] = $p;
        $data['o'] = $o;

        if ($id) {
            $data['analisis_respon_penduduk'] = $this->analisis_respon_penduduk_model->get_analisis_respon_penduduk($id);
            $data['form_action']              = site_url("analisis_respon_penduduk/update/{$p}/{$o}/{$id}");
        } else {
            $data['analisis_respon_penduduk'] = null;
            $data['form_action']              = site_url('analisis_respon_penduduk/insert');
        }

        $header                  = $this->header_model->get_data();
        $data['analisis_master'] = $this->analisis_respon_penduduk_model->get_analisis_master();

        $this->load->view('header', $header);
        $this->load->view('analisis_master/nav');
        $this->load->view('analisis_respon_penduduk/form', $data);
        $this->load->view('footer');
    }

    public function search()
    {
        $cari = $this->input->post('cari');
        if ($cari !== '') {
            $_SESSION['cari'] = $cari;
        } else {
            unset($_SESSION['cari']);
        }
        redirect('analisis_respon_penduduk');
    }

    public function insert()
    {
        $this->analisis_respon_penduduk_model->insert();
        redirect('analisis_respon_penduduk');
    }

    public function update($p = 1, $o = 0, $id = '')
    {
        $this->analisis_respon_penduduk_model->update($id);
        redirect("analisis_respon_penduduk/index/{$p}/{$o}");
    }

    public function delete($p = 1, $o = 0, $id = '')
    {
        $this->analisis_respon_penduduk_model->delete($id);
        redirect("analisis_respon_penduduk/index/{$p}/{$o}");
    }

    public function delete_all($p = 1, $o = 0)
    {
        $this->analisis_respon_penduduk_model->delete_all();
        redirect("analisis_respon_penduduk/index/{$p}/{$o}");
    }
}