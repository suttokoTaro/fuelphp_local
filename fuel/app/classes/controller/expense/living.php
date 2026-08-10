<?php

class Controller_expense_living extends Controller_Base
{
	/**
	 * 日常生活費入力画面
	 */
	public function action_create()
	{
		$data = [
			'errors' => [],
		];
		$categories = Model_Expenseslivingcategorymst::get_all();
		$stores = Model_Expenseslivingstoremst::get_all();
		$detail_categories = Model_Expenseslivingdetailcategorymst::get_all();
		$data['categories'] = $categories;
		$data['stores'] = $stores;
		$data['detail_categories'] = $detail_categories;

		if (Input::method() === 'POST') {
			$validation = $this->get_validation();

			if ($validation->run()) {
				$expense_date = Input::post('expense_date');
				$year = (int) date('Y', strtotime($expense_date));

				$expense = Model_Expenseslivingmain::forge([
					'year' => $year,
					'number' => Model_Expenseslivingmain::get_next_number($year),
					'expense_date' => $expense_date,
					'store_id' => (int) Input::post('store_id'),
					'title' => Input::post('title'),
					'amount' => (int) Input::post('amount'),
					'category_id' => (int) Input::post('category_id'),
					'paid_by' => Input::post('paid_by'),
					'note' => Input::post('note'),
				]);

				if ($expense->save()) {
					Session::set('test', 'hello');
					Session::set_flash('success', '日常生活費を登録しました。');

					return Response::redirect('expense/living/create');
				}
			}

			$data['errors'] = $validation->error();
		}
		$view = View::forge('expense/living/create', $data);
		$this->template->content = $view;
		return;

		return Response::forge(
			View::forge('expense/living/create', $data)
		);
	}

	/**
	 * バリデーション
	 */
	private function get_validation()
	{
		$validation = Validation::forge();

		$validation
			->add('expense_date', '支出日')
			->add_rule('required');

		$validation
			->add('store_id', 'お店')
			->add_rule('required')
			->add_rule('valid_string', ['numeric']);

		$validation
			->add('title', 'タイトル')
			->add_rule('required')
			->add_rule('max_length', 255);

		$validation
			->add('amount', '金額')
			->add_rule('required')
			->add_rule('valid_string', ['numeric']);

		$validation
			->add('category_id', 'カテゴリ')
			->add_rule('required')
			->add_rule('valid_string', ['numeric']);

		$validation
			->add('paid_by', '支払元')
			->add_rule('required');

		return $validation;
	}

}