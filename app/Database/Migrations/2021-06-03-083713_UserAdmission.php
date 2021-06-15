<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserAdmission extends Migration
{
	public function up(){
		/* ATRIBUT */
		$attributes = ['ENGINE' => 'InnoDB'];

		$this->db->disableForeignKeyChecks();
		/* TABEL DATA USER */
		$this->forge->addField([
															'admission_id'       => [
																						            'type'          => 'BIGINT',
																						            'constraint'    => 20,
																												'unsigned'       => true,
																												'auto_increment' => true
																						        ],
															'login_id'       => [
																						            'type'          => 'BIGINT',
																												'constraint'    => 20,
																												'unsigned' => TRUE,
																												'unique'         => true
																						        ],
															'`admission` VARCHAR(5)',

															'`created_at` DATETIME DEFAULT CURRENT_TIMESTAMP'
															]);

		$this->forge->addKey('admission_id',TRUE);
		// $this->forge->addKey('login_id');
		$this->forge->addForeignKey('login_id', 'login', 'id');
		$this->forge->createTable('family_admission', TRUE, $attributes);

		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->forge->dropTable('family_admission');
	}
}
