<?php

use App\Libraries\Paging;
use App\Models\BaseModel as Model;

class Web_menu_model extends Model
{
    public function autocomplete()
    {
        $sql   = 'SELECT nama FROM menu';
        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i    = 0;
        $outp = '';

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $outp .= ',"' . $data[$i]['nama'] . '"';
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
            $search_sql = " AND (nama LIKE '{$kw}')";
        }
    }

    public function filter_sql()
    {
        if (isset($_SESSION['filter'])) {
            $kf = $_SESSION['filter'];

            return " AND enabled = {$kf}";
        }
    }

    public function paging($tip = 0, $p = 1, $o = 0)
    {
        $paging = new Paging();

        $sql = 'SELECT COUNT(id) AS id FROM menu WHERE tipe = ?';
        $sql .= $this->search_sql();
        $query    = $this->db->query($sql, $tip);
        $row      = $query->row_array();
        $jml_data = $row['id'];

        $cfg['page']     = $p;
        $cfg['per_page'] = $_SESSION['per_page'];
        $cfg['num_rows'] = $jml_data;

        $paging->init($cfg);

        return $paging;
    }

    public function list_data($tip = 0, $o = 0, $offset = 0, $limit = 500)
    {
        switch ($o) {
            case 1: $order_sql = ' ORDER BY nama';
                break;

            case 2: $order_sql = ' ORDER BY nama DESC';
                break;

            case 3: $order_sql = ' ORDER BY enabled';
                break;

            case 4: $order_sql = ' ORDER BY enabled DESC';
                break;

            default:$order_sql = ' ORDER BY id';
        }
        $paging_sql = ' LIMIT ' . $offset . ',' . $limit;
        if ($tip === 1) {
            $sql = 'SELECT * FROM menu WHERE tipe =? ';
        } else {
            $sql = 'SELECT k.id,k.kategori AS nama FROM kategori k WHERE 1';
        }

        $sql .= $this->search_sql();
        $sql .= $this->filter_sql();
        $sql .= $order_sql;
        $sql .= $paging_sql;

        $query = $this->db->query($sql, $tip);
        $data  = $query->result_array();

        $i = 0;
        $j = $offset;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['no'] = $j + 1;

            if (isset($data[$i]['enabled']) && $data[$i]['enabled'] === 1) {
                $data[$i]['aktif'] = 'Yes';
            } else {
                $data[$i]['aktif'] = 'No';
            }

            $i++;
            $j++;
        }

        return $data;
    }

    public function insert($tip = 1)
    {
        $data = $_POST;

        if ($data['manual_link'] !== '') {
            $data['link_tipe'] = 1;
            $data['link']      = $data['manual_link'];
        }
        unset($data['manual_link']);

        $data['tipe'] = $tip;
        $outp         = $this->db->insert('menu', $data);
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function update($id = 0)
    {
        $data = $_POST;

        if ($data['manual_link'] !== '') {
            $data['link_tipe'] = 1;
            $data['link']      = $data['manual_link'];
        } else {
            $data['link_tipe'] = 0;
        }
        unset($data['manual_link']);

        if ($data['link'] === '') {
            unset($data['link']);
        }

        $this->db->where('id', $id);
        $outp = $this->db->update('menu', $data);
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete($id = '')
    {
        $sql  = 'DELETE FROM menu WHERE id=?';
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
                $sql  = 'DELETE FROM menu WHERE id=?';
                $outp = $this->db->query($sql, [$id]);
            }
        } else {
            $outp = false;
        }

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function list_sub_menu($menu = 1)
    {
        $sql = 'SELECT * FROM menu WHERE parrent = ? AND tipe = 3 ';

        $query = $this->db->query($sql, $menu);
        $data  = $query->result_array();

        $i = 0;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['no'] = $i + 1;

            if ($data[$i]['enabled'] === 1) {
                $data[$i]['aktif'] = 'Yes';
            } else {
                $data[$i]['aktif'] = 'No';
            }

            $i++;
        }

        return $data;
    }

    public function list_link()
    {
        $sql = "SELECT a.id,a.judul FROM artikel a WHERE a.id_kategori ='999'";

        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i = 0;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['no'] = $i + 1;
            $i++;
        }

        return $data;
    }

    public function list_kategori()
    {
        $sql = 'SELECT k.id,k.kategori AS nama FROM kategori k WHERE 1';

        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i = 0;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['no']    = $i + 1;
            $data[$i]['judul'] = $data[$i]['nama'];
            $i++;
        }

        return $data;
    }

    public function insert_sub_menu($menu = 0)
    {
        $data = $_POST;

        if ($data['manual_link'] !== '') {
            $data['link_tipe'] = 1;
            $data['link']      = $data['manual_link'];
        }
        unset($data['manual_link']);

        $data['parrent'] = $menu;
        $data['tipe']    = 3;
        $outp            = $this->db->insert('menu', $data);
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function update_sub_menu($id = 0)
    {
        $data = $_POST;

        if ($data['manual_link'] !== '') {
            $data['link_tipe'] = 1;
            $data['link']      = $data['manual_link'];
        } else {
            $data['link_tipe'] = 0;
        }
        if ($data['link'] === '') {
            unset($data['link']);
        }

        $this->db->where('id', $id);
        $outp = $this->db->update('menu', $data);
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete_sub_menu($id = '')
    {
        $sql  = 'DELETE FROM menu WHERE id=?';
        $outp = $this->db->query($sql, [$id]);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete_all_sub_menu()
    {
        $id_cb = $_POST['id_cb'];

        if (is_countable($id_cb) ? count($id_cb) : 0) {
            foreach ($id_cb as $id) {
                $sql  = 'DELETE FROM menu WHERE id=?';
                $outp = $this->db->query($sql, [$id]);
            }
        } else {
            $outp = false;
        }

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function menu_lock($id = '', $val = 0)
    {
        $sql  = 'UPDATE menu SET enabled=? WHERE id=?';
        $outp = $this->db->query($sql, [$val, $id]);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function get_menu($id = 0)
    {
        $sql   = 'SELECT * FROM menu WHERE id=?';
        $query = $this->db->query($sql, $id);

        return $query->row_array();
    }

    public function menu_show()
    {
        $sql   = 'SELECT * FROM menu WHERE enabled=?';
        $query = $this->db->query($sql, 1);

        return $query->result_array();
    }
}
