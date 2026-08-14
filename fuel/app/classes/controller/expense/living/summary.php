<?php

/**
 * 
 * 日常生活出費 サマリ画面
 * 
 */
class Controller_Expense_Living_Summary extends Controller_Base
{
	public function before()
	{
		parent::before();
		$this->template->js = [
			//'expense/living/summary.js',
		];
		echo \Asset::css('expense/living/summary.css');
	}

	public function action_index()
	{
		$year = \Input::get('year', date('Y'));
		$categories = Model_Expenseslivingcategorymst::get_all();
		$summary = Model_Expenseslivingmain::get_summary_by_year($year);

		$data = [
			'year' => $year,
			'categories' => $categories,
			'summary' => $summary,
		];

		$view = \View::forge('expense/living/summary', $data);
		$this->template->content = $view;
		return;
	}
}