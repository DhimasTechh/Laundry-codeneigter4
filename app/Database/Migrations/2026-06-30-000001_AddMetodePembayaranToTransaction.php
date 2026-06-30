<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMetodePembayaranToTransaction extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transaction', [
            'metode_pembayaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => TRUE,
                'after'      => 'status',
            ],
            'nama_penerima' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => TRUE,
                'after'      => 'metode_pembayaran',
            ],
            'telepon' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => TRUE,
                'after'      => 'nama_penerima',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('transaction', ['metode_pembayaran', 'nama_penerima', 'telepon']);
    }
}
