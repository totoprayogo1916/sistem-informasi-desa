<?php

use App\Controllers\BaseController;

class Analisis_indikator extends BaseController
{
    public function __construct()
    {
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== '1') {
            redirect('siteman');
        }
        $_SESSION['submenu']  = 'Data Indikator';
        $_SESSION['asubmenu'] = 'analisis_indikator';
    }

    public function clear()
    {
        unset($_SESSION['cari'], $_SESSION['filter'], $_SESSION['tipe'], $_SESSION['kategori']);

        redirect('analisis_indikator');
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

        if (isset($_SESSION['filter'])) {
            $data['filter'] = $_SESSION['filter'];
        } else {
            $data['filter'] = '';
        }
        if (isset($_SESSION['tipe'])) {
            $data['tipe'] = $_SESSION['tipe'];
        } else {
            $data['tipe'] = '';
        }
        if (isset($_SESSION['kategori'])) {
            $data['kategori'] = $_SESSION['kategori'];
        } else {
            $data['kategori'] = '';
        }
        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging']          = $this->analisis_indikator_model->paging($p, $o);
        $data['main']            = $this->analisis_indikator_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword']         = $this->analisis_indikator_model->autocomplete();
        $data['analisis_master'] = $this->analisis_indikator_model->get_analisis_master();
        $data['list_tipe']       = $this->analisis_indikator_model->list_tipe();
        $data['list_kategori']   = $this->analisis_indikator_model->list_kategori();
        $header                  = $this->header_model->get_data();

        view('header', $header);
        view('analisis_master/nav');
        view('analisis_indikator/table', $data);
        view('footer');
    }

    public function form($p = 1, $o = 0, $id = '')
    {
        $data['p'] = $p;
        $data['o'] = $o;

        if ($id) {
            $data['analisis_indikator'] = $this->analisis_indikator_model->get_analisis_indikator($id);
            $data['form_action']        = site_url("analisis_indikator/update/{$p}/{$o}/{$id}");
        } else {
            $data['analisis_indikator'] = null;
            $data['form_action']        = site_url('analisis_indikator/insert');
        }

        $data['list_kategori']   = $this->analisis_indikator_model->list_kategori();
        $header                  = $this->header_model->get_data();
        $data['analisis_master'] = $this->analisis_indikator_model->get_analisis_master();

        view('header', $header);
        view('analisis_master/nav');
        view('analisis_indikator/form', $data);
        view('footer');
    }

    public function parameter($id = '')
    {
        $ai = $this->analisis_indikator_model->get_analisis_indikator($id);
        if ($ai['id_tipe'] === 3 || $ai['id_tipe'] === 4) {
            redirect('analisis_indikator');
        }

        $data['analisis_indikator'] = $this->analisis_indikator_model->get_analisis_indikator($id);
        $data['analisis_master']    = $this->analisis_indikator_model->get_analisis_master();
        $data['main']               = $this->analisis_indikator_model->list_indikator($id);

        $header = $this->header_model->get_data();

        view('header', $header);
        view('analisis_master/nav');
        view('analisis_indikator/parameter/table', $data);
        view('footer');
    }

    public function form_parameter($in = '', $id = '')
    {
        if ($id) {
            $data['analisis_parameter'] = $this->analisis_indikator_model->get_analisis_parameter($id);
            $data['form_action']        = site_url("analisis_indikator/p_update/{$in}/{$id}");
        } else {
            $data['analisis_parameter'] = null;
            $data['form_action']        = site_url("analisis_indikator/p_insert/{$in}");
        }

        $data['analisis_master']    = $this->analisis_indikator_model->get_analisis_master();
        $data['analisis_indikator'] = $this->analisis_indikator_model->get_analisis_indikator($in);

        //	view('header', $header);
        //	view('analisis_master/nav');
        view('analisis_indikator/parameter/ajax_form', $data);
        //	view('footer');
    }

    public function menu($id = '')
    {
        $data['analisis_indikator'] = $this->analisis_indikator_model->get_analisis_indikator($id);

        $header = $this->header_model->get_data();

        view('header', $header);
        view('analisis_master/nav');
        view('analisis_indikator/menu', $data);
        view('footer');
    }

    public function search()
    {
        $cari = $this->input->post('cari');
        if ($cari !== '') {
            $_SESSION['cari'] = $cari;
        } else {
            unset($_SESSION['cari']);
        }
        redirect('analisis_indikator');
    }

    public function filter()
    {
        $filter = $this->input->post('filter');
        if ($filter !== 0) {
            $_SESSION['filter'] = $filter;
        } else {
            unset($_SESSION['filter']);
        }
        redirect('analisis_indikator');
    }

    public function tipe()
    {
        $filter = $this->input->post('tipe');
        if ($filter !== 0) {
            $_SESSION['tipe'] = $filter;
        } else {
            unset($_SESSION['tipe']);
        }
        redirect('analisis_indikator');
    }

    public function kategori()
    {
        $filter = $this->input->post('kategori');
        if ($filter !== 0) {
            $_SESSION['kategori'] = $filter;
        } else {
            unset($_SESSION['kategori']);
        }
        redirect('analisis_indikator');
    }

    public function insert()
    {
        $this->analisis_indikator_model->insert();
        redirect('analisis_indikator');
    }

    public function update($p = 1, $o = 0, $id = '')
    {
        $this->analisis_indikator_model->update($id);
        redirect("analisis_indikator/index/{$p}/{$o}");
    }

    public function delete($p = 1, $o = 0, $id = '')
    {
        $this->analisis_indikator_model->delete($id);
        redirect("analisis_indikator/index/{$p}/{$o}");
    }

    public function delete_all($p = 1, $o = 0)
    {
        $this->analisis_indikator_model->delete_all();
        redirect("analisis_indikator/index/{$p}/{$o}");
    }

    public function p_insert($in = '')
    {
        $this->analisis_indikator_model->p_insert($in);
        redirect("analisis_indikator/parameter/{$in}");
    }

    public function p_update($in = '', $id = '')
    {
        $this->analisis_indikator_model->p_update($id);
        redirect("analisis_indikator/parameter/{$in}");
    }

    public function p_delete($in = '', $id = '')
    {
        $this->analisis_indikator_model->p_delete($id);
        redirect("analisis_indikator/parameter/{$in}");
    }

    public function p_delete_all()
    {
        $this->analisis_indikator_model->p_delete_all();
        redirect("analisis_indikator/parameter/{$in}");
    }
}
