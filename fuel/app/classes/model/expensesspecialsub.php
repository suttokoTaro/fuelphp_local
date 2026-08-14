<?php

/**
 * 
 * 特別支出_詳細
 * 
 */
class Model_Expensesspecialsub extends \Orm\Model
{
	protected static $_table_name = 'expenses_special_sub';

	/**
	 * メインIDをもとに、特別支出の詳細情報リストを取得する
	 * 
	 * @param int $main_id
	 */
	public static function get_by_main_id($main_id)
	{
		$sql = 'SELECT *'.PHP_EOL;
		$sql .= 'FROM '.self::table().PHP_EOL;
		$sql .= 'WHERE expenses_special_main_id = :main_id'.PHP_EOL;
		$sql .= 'ORDER BY sort_order ASC, id ASC'.PHP_EOL;
		$params = ['main_id' => $main_id,];
		$result = DB::query($sql)->parameters($params)->execute()->as_array();
		return $result;
	}

	public static function insert_data($datas)
	{
		$sql = 'INSERT INTO '.self::table().' ('.PHP_EOL;
		$sql .= '	expenses_special_main_id,'.PHP_EOL;
		$sql .= '	item_name,'.PHP_EOL;
		$sql .= '	amount,'.PHP_EOL;
		$sql .= '	sort_order,'.PHP_EOL;
		$sql .= '	created_at,'.PHP_EOL;
		$sql .= '	updated_at'.PHP_EOL;
		$sql .= ') VALUES ('.PHP_EOL;
		$sql .= '	:main_id,'.PHP_EOL;
		$sql .= '	:item_name,'.PHP_EOL;
		$sql .= '	:amount,'.PHP_EOL;
		$sql .= '	:sort_order,'.PHP_EOL;
		$sql .= '	NOW(),'.PHP_EOL;
		$sql .= '	NOW()'.PHP_EOL;
		$sql .= ')';

		$params = [
			'main_id'
				=> $datas['main_id'],

			'item_name'
				=> $datas['item_name'],

			'amount'
				=> $datas['amount'],

			'sort_order'
				=> $datas['sort_order'],
		];

		DB::query($sql)
			->parameters($params)
			->execute();
	}
}