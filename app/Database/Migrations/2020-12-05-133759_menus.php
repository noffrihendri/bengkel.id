<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Menus extends Migration
{
	public function up()
	{
		//
		$this->forge->addField([
			'menu_id'          => [
				'type'           => 'INT',
				'constraint'     => 4,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'title'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'link' => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
			],
			'icon' => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
			],
			'parent' => [
				'type'           => 'INT',
				'constraint'     => 4,
			],
			'created_at' => [
				'type'           => 'DATETIME'
			],
			'created_by' => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			]
		]);
		$this->forge->addKey('menu_id', true);
		$this->forge->createTable('menu');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->forge->dropTable('menu');
	}
}
