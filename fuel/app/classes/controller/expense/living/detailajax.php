<?php

/**
 * 
 * 日常生活出費 詳細ダイアログ画面（ajax）
 * 
 */
class Controller_Expense_Living_Detailajax extends Controller
{
	public function action_index($id)
	{
		// idをもとに、メイン項目の取得
		$expense = Model_Expenseslivingmain::get_by_id($id);
		if (empty($expense))
		{
			throw new HttpNotFoundException();
		}

		// idをもとに、明細項目の取得
		$items = Model_Expenseslivingsub::get_by_main_id($id);

		$data = [
			'expense' => $expense,
			'items' => $items,
		];
		echo \Asset::css('expense/living/detailajax.css');
		return \Response::forge(
			\View::forge('expense/living/detail', $data)
		);
	}
}