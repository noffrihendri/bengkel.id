<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserRole extends Seeder
{
	public function run()
	{
		$data = [
			[
				'role_name' => 'admin',
				'is_active'    => 1,
				'created_at' => now(),
				'created_by' => 'admin'

			],
			[
				'role_name' => 'User',
				'is_active'    => 1,
				'created_at' => now(),
				'created_by' => 'admin'

			]
		];


		// Using Query Builder
		$this->db->table('user_role')->insertBatch($data);
	}
}
