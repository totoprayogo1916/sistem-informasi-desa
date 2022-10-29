<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfigModel extends Model
{
    protected $table            = 'config';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_desa', 'kode_desa', 'nama_kepala_desa', 'nip_kepala_desa', 'kode_pos',
        'nama_kecamatan', 'kode_kecamatan', 'nama_kepala_camat', 'nip_kepala_camat',
        'nama_kabupaten', 'kode_kabupaten', 'nama_propinsi', 'kode_propinsi', 'logo',
        'lat', 'lng', 'zoom', 'map_tipe', 'path', 'alamat_kantor', 'g_analytic',
        'regid', 'macid', 'email_desa', 'gapi_key',
    ];
}
