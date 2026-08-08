<?php
class Controller_Top extends Controller_Base
{
	public function before()
	{
		parent::before();
	}

	public function action_index()
	{
		$data = [];
		$view = \View::forge('top', $data);
		$this->template->content = $view;
	}
}