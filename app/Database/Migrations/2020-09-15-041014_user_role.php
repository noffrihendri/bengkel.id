<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserRole extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'role_id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'role_name'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'is_active' => [
				'type'           => 'int',
				'constraint'     => 5
			],
			'created_at' => [
				'type'           => 'DATETIME'
			],
			'created_by' => [
				'type'           => 'VARCHAR',
				'constraint'     => '100'
			]
		]);
		$this->forge->addKey('role_id', true);
		$this->forge->createTable('user_role');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('user_role');
	}
}
