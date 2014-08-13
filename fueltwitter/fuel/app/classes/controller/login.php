<?php 
class Controller_Login extends Controller_BaseTemplate {     
	public function before()
{
    parent::before();
}


public function action_login()
	{
		// ログイン処理
		$username = Input::post('username', null);
		$password = Input::post('password', null);
		$result_validate = '';
		if ($username !== null && $password !== null) {
			$validation = $this->validate_login();
			$errors = $validation->error();
			if (empty($errors)) {
				$auth = Auth::instance(); // ログイン認証を行う
				if ($auth->login($username, $password)) {
					Response::redirect('home');// ログイン成功
				}
				$result_validate = "ログインに失敗しました。";
			} else {
				$result_validate = $validation->show_errors();
			}
		}

		$this->template->title = 'ログイン';
		$this->template->content = View::forge('login/login');
		$this->template->content->set_safe('errmsg', $result_validate);
	}
	private function validate_login()
	{
		// 入力チェック
		$validation = Validation::forge();
		$validation->add('username', 'ユーザー名')
			->add_rule('required')
			->add_rule('min_length', 4)
			->add_rule('max_length', 15);
		$validation->add('password', 'パスワード')
			->add_rule('required')
			->add_rule('min_length', 6)
			->add_rule('max_length', 20);
		$validation->run();
		return $validation;
	}

	public function action_logout()
	{
		// ログアウト処理
		Auth::logout();
		$this->template->title = 'ログアウトしました';
		$this->template->content = View::forge('login/logout');
	}

	 
}