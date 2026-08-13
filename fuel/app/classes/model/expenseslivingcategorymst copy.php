<?php

/**
 * 
 * 特別支出_カテゴリマスタ
 * 
 */
class Model_Expensesspecialcategorymst extends \Orm\Model
{
	protected static $_table_name = 'expenses_special_category_mst';
	const IS_ACTIVE_ON = 1;

	/**
	 * 年をもとに、カテゴリ一覧を取得する
	 * 
	 * @param int $year
	 * @return array
	 */
	public static function get_by_year($year)
	{
		$sql = 'SELECT *'.PHP_EOL;
		$sql .= 'FROM '.self::table().PHP_EOL;
		$sql .= 'WHERE year = :year'.PHP_EOL;
		$sql .= 'AND is_active = '.self::IS_ACTIVE_ON.PHP_EOL;
		$sql .= 'ORDER BY sort_order ASC, id ASC';

		$params = ['year' => $year,];
		$result = DB::query($sql)->parameters($params)->execute()->as_array();
		return $result;
	}
}