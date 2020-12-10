<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MenuRole extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 4,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'id_role'       => [
				'type'           => 'INT',
				'constraint'     => '4',
			],
			'id_menu' => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
			],
			'created_at' => [
				'type'           => 'DATETIME'
			],
			'created_by' => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('role_menu');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('role_menu');
	}
}
