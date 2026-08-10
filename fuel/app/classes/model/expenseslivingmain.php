<?php

class Model_Expenseslivingmain extends \Orm\Model
{
	protected static $_table_name = 'expenses_living_main';

	/* 立て替え人 */
	const PAID_BY_SHARED = '1';
	const PAID_BY_NAOYA = '2';
	const PAID_BY_MAYU = '3';

	/**
	 * 指定した年の次の番号を取得する
	 * 
	 * @param int $year
	 * @return int
	 */
	public static function get_next_number($year)
	{
		$sql = 'SELECT COALESCE(MAX(`number`), 0) + 1 AS next_number'.PHP_EOL;
		$sql .= 'FROM '.self::table().PHP_EOL;
		$sql .= 'WHERE year = :year'.PHP_EOL;

		$params = ['year' => $year,];
		$result = DB::query($sql)->parameters($params)->execute()->current();
		return (int) $result['next_number'];
	}

}