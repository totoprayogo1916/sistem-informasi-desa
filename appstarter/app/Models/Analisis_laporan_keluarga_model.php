<?php

class Analisis_laporan_keluarga_model extends Model
{
    public function autocomplete()
    {
        $sql = 'SELECT no_kk FROM tweb_keluarga
		UNION SELECT t.nama FROM tweb_keluarga u LEFT JOIN tweb_penduduk t ON u.nik_kepala = t.id LEFT JOIN tweb_wil_clusterdesa c ON t.id_cluster = c.id WHERE 1  ';
        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i    = 0;
        $outp = '';

        while ($i < count($data)) {
            $outp .= ',"' . $data[$i]['no_kk'] . '"';
            $i++;
        }
        $outp = strtolower(substr($outp, 1));

        return '[' . $outp . ']';
    }

    public function search_sql()
    {
        if (isset($_SESSION['cari'])) {
            $cari       = $_SESSION['cari'];
            $kw         = $this->db->escape_like_str($cari);
            $kw         = '%' . $kw . '%';
            $search_sql = " AND (u.no_kk LIKE '{$kw}' OR p.nama LIKE '{$kw}')";

            return $search_sql;
        }
    }

    public function master_sql()
    {
        if (isset($_SESSION['analisis_master'])) {
            $kf         = $_SESSION['analisis_master'];
            $filter_sql = " AND u.id_master = {$kf}";

            return $filter_sql;
        }
    }

    public function dusun_sql()
    {
        if (isset($_SESSION['dusun'])) {
            $kf        = $_SESSION['dusun'];
            $dusun_sql = " AND c.dusun = '{$kf}'";

            return $dusun_sql;
        }
    }

    public function rw_sql()
    {
        if (isset($_SESSION['rw'])) {
            $kf     = $_SESSION['rw'];
            $rw_sql = " AND c.rw = '{$kf}'";

            return $rw_sql;
        }
    }

    public function rt_sql()
    {
        if (isset($_SESSION['rt'])) {
            $kf     = $_SESSION['rt'];
            $rt_sql = " AND c.rt = '{$kf}'";

            return $rt_sql;
        }
    }

    public function klasifikasi_sql()
    {
        if (isset($_SESSION['klasifikasi'])) {
            $kf              = $_SESSION['klasifikasi'];
            $klasifikasi_sql = " AND k.id = '{$kf}'";

            return $klasifikasi_sql;
        }
    }

    public function paging($p = 1, $o = 0)
    {
        $per     = $this->get_aktif_periode();
        $pembagi = $this->get_analisis_master();
        $pembagi = $pembagi['pembagi'] + 0;

        $sql = "SELECT COUNT(u.id) AS id FROM tweb_keluarga u  LEFT JOIN tweb_penduduk p ON u.nik_kepala = p.id LEFT JOIN tweb_wil_clusterdesa c ON p.id_cluster = c.id LEFT JOIN analisis_respon_hasil h ON u.id = h.id_subjek LEFT JOIN analisis_klasifikasi k ON h.akumulasi/{$pembagi} >= k.minval AND h.akumulasi/{$pembagi} <= k.maxval WHERE h.id_periode = ? AND k.id_master =?";
        $sql .= $this->search_sql();
        $sql .= $this->klasifikasi_sql();
        $sql .= $this->dusun_sql();
        $sql .= $this->rw_sql();
        $sql .= $this->rt_sql();
        $query    = $this->db->query($sql, [$per, $_SESSION['analisis_master']]);
        $row      = $query->row_array();
        $jml_data = $row['id'];

        $this->load->library('paging');
        $cfg['page']     = $p;
        $cfg['per_page'] = $_SESSION['per_page'];
        $cfg['num_rows'] = $jml_data;
        $this->paging->init($cfg);

        return $this->paging;
    }

