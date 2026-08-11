<?php

class Controller_expense_living_detail extends Controller_Base
{
	public function before()
	{
		parent::before();
		$this->template->js = [
			//'expense/living/create.js',
		];
		//echo \Asset::css('expense/living/list.css');
	}

	public function action_index($id)
	{
		$expense = Model_Expenseslivingmain::get_by_id($id);

		if (empty($expense)) {
			throw new HttpNotFoundException();
		}

		$items = Model_Expenseslivingsub::get_by_main_id($id);

		$data = [
			'expense' => $expense,
			'items' => $items,
		];
		DEBUG::dump($data);
		exit;

		return Response::forge(
			View::forge('expense/living/detail', $data)
		);
	}
}