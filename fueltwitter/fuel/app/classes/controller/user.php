<?php 

class Controller_User extends Controller_Template {     
	public function before(){
	    parent::before();
	}

 	public function action_index(){
 		//user/indexのページは存在しないためどこかにリダイレクトさせる必要がある
 		 Response::redirect('home');
 	}
	public function action_create(){

		$username = Input::post('username', null);
		$password = Input::post('password', null);
		$email = Input::post('email', null);
		$errmsg = " ";
		if ($username !== null && $password !== null) 
			$errmsg = $this->create_check($username,$password,$email);
		// ユーザー作成
		$this->template->title = 'ユーザー作成';
		$this->template->content = View::forge('user/create');
		$this->template->content->set_safe('errmsg', "");
	}

	private function validate_create(){
		// 入力チェック
		$validation = Validation::forge();
		$validation
			->add_field('username', 'ユーザー名', 'required|min_length[4]|max_length[15]');
		$validation
			->add_field('password', 'パスワード', 'required|min_length[6]|max_length[20]');
		$validation
			->add_field('email', 'Eメール', 'required|valid_email');
		$validation->run();
		return $validation;
	}

	public function create_check($username,$password){
		$validation = $this->validate_create();
		$errors = $validation->error();
		if (!empty($errors)) 
			return $validation->show_errors();

		$auth = Auth::instance();
		$input = $validation->input();
		if ($auth->create_user($username, $password, $email)) 
			Response::redirect('login/login');
		
		return 'ユーザー作成に失敗しました。';
	}

	 
}