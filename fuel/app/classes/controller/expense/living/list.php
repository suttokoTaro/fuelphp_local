<?php

class Controller_expense_living_list extends Controller_Base
{
	public function before()
	{
		parent::before();
		$this->template->js = [
			'expense/living/list.js',
		];
		echo \Asset::css('expense/living/list.css');
	}

	public function action_index()
	{
		$year = Input::get('year', date('Y'));
		$paid_by = Input::get('paid_by', 'all');

		$conditions = [
			'year' => $year,
			'paid_by' => $paid_by,
		];

		$data = [
			'year' => $year,
			'paid_by' => $paid_by,
			'expenses' => Model_Expenseslivingmain::get_list($conditions),
		];

		// DEBUG::dump($data);
		// exit;

		$view = View::forge('expense/living/list', $data);
		$this->template->content = $view;
		return;
	}
}