    public function list_data($o = 0, $offset = 0, $limit = 500)
    {
        $per     = $this->get_aktif_periode();
        $pembagi = $this->get_analisis_master();
        $pembagi = $pembagi['pembagi'] + 0;
        //Ordering SQL
        switch ($o) {
            case 1: $order_sql = ' ORDER BY u.id'; break;

            case 2: $order_sql = ' ORDER BY u.id DESC'; break;

            case 3: $order_sql = ' ORDER BY u.id'; break;

            case 4: $order_sql = ' ORDER BY u.id DESC'; break;

            case 5: $order_sql = ' ORDER BY cek'; break;

            case 6: $order_sql = ' ORDER BY cek DESC'; break;

            default:$order_sql = ' ORDER BY u.id';
        }

        //Paging SQL
        $paging_sql = ' LIMIT ' . $offset . ',' . $limit;

        //Main Query
        $sql = "SELECT u.id,u.no_kk,p.nama,h.akumulasi/{$pembagi} AS cek,k.nama AS klasifikasi FROM tweb_keluarga u LEFT JOIN tweb_penduduk p ON u.nik_kepala = p.id LEFT JOIN tweb_wil_clusterdesa c ON p.id_cluster = c.id LEFT JOIN analisis_respon_hasil h ON u.id = h.id_subjek LEFT JOIN analisis_klasifikasi k ON h.akumulasi/{$pembagi} >= k.minval AND h.akumulasi/{$pembagi} <= k.maxval WHERE h.id_periode = ? AND k.id_master =?";

        $sql .= $this->search_sql();
        $sql .= $this->klasifikasi_sql();
        $sql .= $this->dusun_sql();
        $sql .= $this->rw_sql();
        $sql .= $this->rt_sql();
        $sql .= $order_sql;
        $sql .= $paging_sql;

        $query = $this->db->query($sql, [$per, $_SESSION['analisis_master']]);
        $data  = $query->result_array();

        //Formating Output
        $i = 0;
        $j = $offset;

        while ($i < count($data)) {
            $data[$i]['no'] = $j + 1;

            if ($data[$i]['cek']) {
                $data[$i]['nilai'] = $data[$i]['cek'];
                $data[$i]['set']   = "<img src='" . base_url() . "assets/images/icon/tick.png'>";

            //		$sql = "SELECT nama FROM analisis_klasifikasi WHERE minval < ? AND maxval >= ?";
        //		$query = $this->db->query($sql,array($data[$i]['cek'],$data[$i]['cek']));
        //		$row = $query->row_array();
            //	$data[$i]['klasifikasi'] = $row['nama'];
            } else {
                $data[$i]['nilai'] = '-';
                $data[$i]['set']   = "<img src='" . base_url() . "assets/images/icon/cross.png'>";

                $data[$i]['klasifikasi'] = '-';
            }

            $i++;
            $j++;
        }

        return $data;
    }

    public function list_jawab2($id = 0, $in = 0)
    {
        $per   = $this->get_aktif_periode();
        $sql   = 'SELECT s.id as id_parameter,s.jawaban as jawaban FROM analisis_respon r LEFT JOIN analisis_parameter s ON r.id_parameter = s.id WHERE r.id_subjek = ? AND r.id_periode = ? AND r.id_indikator=?';
        $query = $this->db->query($sql, [$id, $per, $in]);
        $data  = $query->row_array();

        if (empty($data['jawaban'])) {
            $data['jawaban'] = '';
        }

        return $data['jawaban'];
    }

    public function list_indikator($id = 0)
    {
        $sql = 'SELECT * FROM  analisis_indikator u WHERE 1 ';
        $sql .= $this->master_sql();
        $query = $this->db->query($sql, $id);
        $data  = $query->result_array();
        //Formating Output
        $i = 0;

        while ($i < count($data)) {
            $data[$i]['no'] = $i + 1;
            if ($data[$i]['id_tipe'] === 1 || $data[$i]['id_tipe'] === 2) {
                $data[$i]['parameter_laporan'] = $this->list_jawab2($id, $data[$i]['id']);
            } else {
                $data[$i]['parameter_laporan'] = $this->list_jawab2($id, $data[$i]['id']);
            }

            if (empty($data[$i]['parameter_laporan'])) {
                $data[$i]['parameter_laporan'] = '-';
            }

            $i++;
        }

        return $data;
    }

    public function get_analisis_master()
    {
        $sql   = 'SELECT * FROM analisis_master WHERE id=?';
        $query = $this->db->query($sql, $_SESSION['analisis_master']);

        return $query->row_array();
    }

    public function get_subjek($id = 0)
    {
        $sql   = 'SELECT u.*,p.nama FROM tweb_keluarga u LEFT JOIN tweb_penduduk p ON u.nik_kepala = p.id WHERE u.id=?';
        $query = $this->db->query($sql, $id);

        return $query->row_array();
    }

    public function get_aktif_periode()
    {
        $sql   = 'SELECT * FROM analisis_periode WHERE aktif=1 AND id_master=?';
        $query = $this->db->query($sql, $_SESSION['analisis_master']);
        $data  = $query->row_array();

        return $data['id'];
    }

    public function get_periode()
    {
        $sql   = 'SELECT * FROM analisis_periode WHERE aktif=1 AND id_master=?';
        $query = $this->db->query($sql, $_SESSION['analisis_master']);
        $data  = $query->row_array();

        return $data['nama'];
    }

    public function list_dusun()
    {
        $sql   = "SELECT * FROM tweb_wil_clusterdesa WHERE rt = '0' AND rw = '0' ";
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function list_rw($dusun = '')
    {
        $sql   = "SELECT * FROM tweb_wil_clusterdesa WHERE rt = '0' AND dusun = ? AND rw <> '0'";
        $query = $this->db->query($sql, $dusun);

        return $query->result_array();
    }

    public function list_rt($dusun = '', $rw = '')
    {
        $sql   = "SELECT * FROM tweb_wil_clusterdesa WHERE rw = ? AND dusun = ? AND rt <> '0'";
        $query = $this->db->query($sql, [$rw, $dusun]);

        return $query->result_array();
    }

    public function list_klasifikasi()
    {
        $sql   = 'SELECT * FROM analisis_klasifikasi WHERE id_master=?';
        $query = $this->db->query($sql, $_SESSION['analisis_master']);
        $data  = $query->result_array();

        return $data;
    }
}
