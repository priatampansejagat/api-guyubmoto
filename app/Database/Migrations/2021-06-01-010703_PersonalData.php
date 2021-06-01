<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PersonalData extends Migration
{
	public function up()
	{
		/* ATRIBUT */
		$attributes = ['ENGINE' => 'InnoDB'];

		$this->db->disableForeignKeyChecks();
		/* TABEL DATA USER */
		$this->forge->addField([
															'person_id'       => [
																						            'type'          => 'BIGINT',
																						            'constraint'    => 20,
																												'unsigned'       => true,
																												'auto_increment' => true
																						        ],
															'login_id'       => [
																						            'type'          => 'BIGINT',
																												'constraint'    => 20,
																												'unsigned' => TRUE
																						        ],
															// '`login_id` BIGINT(20)',
															'`first_name` VARCHAR(255)',
															'`mid_name` VARCHAR(255)',
															'`last_name` VARCHAR(255)',
															'`age` int(3)',
															'`gender` VARCHAR(10)',
															'`email` VARCHAR(64)',
															'`phone_number` VARCHAR(16)',
															'`biography` TEXT',
															'`address` TEXT',
															'`city` VARCHAR(255)',
															'`country` VARCHAR(255)',
															'`instagram` TEXT',
															'`portfolio` TEXT',

															'`picture_profile` VARCHAR(255)',
															'`created_at` DATETIME DEFAULT CURRENT_TIMESTAMP'
															]);

		$this->forge->addKey('person_id',TRUE);
		$this->forge->addKey('login_id');
		$this->forge->addForeignKey('login_id', 'login', 'id');
		$this->forge->createTable('personal_data', TRUE, $attributes);

		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->forge->dropTable('personal_data');
	}
}
