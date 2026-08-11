<?php

class Controller_expense_living_detailajax extends Controller
{
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
		echo \Asset::css('expense/living/detailajax.css');
		return Response::forge(
			View::forge('expense/living/detail', $data)
		);
	}
}