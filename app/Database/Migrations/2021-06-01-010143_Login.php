<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Login extends Migration
{
	public function up()
	{
		/* ATRIBUT */
		$attributes = ['ENGINE' => 'InnoDB'];

		/* TABEL LOGIN */
		$this->forge->addField([
															'id BIGINT(20) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT',
															'username VARCHAR(255) UNIQUE',
															'password TEXT',
															'level VARCHAR(5)',
															'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
															]);

		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('login', TRUE, $attributes);
	}

	public function down()
	{
		$this->forge->dropTable('login');
	}
}
