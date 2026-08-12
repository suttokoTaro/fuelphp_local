<?php

/**
 * 
 * 日常生活費 新規登録画面
 * 
 */
class Controller_expense_living_create extends Controller_Base
{
	public function before()
	{
		parent::before();
		$this->template->js = [
			'expense/living/create.js',
		];
		echo \Asset::css('expense/living/create.css');
	}

	public function action_index()
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

		if (Input::method() === 'POST')
		{
			$form = Input::post();
			$validation = $this->get_validation();
			
			// メイン項目のバリデーション
			if (!$validation->run())
			{
				$data['errors'] = $validation->error();
				$data['form'] = $form;
			}
			else
			{
				$expense_date = Input::post('expense_date');
				$year = (int) date('Y', strtotime($expense_date));
				try
				{
					DB::start_transaction();
					$number = Model_Expenseslivingmain::get_next_number($year);
					$params = [
						'year' => $year,
						'number' => $number,
						'expense_date' => $expense_date,
						'store_id' => $form['store_id'],
						'title' => $form['title'],
						'amount' => $form['amount'],
						'category_id' => $form['category_id'],
						'paid_by' => $form['paid_by'],
						'note' => $form['note'],
					];
					$main_id = Model_Expenseslivingmain::insert_by_id($params);

					foreach ($form['items'] as $index => $item)
					{
						// 完全な空行なら無視
						if (empty($item['item_name']))
						{
							continue;
						}
						$detail_category_id = !empty($item['detail_category_id']) ? (int) $item['detail_category_id'] : null;
						$params = [
							'expenses_living_main_id' => $main_id,
							'item_name' => $item['item_name'],
							'amount' => (int) $item['amount'],
							'detail_category_id' => $detail_category_id,
							'sort_order' => $index + 1,
						];
						Model_Expenseslivingsub::insert($params);
					}
					DB::commit_transaction();
					Session::set_flash('success', '日常生活費を登録しました。');
					return Response::redirect('expense/living/create');
				}
				catch (Exception $e)
				{
					DB::rollback_transaction();
					Log::error('生活費登録エラー: '.$e->getMessage());
					Session::set_flash('error','登録に失敗しました。');
					$data['form'] = $form;
				}
			}
		}
		$view = View::forge('expense/living/create', $data);
		$this->template->content = $view;
		return;
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