<?php

class Model_Expenseslivingsub extends \Orm\Model
{
	protected static $_table_name = 'expenses_living_sub';


	/**
	 * 日常生活費詳細情報を登録する
	 * 
	 * @param array $datas
	 */
	public static function insert($datas)
	{
		$sql = 'INSERT INTO '.self::table().' ('.PHP_EOL;
		$sql .= '	expenses_living_main_id, item_name, amount, detail_category_id, sort_order, created_at, updated_at'.PHP_EOL;
		$sql .= ') VALUES ('.PHP_EOL;
		$sql .= '	:expenses_living_main_id, :item_name, :amount, :detail_category_id, :sort_order, NOW(), NOW()'.PHP_EOL;
		$sql .= ')'.PHP_EOL;

		$params = [
			'expenses_living_main_id' => $datas['expenses_living_main_id'],
			'item_name' => $datas['item_name'],
			'amount' => $datas['amount'],
			'detail_category_id' => $datas['detail_category_id'],
			'sort_order' => $datas['sort_order'],
		];
		DB::query($sql)->parameters($params)->execute();
	}
}