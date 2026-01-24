<?php
class Controller_Login extends Controller_Base
{
	public function action_index()
	{
		if (\Auth::check()) {
			\Auth::logout();
		}

		$data = [];
		//$data['users'] = Model_User::get_all_users();
		$post = \Input::post();
		if ($post) {
			$val = \Validation::forge();
			$val->add('username', 'username')
				->add_rule('required');
			$val->add('password', 'password')
				->add_rule('required');
			if (!$val->run()) {
				$data['error_message'] = '入力は必須です';
				$view = \View::forge('login', $data);
				$this->template->content = $view;
				return;
			}
		}
		$username = \Input::post('username');
		$password = \Input::post('password');

		if (\Input::post('login') !== null) {
			if (\Auth::login($username, $password)) {
				$user_id = \Auth::get_user_id()[1];
				\Session::set('user_id', $user_id);
				return \Response::redirect('menu');
			} else {
				$data['error_message'] = 'ログイン失敗です';
				$view = \View::forge('login', $data);
				$this->template->content = $view;
				return;
			}
		}

		try {
			if (\Input::post('signup') !== null) { // 「新規登録」ボタン押下時処理
				if (Model_User::get_by_username($username)) {
					$data['error_message'] = 'usernameはすでに使われています';
					$view = \View::forge('login', $data);
					$this->template->content = $view;
					return;
				}
				$userId = \Auth::create_user($username, $password, Model_User::generate_random_email(10));
				$data['message'] = 'ユーザ登録しました';
			}
			$view = \View::forge('login', $data);
			$this->template->content = $view;

		} catch (\Exception $e) {
			//$data['error_message'] = $e->getMessage();
			$data['error_message'] = 'ユーザ登録に失敗しました';
			$view = \View::forge('login', $data);
			$this->template->content = $view;
		}
	}
}
