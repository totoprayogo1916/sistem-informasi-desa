<?php

use App\Controllers\BaseController;

class Program_bantuan extends BaseController
{
    public function __construct()
    {
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup === '1') {
            return;
        }
        if ($grup === '2') {
            return;
        }
        redirect('siteman');
    }

    public function index()
    {
        $header = $this->header_model->get_data();
        view('header', $header);
        $data['tampil']  = 0;
        $data['program'] = $this->program_bantuan_model->get_program(false);
        view('program_bantuan/program', $data);
        view('footer');
    }

    public function sasaran($sasaran = 0)
    {
        $header = $this->header_model->get_data();
        view('header', $header);

        $data['tampil']  = $sasaran;
        $data['program'] = $this->program_bantuan_model->list_program($sasaran);
        view('program_bantuan/program', $data);
        view('footer');
    }

    public function detail($id)
    {
        $header = $this->header_model->get_data();
        view('header', $header);
        if (isset($_POST['nik'])) {
            $data['individu'] = $this->program_bantuan_model->add_peserta($_POST['nik'], $id);
        } else {
            $data['individu'] = null;
        }
        $data['program'] = $this->program_bantuan_model->get_program($id);

        view('program_bantuan/detail', $data);
        view('footer');
    }

    public function peserta($cat = 0, $id = 0)
    {
        $header = $this->header_model->get_data();
        view('header', $header);
        $data['program'] = $this->program_bantuan_model->get_peserta_program($cat, $id);

        view('program_bantuan/peserta', $data);
        view('footer');
    }

    public function create()
    {
        $this->form_validation->set_rules('cid', 'Sasaran', 'required');
        $this->form_validation->set_rules('nama', 'Nama Program', 'required');
        $this->form_validation->set_rules('sdate', 'Tanggal awal', 'required');
        $this->form_validation->set_rules('edate', 'Tanggal akhir', 'required');
        $header = $this->header_model->get_data();
        view('header', $header);
        if ($this->form_validation->run() === false) {
            view('program_bantuan/create');
        } else {
            $this->program_bantuan_model->set_program();
            redirect('program_bantuan/');
        }
        view('footer');
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('cid', 'Sasaran', 'required');
        $this->form_validation->set_rules('nama', 'Nama Program', 'required');
        $this->form_validation->set_rules('sdate', 'Tanggal awal', 'required');
        $this->form_validation->set_rules('edate', 'Tanggal akhir', 'required');
        $header = $this->header_model->get_data();
        view('header', $header);
        $data['program'] = $this->program_bantuan_model->get_program($id);
        if ($this->form_validation->run() === false) {
            view('program_bantuan/edit', $data);
        } else {
            $this->program_bantuan_model->update_program($id);
            redirect('program_bantuan/');
        }

        view('footer');
    }

    public function update($id)
    {
        $this->program_bantuan_model->update_program($id);
        redirect('program_bantuan/detail/' . $id);
    }

    public function hapus($id)
    {
        $this->program_bantuan_model->hapus_program($id);
        // view('program_bantuan/formsuccess');
        redirect('program_bantuan/');
    }

    public function unduhsheet($id = 0)
    {
        if ($id > 0) {
            $data['desa']    = $this->header_model->get_data();
            $data['peserta'] = $this->program_bantuan_model->get_program($id);
            view('program_bantuan/unduh-sheet', $data);
        }
    }
}
