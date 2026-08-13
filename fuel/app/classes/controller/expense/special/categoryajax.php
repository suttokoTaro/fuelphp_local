<?php

/**
 * 
 * 特別支出 カテゴリ編集画面
 * 
 */
class Controller_Expense_Special_Categoryajax extends Controller
{
	public function action_index()
	{
		$year = Input::get('year');

		if (empty($year)) {
			return Response::forge(
				json_encode([]),
				400,
				[
					'Content-Type' => 'application/json',
				]
			);
		}

		$categories = Model_Expensesspecialcategorymst::get_by_year($year);

		$result = [];

		foreach ($categories as $category) {
			$result[] = [
				'id' => $category['id'],
				'name' => $category['name'],
			];
		}

		return Response::forge(
			json_encode($result),
			200,
			[
				'Content-Type' => 'application/json',
			]
		);
	}
}