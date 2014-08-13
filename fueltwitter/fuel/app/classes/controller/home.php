<?php 


class Controller_Home extends Controller_BaseTemplate { 

	public function before()
{
    parent::before();
    $this->user_id = Auth::get('id');
    $this->username = Auth::get('username');
    Config::load('upload', true);
}

	public function action_index(){

		if(empty($this->user_id))
			Response::redirect('login/logout');

		$data = array();
		$data['user_tweets'] = Model_Tweets::find(array(
									'all', 
								    'order_by' => array('created_at' => 'desc')
								));
		$data['user_id'] = $this->user_id;
		$data['last_update'] =  Date::time('UTC')->format('mysql');
		$this->template->title = $this->username.'さんのタイムライン';
		$this->template->content = View::forge('home/index',$data);
		$this->template->content->set_safe('errmsg', "");
		
	}

	public function action_create(){

		if(Input::method() == 'POST'):
			$image_path = null;
			//画像保存
			Upload::process(array('path' => Config::get('upload.path')));
            if (Upload::is_valid()) {
                Upload::save();
               	$image_path = '/uploads/'.Upload::get_files()[0]['saved_as'];
            }
            //tweet保存
			$tweet = Model_Tweets::forge(array(
			    'user_id' => $this->user_id,
			    'username' => $this->username,
			    'content' => Input::post('content'),
			    'image_path' => $image_path,
			    'created_at' => Date::time('UTC')->format('mysql'),
			));
			if(!$tweet->save())
		        $err = "つぶやきに失敗しました";
		  
		endif;
		Response::redirect('home');
	}
	//ajaxによるリロード
	public function action_reload()
    {
    
    	$last_update = $_POST['last'];
    	Log::info($last_update);
    	$data = array();
    	$data["tweet"] = Model_Tweets::find(array(
									'all', 
									'where' => array(array('created_at' , '>' , $last_update)),
								    'order_by' => array('created_at' => 'asc')
								));
    	$data["user_id"] = $this->user_id;
    	$data["base_url"] = Config::get('base_url');
    	$data["last_update"] = Date::time('UTC')->format('mysql');
        return json_encode($data);
		
    }

	public function action_delete($tweet_id){
		$delete_tweet = Model_Tweets::find_by_pk($tweet_id);
		if ($delete_tweet)
		    $delete_tweet->delete();
		Response::redirect('home');
	}




}