<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Init extends Migration
{
    public function up()
    {
        // analisis_indikator
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'id_master'    => ['type' => 'INT', 'constraint' => 11],
            'nomor'        => ['type' => 'INT', 'constraint' => 3],
            'pertanyaan'   => ['type' => 'VARCHAR', 'constraint' => 400],
            'id_tipe'      => ['type' => 'TINYINT', 'constraint' => 4, 'default' => '1'],
            'bobot'        => ['type' => 'TINYINT', 'constraint' => 4, 'default' => '0'],
            'act_analisis' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => '2'],
            'id_kategori'  => ['type' => 'TINYINT', 'constraint' => 4],
            'is_publik'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => '0'],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey(['id_master', 'id_tipe'], false, false, 'id_master');
        $this->forge->addKey('id_tipe');
        $this->forge->addKey('id_kategori');

        $this->forge->createTable('analisis_indikator', true);
    }

    public function down()
    {
        $this->forge->dropTable('analisis_indikator');
    }
}
