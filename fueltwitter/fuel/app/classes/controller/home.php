<?php 

class Controller_Home extends Controller_Template { 

　　　　public function before(){
　　　　　　　　parent::before();
　　　　　　　　if(!Auth::check())
　　　　　　　　　　　　Response::redirect('login/login');
　　　　　　　　Config::load('upload', true);
　　　　}

　　　　public function action_index(){

　　　　　　　　$data = array();
　　　　　　　　$data['all_tweets'] = Model_Tweets::find(array(
　　　　　　　　　　　　'all', 
　　　　　　　　　　　　'order_by' => array('created_at' => 'desc')
　　　　　　　　));
　　　　　　　　$data['user_id'] = Auth::get('id');
　　　　　　　　$data['last_update'] =  Date::time('UTC')->format('mysql');
　　　　　　　　$this->template->title = Auth::get('username').'さんのタイムライン';
　　　　　　　　$this->template->content = View::forge('home/index',$data);
　　　　　　　　$this->template->content->set_safe('errmsg', "");
　　　　}

　　　　public function action_create(){

　　　　　　　　if(Input::method() == 'POST'){
　　　　　　　　　　　　$notice = "ツイートしました";
　　　　　　　　　　　　$image_path = null;
　　　　　　　　　　　　//画像保存
　　　　　　　　　　　　Upload::process(array('path' => Config::get('upload.path')));
　　　　　　　　　　　　if (Upload::is_valid()) 
　　　　　　　　　　　　$image_path = '/uploads/'.UpLoad::get_files()[0]["name"];
            
　　　　　　　　　　　　//tweet保存
　　　　　　　　　　　　$tweet = Model_Tweets::forge(array(
　　　　　　　　　　　　'user_id' => Auth::get('id'),
　　　　　　　　　　　　　　　　'username' => Auth::get('username'),
　　　　　　　　　　　　　　　　'content' => Input::post('content'),
　　　　　　　　　　　　　　　　'image_path' => $image_path,
　　　　　　　　　　　　　　　　'created_at' => Date::time('UTC')->format('mysql'),
　　　　　　　　　　　　));
　　　　　　　　　　　　if(!$tweet->save())
　　　　　　　　　　　　　　　　$notice = "つぶやきに失敗しました";
　　　　　　　　　　　　elseif(Upload::is_valid())
　　　　　　　　　　　　　　　　Upload::save();
　　　　　　　　}
　　　　　　　　Session::set_flash('notice', $notice);
　　　　　　　　Response::redirect('home');
　　　　}
　　　　//ajaxによるリロード
　　　　public function action_reload(){
    
　　　　　　　　$last_update = Input::post('last');
　　　　　　　　$data = array();
　　　　　　　　$data["tweet"] = Model_Tweets::find(array(
　　　　　　　　　　　　'all', 
　　　　　　　　　　　　'where' => array(array('created_at' , '>' , $last_update)),
　　　　　　　　　　　　'order_by' => array('created_at' => 'asc')
　　　　　　　　));
　　　　　　　　$data["user_id"] = Auth::get('id');
　　　　　　　　$data["base_url"] = Config::get('base_url');
　　　　　　　　$data["last_update"] = Date::time('UTC')->format('mysql');
　　　　　　　　return json_encode($data);
　　　　}
　　　　public function action_delete($tweet_id){
　　　　　　　　$delete_tweet = Model_Tweets::find_by_pk($tweet_id);
　　　　　　　　if ($delete_tweet)
　　　　　　　　　　　　$delete_tweet->delete();
　　　　　　　　Session::set_flash('notice', 'ツイートを削除しました');
　　　　　　　　Response::redirect('home');
　　　　}
}