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
		$expense_date = Input::post('expense_date', date('Y-m-d'));
		$year = date('Y', strtotime($expense_date));
		$categories = Model_Expensesspecialcategorymst::get_by_year($year);

		if (Input::method() === 'POST')
		{
			$form = Input::post();
			$validation = $this->get_validation();
			if ($validation->run())
			{
				$category_id = Input::post('category_id');
				// ========================================
				// カテゴリと支出日の年が一致しているか
				// ========================================
				$category = Model_Expensesspecialcategorymst::get_by_id_and_year($category_id, $year);
				if (empty($category))
				{
					$validation->error('category_id')->set_message('支出日の年に存在しないカテゴリです。');
				}
				else
				{
					try
					{
						DB::start_transaction();
						$number = Model_Expensesspecialmain::get_next_number($year);
						
						$params = [
							'year' => $year,
							'number' => $number,
							'expense_date' => Input::post('expense_date'),
							'title' => Input::post('title'),
							'amount' => Input::post('amount'),
							'category_id' => $category_id,
							'paid_by' => Input::post('paid_by'),
							'note' => Input::post('note'),
						];
						$main_id = Model_Expensesspecialmain::insert_data($params);

						$items = Input::post('items', []);
						$sort_order = 1;
						foreach ($items as $item)
						{
							$item_name = trim($item['item_name'] ?? '');
							$item_amount = $item['amount'] ?? '';
	
							// 完全な空行は登録しない
							if ($item_name === '' && $item_amount === '')
							{
								continue;
							}
							$params = [
								'expenses_special_main_id' => $main_id,
								'item_name' => $item_name,
								'amount' => $item_amount === '' ? 0 : $item_amount,
								'sort_order' => $sort_order,
							];
							
							Model_Expensesspecialsub::insert_data($params);
							$sort_order++;
						}
						DB::commit_transaction();
						Response::redirect('expense/special/index');
					}
					catch (\Exception $e)
					{
						DB::rollback_transaction();
						throw $e;
					}
				}
			}
		}	
		
		$data['year'] = $year;
		$data['categories'] = $categories;
		$view = View::forge('expense/special/create', $data);
		$this->template->content = $view;
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
			->add('title', 'タイトル')
			->add_rule('required')
			->add_rule('max_length', 255);
		$validation
			->add('category_id', 'カテゴリ')
			->add_rule('required');
		$validation
			->add('amount', '合計金額')
			->add_rule('required')
			->add_rule('valid_string', ['numeric']);
		$validation
			->add('paid_by', '立替者')
			->add_rule('required');

		return $validation;
	}
}