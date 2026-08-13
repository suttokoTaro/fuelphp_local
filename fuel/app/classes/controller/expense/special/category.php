<?php

/**
 * 
 * 特別支出 カテゴリ編集画面
 * 
 */
class Controller_Expense_Special_Category extends Controller_Base
{
	public function before()
	{
		parent::before();
		$this->template->js = [
			'expense/special/category.js',
		];
		echo \Asset::css('expense/special/category.css');
	}

	public function action_index()
	{
		$year = Input::method() === 'POST' ? Input::post('year', date('Y')) : Input::get('year', date('Y'));

		if (Input::method() === 'POST')
		{
			$categories = Input::post('categories', []);
			
			try
			{
				DB::start_transaction();

				// 現在DBに登録されているカテゴリ
				$db_categories = Model_Expensesspecialcategorymst::get_by_year($year);
				$db_ids = [];
				foreach ($db_categories as $category)
				{
					$db_ids[] = (int) $category['id'];
				}

				// POSTされた既存ID
				$post_ids = [];
				foreach ($categories as $category)
				{
					$id = !empty($category['id']) ? (int) $category['id'] : null;
					$name = trim($category['name'] ?? '');
					$sort_order = isset($category['sort_order']) ? (int) $category['sort_order'] : 0;

					// カテゴリ名が空なら登録しない
					if ($name === '')
					{
						continue;
					}

					if ($id)
					{
						$params = [
							'id' => $id,
							'year' => $year,
							'name' => $name,
							'sort_order' => $sort_order,
						];

						// UPDATE
						Model_Expensesspecialcategorymst::update_data($params);
						$post_ids[] = $id;
					}
					else
					{
						$params = [
							'year' => $year,
							'name' => $name,
							'sort_order' => $sort_order,
						];

						// INSERT
						Model_Expensesspecialcategorymst::insert_data($params);
					}
				}

				// POSTされなかった既存カテゴリ
				$delete_ids = array_diff($db_ids, $post_ids);
				foreach ($delete_ids as $id)
				{
					Model_Expensesspecialcategorymst::logical_delete($id, $year);
				}
				DB::commit_transaction();
				Response::redirect('expense/special/category?year='.$year);
			}
			catch (\Exception $e)
			{
				DB::rollback_transaction();
				throw $e;
			}
		}

		$year = Input::get('year', date('Y'));
		$categories = Model_Expensesspecialcategorymst::get_by_year($year);

		$data = [
			'year' => $year,
			'categories' => $categories,
		];

		$view = View::forge('expense/special/category', $data);
		$this->template->content = $view;
		return;
	}
}