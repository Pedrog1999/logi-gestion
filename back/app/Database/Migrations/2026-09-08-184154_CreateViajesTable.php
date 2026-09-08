<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateViajesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'origen' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'destino' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'estado' => [
                'type'       => 'ENUM',
                'constraint' => ['Pendiente', 'En curso', 'Finalizado', 'Cancelado'],
                'default'    => 'Pendiente',
            ],
            'conductor' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'fecha_salida' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'fecha_llegada' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('viajes');
    }

    public function down()
    {
        $this->forge->dropTable('viajes');
    }
}
