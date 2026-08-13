<?php

/**
 * 
 * 特別支出 新規登録画面
 * 
 */
class Controller_Expense_Special_Create extends Controller_Base
{
	public function before()
	{
		parent::before();
		$this->template->js = [
			'expense/special/create.js',
		];
		echo \Asset::css('expense/special/create.css');
	}

	public function action_index()
	{
		$data = [
			'errors' => [],
		];
		$year = Input::method() === 'POST' ? Input::post('year', date('Y')) : date('Y');
		$categories = Model_Expensesspecialcategorymst::get_by_year($year);

		if (Input::method() === 'POST')
		{
			$datas = [
				'expense_date' => Input::post('expense_date'),
				'title' => Input::post('title'),
				'amount' => Input::post('amount'),
				'category_id' => Input::post('category_id'),
				'paid_by' => Input::post('paid_by'),
				'note' => Input::post('note'),
			];
			// この後validation・登録処理
		}
		
		$data['year'] = $year;
		$data['categories'] = $categories;
		$view = View::forge('expense/special/create', $data);
		$this->template->content = $view;
	}
}