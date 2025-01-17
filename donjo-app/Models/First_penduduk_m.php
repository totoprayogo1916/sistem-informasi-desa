<?php

use App\Models\BaseModel as Model;

class First_penduduk_m extends Model
{
    public function list_data($lap = '', $o = 0)
    {
        switch ($lap) {
            case 'pendidikan-dalam-kk': $sql = 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE pendidikan_kk_id = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE pendidikan_kk_id = u.id AND sex = 1) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE pendidikan_kk_id = u.id AND sex = 2) AS perempuan FROM tweb_penduduk_pendidikan_kk u WHERE 1 ORDER BY jumlah DESC';
                break;

            case 'pendidikan-ditempuh': $sql = 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE pendidikan_sedang_id = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE pendidikan_sedang_id = u.id AND sex = 1) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE pendidikan_sedang_id = u.id AND sex = 2) AS perempuan FROM tweb_penduduk_pendidikan u WHERE 1 ORDER BY jumlah DESC';
                break;

            case 'pekerjaan': $sql = 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE pekerjaan_id = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE pekerjaan_id = u.id AND sex = 1) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE pekerjaan_id = u.id AND sex = 2) AS perempuan FROM tweb_penduduk_pekerjaan u WHERE 1 ORDER BY jumlah DESC';
                break;

            case 'status-perkawinan': $sql = 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE status_kawin = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE status_kawin = u.id AND sex = 1) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE status_kawin = u.id AND sex = 2) AS perempuan FROM tweb_penduduk_kawin u WHERE 1 ORDER BY jumlah DESC';
                break;

            case 'agama': $sql = 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE agama_id = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE agama_id = u.id AND sex = 1) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE agama_id = u.id AND sex = 2) AS perempuan FROM tweb_penduduk_agama u WHERE 1 ';
                break;

            case 'jenis-kelamin': $sql = 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE sex = u.id AND status_dasar = 1) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE sex = u.id AND sex=1 AND status_dasar = 1) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE sex = 2 AND sex=u.id AND status_dasar = 1) AS perempuan FROM tweb_penduduk_sex u WHERE 1 ORDER BY jumlah DESC';
                break;

            case 'warga-negara': $sql = 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE warganegara_id = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE warganegara_id = u.id AND sex = 1) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE warganegara_id = u.id AND sex = 2) AS perempuan FROM tweb_penduduk_warganegara u WHERE 1 ORDER BY jumlah DESC';
                break;

            case '': $sql = 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE status = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE status = u.id AND status = 0) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE status = u.id AND sex = 2) AS perempuan FROM tweb_penduduk_status u WHERE 1 ORDER BY jumlah DESC';
                break;

            case 'golongan-darah': $sql = 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE golongan_darah_id = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE golongan_darah_id = u.id AND sex = 1) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE golongan_darah_id = u.id AND sex = 2) AS perempuan FROM tweb_golongan_darah u WHERE 1 ORDER BY jumlah DESC';
                break;

            case 8: $sql = 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE cacat_fisik_id = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE cacat_fisik_id = u.id AND sex = 1) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE cacat_fisik_id = u.id AND sex = 2) AS perempuan FROM tweb_cacat_fisik u WHERE 1 ORDER BY jumlah DESC';
                break;

            case 9: $sql = 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE cacat_mental_id = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE cacat_mental_id = u.id AND sex = 1) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE cacat_mental_id = u.id AND sex = 2) AS perempuan FROM tweb_cacat_mental u WHERE 1 ORDER BY jumlah DESC';
                break;

            case 10: $sql = 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE sakit_menahun_id = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE sakit_menahun_id = u.id AND sex = 1) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE sakit_menahun_id = u.id AND sex = 2) AS perempuan FROM tweb_sakit_menahun u WHERE 1 ORDER BY jumlah DESC';
                break;

            case 11: $sql = 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE jamkesmas = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE jamkesmas = u.id AND sex = 1) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE jamkesmas = u.id AND sex = 2) AS perempuan FROM ref_jamkesmas u WHERE 1 ORDER BY jumlah DESC';
                break;

            case 'kelompok-umur': $sql = "SELECT u.*,
			(SELECT COUNT(id) FROM tweb_penduduk WHERE DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`tanggallahir`)), '%Y')+0 >= u.dari AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`tanggallahir`)), '%Y')+0 <= u.sampai) AS jumlah,
			(SELECT COUNT(id) FROM tweb_penduduk WHERE DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`tanggallahir`)), '%Y')+0 >= u.dari AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`tanggallahir`)), '%Y')+0 <= u.sampai AND sex=1) AS laki,
			(SELECT COUNT(id) FROM tweb_penduduk WHERE DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`tanggallahir`)), '%Y')+0 >= u.dari AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`tanggallahir`)), '%Y')+0 <= u.sampai AND sex=2) AS perempuan
			FROM tweb_penduduk_umur u WHERE status = 1 ORDER BY u.id ";
                break;

            case 13: $sql = 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE warganegara_id = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE warganegara_id = u.id AND sex = 1) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE warganegara_id = u.id AND sex = 2) AS perempuan FROM tweb_penduduk_warganegara u WHERE 1 ORDER BY jumlah DESC';
                break;

            case 14: $sql = 'SELECT u.*,(SELECT COUNT(id) FROM tweb_penduduk WHERE status_kawin = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_penduduk WHERE status_kawin = u.id AND sex = 1) AS laki,(SELECT COUNT(id) FROM tweb_penduduk WHERE status_kawin = u.id AND sex = 2) AS perempuan FROM tweb_penduduk_kawin u WHERE 1 ORDER BY jumlah DESC';
                break;

            case 21: $sql = 'SELECT u.*,(SELECT COUNT(id) FROM tweb_keluarga WHERE kelas_sosial = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_keluarga WHERE 0) AS laki,(SELECT COUNT(id) FROM tweb_keluarga WHERE 0) AS perempuan FROM ref_kelas_sosial u WHERE 1 ORDER BY jumlah DESC';
                break;

            case 22: $sql = 'SELECT u.*,(SELECT COUNT(id) FROM tweb_keluarga WHERE raskin = u.id) AS jumlah,(SELECT COUNT(id) FROM tweb_keluarga WHERE 0) AS laki,(SELECT COUNT(id) FROM tweb_keluarga WHERE 0) AS perempuan FROM ref_raskin u WHERE 1 ORDER BY jumlah DESC';
                break;

            default:$sql = 'SELECT u.* FROM tweb_penduduk_pendidikan u WHERE 1 ';
        }

        $query = $this->db->query($sql);
        $data  = $query->result_array();

        if ($lap <= 20) {
            $sql3 = 'SELECT (SELECT COUNT(p.id) FROM tweb_penduduk p WHERE p.status_dasar=1) AS jumlah,
			(SELECT COUNT(p.id) FROM tweb_penduduk p WHERE p.sex = 1 and status_dasar=1) AS laki,
			(SELECT COUNT(p.id) FROM tweb_penduduk p WHERE p.sex = 2 and status_dasar=1) AS perempuan';
        } else {
            $sql3 = 'SELECT (SELECT COUNT(p.id) FROM tweb_keluarga p WHERE 1) AS jumlah,
			(SELECT COUNT(p.id) FROM tweb_keluarga p WHERE 1) AS laki,
			(SELECT COUNT(p.id) FROM tweb_keluarga p WHERE 1) AS perempuan';
        }

        $query3 = $this->db->query($sql3);
        $bel    = $query3->row_array();

        $total['jumlah']    = 0;
        $bel['no']          = '';
        $bel['id']          = '';
        $bel['nama']        = 'TOTAL';
        $total['laki']      = 0;
        $total['perempuan'] = 0;
        $i                  = 0;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['no'] = $i + 1;
            if (isset($data[$i]['jumlah'])) {
                $total['jumlah'] += $data[$i]['jumlah'];
                $total['laki'] += $data[$i]['laki'];
                $total['perempuan'] += $data[$i]['perempuan'];
            }
            $i++;
        }
        /*
        $data[$i]['no']="";
        $data[$i]['id']=777;
        $data[$i]['nama']="BELUM MENGISI";
        $data[$i]['jumlah']=$bel['jumlah']-$total['jumlah'];
        $data[$i]['perempuan']=$bel['perempuan']-$total['perempuan'];
        $data[$i]['laki']=$bel['laki']-$total['laki'];
        */

        $i = 0;
        if (isset($data[$i]['jumlah']) && $data[$i]['jumlah'] > 0) {
            while ($i < (is_countable($data) ? count($data) : 0)) {
                $data[$i]['persen'] = $data[$i]['jumlah'] / $bel['jumlah'] * 100;
                $data[$i]['persen'] = number_format((float) $data[$i]['persen'], 2, '.', '');
                $data[$i]['persen'] .= '%';

                $data[$i]['persen1'] = $data[$i]['laki'] / $bel['jumlah'] * 100;
                $data[$i]['persen1'] = number_format((float) $data[$i]['persen1'], 2, '.', '');
                $data[$i]['persen1'] .= '%';

                $data[$i]['persen2'] = $data[$i]['perempuan'] / $bel['jumlah'] * 100;
                $data[$i]['persen2'] = number_format((float) $data[$i]['persen2'], 2, '.', '');
                $data[$i]['persen2'] .= '%';

                $i++;
            }
            $bel['persen'] = '100%';

            $bel['persen1'] = $bel['laki'] / $bel['jumlah'] * 100;
            $bel['persen1'] = number_format((float) $bel['persen1'], 2, '.', '');
            $bel['persen1'] .= '%';

            $bel['persen2'] = $bel['perempuan'] / $bel['jumlah'] * 100;
            $bel['persen2'] = number_format((float) $bel['persen2'], 2, '.', '');
            $bel['persen2'] .= '%';
        } else {
            $data[$i]['persen'] = 0;
            $data[$i]['persen'] = 0;
            $data[$i]['persen'] = 0;

            $data[$i]['persen1'] = 0;
            $data[$i]['persen1'] = 0;
            $data[$i]['persen1'] = 0;

            $data[$i]['persen2'] = 0;
            $data[$i]['persen2'] = 0;
            $data[$i]['persen2'] = 0;
            $bel['persen']       = '100%';

            $bel['persen1'] = 0;
            $bel['persen1'] = 0;
            $bel['persen1'] = 0;

            $bel['persen2'] = 0;
            $bel['persen2'] = 0;
            $bel['persen2'] = 0;
        }

        $data['total'] = $bel;

        return $data;
    }

    public function wilayah()
    {
        $sql = "SELECT u.*,a.nama AS nama_kadus,a.nik AS nik_kadus,
		(SELECT COUNT(rw.id) FROM tweb_wil_clusterdesa rw WHERE dusun = u.dusun AND rw <> '-' AND rt = '-') AS jumlah_rw,
		(SELECT COUNT(v.id) FROM tweb_wil_clusterdesa v WHERE dusun = u.dusun AND v.rt <> '0' AND v.rt <> '-') AS jumlah_rt,
		(SELECT COUNT(p.id) FROM tweb_penduduk p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = u.dusun) and status_dasar=1) AS jumlah_warga,
		(SELECT COUNT(p.id) FROM tweb_penduduk p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = u.dusun) AND p.sex = 1 and status_dasar=1) AS jumlah_warga_l,
		(SELECT COUNT(p.id) FROM tweb_penduduk p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = u.dusun) AND p.sex = 2 and status_dasar=1) AS jumlah_warga_p,
		(SELECT COUNT(p.id) FROM tweb_keluarga k inner join tweb_penduduk p ON k.nik_kepala=p.id WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa WHERE dusun = u.dusun) AND p.kk_level = 1 and status_dasar=1) AS jumlah_kk
		FROM tweb_wil_clusterdesa u LEFT JOIN tweb_penduduk a ON u.id_kepala = a.id WHERE u.rt = '0' AND u.rw = '0' ";

        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i = 0;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['no'] = $i + 1;
            $i++;
        }

        return $data;
    }

    public function total()
    {
        $sql = "SELECT (SELECT COUNT(rw.id) FROM tweb_wil_clusterdesa rw WHERE rw <> '-' AND rt = '-') AS total_rw,
		(SELECT COUNT(v.id) FROM tweb_wil_clusterdesa v WHERE v.rt <> '0' AND v.rt <> '-') AS total_rt, (SELECT COUNT(p.id) FROM tweb_penduduk p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa ) and status_dasar=1) AS total_warga, (SELECT COUNT(p.id) FROM tweb_penduduk p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa) AND p.sex = 1 and status_dasar=1) AS total_warga_l, (SELECT COUNT(p.id) FROM tweb_penduduk p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa) AND p.sex = 2 and status_dasar=1) AS total_warga_p, (SELECT COUNT(p.id) FROM tweb_keluarga k inner join tweb_penduduk p ON k.nik_kepala=p.id WHERE p.id_cluster IN(SELECT id FROM tweb_wil_clusterdesa) AND p.kk_level = 1 and status_dasar=1) AS total_kk FROM tweb_wil_clusterdesa u LEFT JOIN tweb_penduduk a ON u.id_kepala = a.id WHERE u.rt = '0' AND u.rw = '0' limit 1";
        $query = $this->db->query($sql);

        return $query->row_array();
    }

    public function list_indikator()
    {
        $sql   = 'SELECT u.id,u.pertanyaan AS indikator,s.subjek,p.nama AS periode,p.tahun_pelaksanaan AS tahun,m.nama AS master,m.subjek_tipe,p.id AS id_periode FROM analisis_indikator u LEFT JOIN analisis_master m ON u.id_master = m.id LEFT JOIN analisis_ref_subjek s ON m.subjek_tipe = s.id LEFT JOIN analisis_periode p ON p.id_master = m.id AND p.aktif = 1 WHERE u.is_publik = 1 ORDER BY u.nomor ASC';
        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i = 0;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['no'] = $i + 1;
            $i++;
        }

        return $data;
    }

    public function get_indikator($id = 0)
    {
        $sql   = 'SELECT pertanyaan FROM analisis_indikator WHERE id = ?';
        $query = $this->db->query($sql, $id);
        $data  = $query->row_array();

        return $data['pertanyaan'];
    }

    public function list_jawab($id = 0, $sb = 0, $per = 0)
    {
        switch ($sb) {
            case 1: $sbj = 'LEFT JOIN tweb_penduduk p ON r.id_subjek = p.id LEFT JOIN tweb_wil_clusterdesa a ON p.id_cluster = a.id ';
                break;

            case 2: $sbj = 'LEFT JOIN tweb_keluarga v ON r.id_subjek = v.id LEFT JOIN tweb_penduduk p ON v.nik_kepala = p.id LEFT JOIN tweb_wil_clusterdesa a ON p.id_cluster = a.id  ';
                break;

            case 3: $sbj = 'LEFT JOIN tweb_rtm v ON r.id_subjek = v.id LEFT JOIN tweb_penduduk p ON v.nik_kepala = p.id LEFT JOIN tweb_wil_clusterdesa a ON p.id_cluster = a.id ';
                break;

            case 4: $sbj = 'LEFT JOIN kelompok v ON r.id_subjek = v.id LEFT JOIN tweb_penduduk p ON v.id_ketua = p.id LEFT JOIN tweb_wil_clusterdesa a ON p.id_cluster = a.id  ';
                break;
        }

        $sql   = 'SELECT * FROM analisis_parameter WHERE id_indikator = ? ORDER BY kode_jawaban ASC ';
        $query = $this->db->query($sql, $id);
        $data  = $query->result_array();

        $i = 0;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['no'] = $i + 1;

            $sql    = "SELECT COUNT(r.id_subjek) AS jml FROM analisis_respon r {$sbj} WHERE r.id_parameter = ? AND r.id_periode = {$per}";
            $query  = $this->db->query($sql, $data[$i]['id']);
            $respon = $query->row_array();

            $data[$i]['nilai'] = $respon['jml'];

            $i++;
        }

        return $data;
    }
}
