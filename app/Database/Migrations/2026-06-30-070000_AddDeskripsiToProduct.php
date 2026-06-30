<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeskripsiToProduct extends Migration
{
    public function up()
    {
        $this->forge->addColumn('product', [
            'deskripsi' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after'      => 'jumlah',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('product', 'deskripsi');
    }
}
