<?php 


class Controller_User extends Controller_BaseTemplate {     
	public function before()
{
    parent::before();
}

 	public function action_index(){
 		 Response::redirect('user/create');

 	}
public function action_create()
	{
		// ユーザー作成
		$this->template->title = 'ユーザー作成';
		$this->template->content = View::forge('user/create');
		$this->template->content->set_safe('errmsg', "");
	}

	private function validate_create()
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
		$validation->add('email', 'Eメール')
			->add_rule('required')
			->add_rule('valid_email');
		$validation->run();
		return $validation;
	}

	public function action_created()
	{
		// ユーザー登録
		$validation = $this->validate_create();
		$errors = $validation->error();
		try {
			if (empty($errors)) {
				$auth = Auth::instance();
				$input = $validation->input();
				if ($auth->create_user($input['username'], $input['password'], $input['email'])) {
					$this->template->title = 'ユーザー登録完了';
					$this->template->content = View::forge('user/created');
					return;
				}
				$result_validate = 'ユーザー作成に失敗しました。';
			} else {
				$result_validate = $validation->show_errors();
			}
		} catch (SimpleUserUpdateException $e) {
			$result_validate = $e->getMessage();
		}
		$this->template->title = 'ユーザー作成';
		$this->template->content = View::forge('user/create');
		$this->template->content->set_safe('errmsg', $result_validate);
	}

	 
}