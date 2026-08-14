<?php

/**
 * 
 * 特別支出 一覧画面
 * 
 */
class Controller_Expense_Special_List extends Controller_Base
{
	public function before()
	{
		parent::before();
		$this->template->js = [
			'expense/special/list.js',
		];
		echo \Asset::css('expense/special/list.css');
	}

	public function action_index()
	{
		$year = \Input::get('year', date('Y'));
		$category_id = \Input::get('category_id', 'all');
		$paid_by = \Input::get('paid_by', 'all');
		$categories = Model_Expensesspecialcategorymst::get_by_year($year);

		$conditions = [
			'year'        => $year,
			'category_id' => $category_id,
			'paid_by'     => $paid_by,
		];

		$expenses = Model_Expensesspecialmain::get_list($conditions);
		$total_amount = array_sum(array_column($expenses, 'amount'));

		$data = [
			'year'         => $year,
			'category_id'  => $category_id,
			'paid_by'      => $paid_by,
			'categories'   => $categories,
			'expenses'     => $expenses,
			'total_amount' => $total_amount,
		];

		$view = \View::forge('expense/special/list', $data);
		$this->template->content = $view;
		return;
	}
}