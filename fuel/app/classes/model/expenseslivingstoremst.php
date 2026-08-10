<?php

class Model_Expenseslivingstoremst extends \Orm\Model
{
	protected static $_table_name = 'expenses_living_store_mst';

	/**
	 * すべてのレコードを取得する
	 * 
	 * @return array
	 */
	public static function get_all()
	{
		$sql = 'SELECT *'.PHP_EOL;
		$sql .= 'FROM '.self::table().PHP_EOL;
		$sql .= 'ORDER BY sort_order ASC'.PHP_EOL;

		$result = DB::query($sql)->execute()->as_array();
		return $result;
	}
}