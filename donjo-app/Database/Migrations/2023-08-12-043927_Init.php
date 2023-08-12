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

        // analisis_kategori_indikator
        $this->forge->addField([
            'id'            => ['type' => 'TINYINT', 'constraint' => 4, 'auto_increment' => true],
            'id_master'     => ['type' => 'TINYINT', 'constraint' => 4],
            'kategori_kode' => ['type' => 'VARCHAR', 'constraint' => 3],
            'kategori'      => ['type' => 'VARCHAR', 'constraint' => 50],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('id_master');
        $this->forge->createTable('analisis_kategori_indikator', true);

        // analisis_klasifikasi
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'id_master' => ['type' => 'INT', 'constraint' => 11],
            'nama'      => ['type' => 'VARCHAR', 'constraint' => 20],
            'minval'    => ['type' => 'DOUBLE', 'constraint' => '5,2'],
            'maxval'    => ['type' => 'DOUBLE', 'constraint' => '5,2'],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('id_master');
        $this->forge->createTable('analisis_klasifikasi', true);

        // analisis_master
        $this->forge->addField([
            'id'            => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'nama'          => ['type' => 'varchar', 'constraint' => 40],
            'subjek_tipe'   => ['type' => 'tinyint', 'constraint' => 4],
            'lock'          => ['type' => 'tinyint', 'constraint' => 1, 'default' => '1'],
            'deskripsi'     => ['type' => 'text'],
            'kode_analisis' => ['type' => 'varchar', 'constraint' => 5, 'default' => '00000'],
            'id_child'      => ['type' => 'smallint', 'constraint' => 4],
            'id_kelompok'   => ['type' => 'int', 'constraint' => 11],
            'pembagi'       => ['type' => 'varchar', 'constraint' => 10, 'default' => 100],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('analisis_master', true);

        // analisis_parameter
        $this->forge->addField([
            'id'           => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'id_indikator' => ['type' => 'int', 'constraint' => 11],
            'kode_jawaban' => ['type' => 'int', 'constraint' => 3],
            'asign'        => ['type' => 'tinyint', 'constraint' => 1, 'default' => '0'],
            'jawaban'      => ['type' => 'varchar', 'constraint' => 200],
            'nilai'        => ['type' => 'tinyint', 'constraint' => 4, 'default' => '0'],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('id_indikator');
        $this->forge->createTable('analisis_parameter', true);

        // analisis_partisipasi
        $this->forge->addField([
            'id'              => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'id_subjek'       => ['type' => 'int', 'constraint' => 11],
            'id_master'       => ['type' => 'int', 'constraint' => 11],
            'id_periode'      => ['type' => 'int', 'constraint' => 11],
            'id_klassifikasi' => ['type' => 'int', 'constraint' => 11, 'default' => 1],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey(['id_subjek', 'id_master', 'id_periode', 'id_klassifikasi'], false, false, 'id_subjek');
        $this->forge->addKey('id_master');
        $this->forge->addKey('id_periode');
        $this->forge->addKey('id_klassifikasi');
        $this->forge->createTable('analisis_partisipasi', true);

        // analisis_periode
        $this->forge->addField([
            'id'                => ['type' => 'int', 'constraint' => '11', 'auto_increment' => true],
            'id_master'         => ['type' => 'int', 'constraint' => '11'],
            'nama'              => ['type' => 'varchar', 'constraint' => '50'],
            'id_state'          => ['type' => 'tinyint', 'constraint' => '4', 'default' => '1'],
            'aktif'             => ['type' => 'tinyint', 'constraint' => '1', 'default' => '0'],
            'keterangan'        => ['type' => 'varchar', 'constraint' => '100'],
            'tahun_pelaksanaan' => ['type' => 'year', 'constraint' => '4'],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('id_master');
        $this->forge->addKey('id_state');
        $this->forge->createTable('analisis_periode', true);
    }

    public function down()
    {
        $this->forge->dropTable('analisis_indikator', true);
        $this->forge->dropTable('analisis_kategori_indikator', true);
        $this->forge->dropTable('analisis_klasifikasi', true);
        $this->forge->dropTable('analisis_master', true);
        $this->forge->dropTable('analisis_parameter', true);
        $this->forge->dropTable('analisis_partisipasi', true);
        $this->forge->dropTable('analisis_periode', true);
    }
}
