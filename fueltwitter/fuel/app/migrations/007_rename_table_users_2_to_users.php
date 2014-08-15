<?php

namespace Fuel\Migrations;

class Rename_table_users_2_to_users
{
	public function up()
	{
		\DBUtil::rename_table('users_2', 'users');
	}

	public function down()
	{
		\DBUtil::rename_table('users', 'users_2');
	}
}