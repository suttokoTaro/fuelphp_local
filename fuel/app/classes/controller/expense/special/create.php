<?php

/**
 * 
 * 特別支出 新規登録画面
 * 
 */
class Controller_Expense_Special_Create extends Controller_Base
{
	private $data = [];
	
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
		// viewに受け渡すデータのセット
		$this->set_data();

		// POSTの場合
		if (\Input::method() === 'POST')
		{
			$form = \Input::post();
			$validation = $this->get_validation();

			// メイン項目のバリデーション
			if (!$validation->run())
			{
				$this->data['errors'] = $validation->error();
				$this->data['form'] = $form;
			}
			else
			{
				$category_id = $form['category_id'];
				$category = Model_Expensesspecialcategorymst::get_by_id_and_year($category_id, $this->data['year']);
				if (empty($category))
				{
					$validation->error('category_id')->set_message('支出日の年に存在しないカテゴリです。');
				}
				else
				{
					try
					{
						\DB::start_transaction();

						$number = Model_Expensesspecialmain::get_next_number($this->data['year']);
						$params = [
							'year' => $this->data['year'],
							'number' => $number,
							'expense_date' => $form['expense_date'],
							'title' => $form['title'],
							'amount' => $form['amount'],
							'category_id' => $category_id,
							'paid_by' => $form['paid_by'],
							'note' => $form['note'],
						];
						$main_id = Model_Expensesspecialmain::insert_data($params);

						foreach ($form['items'] as $index => $item)
						{
							// 明細名が空の場合スルー
							if (empty($item['item_name']))
							{
								continue;
							}
							$params = [
								'expenses_special_main_id' => $main_id,
								'item_name' => $item['item_name'],
								'amount' => (int) $item['amount'],
								'sort_order' => $index + 1,
							];
							Model_Expensesspecialsub::insert_data($params);
						}

						\DB::commit_transaction();
						\Session::set_flash('success', '日常生活費を登録しました。');
						\Response::redirect('expense/special/create');
					}
					catch (\Exception $e)
					{
						DB::rollback_transaction();
						\Log::error('特別支出登録エラー: '.$e->getMessage());
						\Session::set_flash('error','登録に失敗しました。');
						$this->data['form'] = $form;
					}
				}
			}
		}	
		$view = View::forge('expense/special/create', $this->data);
		$this->template->content = $view;
		return;
	}

	/**
	 * Viewに渡すデータのセット
	 * 
	 * @return void
	 */
	private function set_data()
	{
		// 初期化
		$this->data = ['errors' => [],];

		$expense_date = \Input::post('expense_date', date('Y-m-d'));
		$year = date('Y', strtotime($expense_date));
		$categories = Model_Expensesspecialcategorymst::get_by_year($year);
		
		$this->data['year'] = $year;
		$this->data['categories'] = $categories;
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