<?php
class Controller_AuthBase extends Controller_Base
{
	public function before()
	{
		parent::before();

		if (!\Auth::check()) {
			//return \Response::redirect('login');
		}
	}
}
