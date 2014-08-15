<?php

namespace Fuel\Migrations;

class Create_tweets
{
	public function up()
	{
		\DBUtil::create_table('tweets', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'user_id' => array('constraint' => 11, 'type' => 'int'),
			'username' => array('constraint' => 255, 'type' => 'varchar'),
			'content' => array('type' => 'text'),
			'image_path' => array('type' => 'text', 'null' => true),
			'created_at' => array('type' => 'datetime'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('tweets');
	}
}