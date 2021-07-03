<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MyworksPhotography extends Migration
{
	public function up()
	{
		/* ATRIBUT */
		$attributes = ['ENGINE' => 'InnoDB'];

		$this->db->disableForeignKeyChecks();
		/* TABEL DATA USER */
		$this->forge->addField([
															'mw_photography_id'       => [
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
															'`title` VARCHAR(255)',
															'`description` TEXT',
															'`link` TEXT',

															'`created_at` DATETIME DEFAULT CURRENT_TIMESTAMP'
															]);

		$this->forge->addKey('mw_photography_id',TRUE);
		$this->forge->addForeignKey('login_id', 'login', 'id');
		$this->forge->createTable('myworks_photography', TRUE, $attributes);

		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->forge->dropTable('myworks_photography');
	}
}
