<?php

namespace Fuel\Migrations;

class Drop_users
{
	public function up()
	{
		\DBUtil::drop_table('users');
	}

	public function down()
	{
		\DBUtil::create_table('users', array(
			'id' => array('type' => 'int unsigned', 'null' => true, 'auto_increment' => true),
			'username' => array('type' => 'varchar', 'null' => true, 'constraint' => 255),
			'password' => array('type' => 'varchar', 'null' => true, 'constraint' => 255),
			'group' => array('type' => 'int', 'default' => '1', 'constraint' => 11),
			'email' => array('type' => 'varchar', 'null' => true, 'constraint' => 255),
			'last_login' => array('type' => 'varchar', 'null' => true, 'constraint' => 255),
			'profile_fields' => array('type' => 'text', 'null' => true),
			'created_at' => array('type' => 'int', 'null' => true, 'constraint' => 11),
			'temp' => array('type' => 'varchar', 'null' => true, 'constraint' => 255),

		), array('id'));

	}
}