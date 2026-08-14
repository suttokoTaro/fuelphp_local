<?php

/**
 * 
 * 日常生活出費 一覧画面
 * 
 */
class Controller_Expense_Living_List extends Controller_Base
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
		$year = \Input::get('year', date('Y'));
		$paid_by = \Input::get('paid_by', 'all');

		$conditions = [
			'year' => $year,
			'paid_by' => $paid_by,
		];

		$expenses = Model_Expenseslivingmain::get_list($conditions);
		$total_amount = array_sum(array_column($expenses, 'amount'));

		$data = [
			'year' => $year,
			'paid_by' => $paid_by,
			'expenses' => $expenses,
			'total_amount' => $total_amount,
		];

		$view = \View::forge('expense/living/list', $data);
		$this->template->content = $view;
		return;
	}
}