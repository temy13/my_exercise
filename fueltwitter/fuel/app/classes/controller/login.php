<?php 
class Controller_Login extends Controller_Template {     

	public function before(){
	    parent::before();
	    if(Auth::check())
	    	Response::redirect('home');
	}


	public function action_login(){
		// ログイン処理
		$username = Input::post('username', null);
		$password = Input::post('password', null);
		$errmsg = " ";
		if ($username !== null && $password !== null) 
			$errmsg = $this->login_check($username,$password);

		$this->template->title = 'ログイン';
		$this->template->content = View::forge('login/login');
		$this->template->content->set_safe('errmsg', $errmsg);
	}

	public function login_check($username,$password){
		$validation = $this->validate_login();
		$errors = $validation->error();
		if (!empty($errors)) 
			return $validation->show_errors();
		
		$auth = Auth::instance(); // ログイン認証を行う
		if ($auth->login($username, $password)) 
			Response::redirect('home');// ログイン成功
		
		return "ログインに失敗しました。";	 
	}

	private function validate_login(){
		// 入力チェック
		$validation = Validation::forge();
		$validation->
			add_field('username', 'ユーザー名', 'required|min_length[4]|max_length[15]');
		$validation->
			add_field('password', 'パスワード', 'required|min_length[6]|max_length[20]');
		$validation->run();
		return $validation;
	}

	public function action_logout(){
		// ログアウト処理
		Auth::logout();
		//フラッシュ
		Session::set_flash('notice', "ログアウトしました");
		//リダイレクト
		$this->template->title = 'ログイン';
		$this->template->content = View::forge('login/login');
		$this->template->content->set_safe('errmsg', $errmsg);
	}
	 
}