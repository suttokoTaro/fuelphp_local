<?php

class Model_Expenseslivingsub extends \Orm\Model
{
	protected static $_table_name = 'expenses_living_sub';

	public static function get_by_main_id($main_id)
	{
		$sql = 'SELECT s.*, c.name AS detail_category_name'.PHP_EOL;
		$sql .= 'FROM '.self::table().' s'.PHP_EOL;
		$sql .= 'LEFT JOIN expenses_living_detail_category_mst c ON c.id = s.detail_category_id'.PHP_EOL;
		$sql .= 'WHERE s.expenses_living_main_id = :main_id'.PHP_EOL;
		$params = ['main_id' => $main_id,];
		$result = DB::query($sql)->parameters($params)->execute()->as_array();
		return $result;
	}

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