<?php

/**
 * 
 * 特別支出 詳細ダイアログ画面（ajax）
 * 
 */
class Controller_Expense_Special_Detailajax extends Controller
{
	public function action_index($id)
	{
		// idをもとに、メイン項目の取得
		$expense = Model_Expensesspecialmain::get_by_id($id);
		if (empty($expense))
		{
			throw new HttpNotFoundException();
		}

		// idをもとに、明細項目の取得
		$items = Model_Expensesspecialsub::get_by_main_id($id);

		$data = [
			'expense' => $expense,
			'items' => $items,
		];

		return \Response::forge(
			\View::forge('expense/special/detail', $data)
		);
	}
}