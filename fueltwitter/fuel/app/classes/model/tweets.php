<?php

class Model_Tweets extends \Model_Crud {

	protected static $_table_name = 'tweets';
	protected static $_primary_key = 'id';
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array('events'=>array('before_insert'), 'mysql_timestamp' => true,),
		'Orm\Observer_UpdatedAt' => array('events'=>array('before_save'), 'mysql_timestamp' => true,),
		);

    public static function get($user_id)
    {
       if (is_array($user_id))
		{
			$user_id = Arr::unique($user_id);

			if (count($user_id) === 1)
			{
				$where = array('user_id' => $user_id[0]);
			}
			else
			{
				$where = array(array('user_id', 'in', $user_id));
			}
		}
		else
		{
			$where = array('user_id' => $user_id);
		}

       $user_tweets = static::find(array(
			'where' => $where,
		), 'id');

		return $user_tweets;

    }

}