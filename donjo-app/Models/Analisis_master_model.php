<?php

use App\Libraries\Paging;
use App\Models\BaseModel as Model;

class Analisis_master_model extends Model
{
    public function autocomplete()
    {
        $sql   = 'SELECT nama FROM analisis_master';
        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i    = 0;
        $outp = '';

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $outp .= ",'" . $data[$i]['nama'] . "'";
            $i++;
        }
        $outp = strtolower(substr($outp, 1));

        return '[' . $outp . ']';
    }

    public function search_sql()
    {
        if (isset($_SESSION['cari'])) {
            $cari = $_SESSION['cari'];
            $kw   = $this->db->escape_like_str($cari);
            $kw   = '%' . $kw . '%';

            return " AND (u.nama LIKE '{$kw}' OR u.nama LIKE '{$kw}')";
        }
    }

    public function filter_sql()
    {
        if (isset($_SESSION['filter'])) {
            $kf = $_SESSION['filter'];

            return " AND u.subjek_tipe = {$kf}";
        }
    }

    public function state_sql()
    {
        if (isset($_SESSION['state'])) {
            $kf = $_SESSION['state'];

            return " AND u.lock = {$kf}";
        }
    }

    public function paging($p = 1, $o = 0)
    {
        $paging = new Paging();

        $sql = 'SELECT COUNT(id) AS id FROM analisis_master u WHERE 1';
        $sql .= $this->search_sql();
        $sql .= $this->filter_sql();
        $sql .= $this->state_sql();
        $query    = $this->db->query($sql);
        $row      = $query->row_array();
        $jml_data = $row['id'];

        $cfg['page']     = $p;
        $cfg['per_page'] = $_SESSION['per_page'];
        $cfg['num_rows'] = $jml_data;

        $paging->init($cfg);

        return $paging;
    }

    public function list_data($o = 0, $offset = 0, $limit = 500)
    {
        switch ($o) {
            case 1: $order_sql = ' ORDER BY u.nama';
                break;

            case 2: $order_sql = ' ORDER BY u.nama DESC';
                break;

            case 3: $order_sql = ' ORDER BY u.nama';
                break;

            case 4: $order_sql = ' ORDER BY u.nama DESC';
                break;

            case 5: $order_sql = ' ORDER BY g.nama';
                break;

            case 6: $order_sql = ' ORDER BY g.nama DESC';
                break;

            default:$order_sql = ' ORDER BY u.id';
        }

        $paging_sql = ' LIMIT ' . $offset . ',' . $limit;

        $sql = 'SELECT u.*,s.subjek FROM analisis_master u LEFT JOIN analisis_ref_subjek s ON u.subjek_tipe = s.id WHERE 1 ';

        $sql .= $this->search_sql();
        $sql .= $this->filter_sql();
        $sql .= $this->state_sql();
        $sql .= $order_sql;
        $sql .= $paging_sql;

        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i = 0;
        $j = $offset;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['no'] = $j + 1;
            if ($data[$i]['lock'] === 1) {
                $data[$i]['lock'] = "<img src='" . base_url('assets/images/icon/unlock.png') . "'>";
            } else {
                $data[$i]['lock'] = "<img src='" . base_url('assets/images/icon/lock.png') . "'>";
            }

            $i++;
            $j++;
        }

        return $data;
    }

    public function insert()
    {
        $data = $_POST;
        $outp = $this->db->insert('analisis_master', $data);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function update($id = 0)
    {
        $data = $_POST;
        $this->db->where('id', $id);
        $outp = $this->db->update('analisis_master', $data);
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete($id = '')
    {
        $this->sub_delete($id);

        $sql  = 'DELETE FROM analisis_master WHERE id=?';
        $outp = $this->db->query($sql, [$id]);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete_all()
    {
        $id_cb = $_POST['id_cb'];

        if (is_countable($id_cb) ? count($id_cb) : 0) {
            foreach ($id_cb as $id) {
                $this->delete($id);
            }
            $outp = true;
        } else {
            $outp = false;
        }

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function sub_delete($id = '')
    {
        $sql = 'DELETE FROM analisis_parameter WHERE id_indikator IN(SELECT id FROM analisis_indikator WHERE id_master = ?)';
        $this->db->query($sql, $id);

        $sql = 'DELETE FROM analisis_respon WHERE id_periode IN(SELECT id FROM analisis_periode WHERE id_master=?)';
        $this->db->query($sql, $id);

        $sql = 'DELETE FROM analisis_kategori_indikator WHERE id_master=?';
        $this->db->query($sql, $id);

        $sql = 'DELETE FROM analisis_klasifikasi WHERE id_master=?';
        $this->db->query($sql, $id);

        $sql = 'DELETE FROM analisis_respon_hasil WHERE id_master=?';
        $this->db->query($sql, $id);

        $sql = 'DELETE FROM analisis_partisipasi WHERE id_master=?';
        $this->db->query($sql, $id);

        $sql = 'DELETE FROM analisis_periode WHERE id_master=?';
        $this->db->query($sql, $id);

        $sql = 'DELETE FROM analisis_indikator WHERE id_master=?';
        $this->db->query($sql, $id);
    }

    public function get_analisis_master($id = 0)
    {
        $sql   = 'SELECT * FROM analisis_master WHERE id=?';
        $query = $this->db->query($sql, $id);

        return $query->row_array();
    }

    public function list_subjek()
    {
        $sql   = 'SELECT * FROM analisis_ref_subjek';
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function list_kelompok()
    {
        $sql   = 'SELECT * FROM kelompok_master';
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function list_analisis_child()
    {
        $sql   = 'SELECT * FROM analisis_master WHERE subjek_tipe = 1';
        $query = $this->db->query($sql);

        return $query->result_array();
    }
}
