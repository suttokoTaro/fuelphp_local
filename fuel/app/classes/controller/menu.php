<?php
class Controller_Menu extends Controller_AuthBase
{
	public function before()
	{
		parent::before();
	}

	public function action_index()
	{
		$data = [];
		$view = \View::forge('menu', $data);
		$this->template->content = $view;
	}
}
