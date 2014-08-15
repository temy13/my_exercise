<?php

namespace Fuel\Migrations;

class Add_login_hash_to_users
{
	public function up()
	{
		\DBUtil::add_fields('users', array(
			'login_hash' => array('constraint' => 255, 'type' => 'varchar', 'after' => 'last_login'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('users', array(
			'login_hash'

		));
	}
}