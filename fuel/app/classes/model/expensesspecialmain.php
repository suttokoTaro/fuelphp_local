<?php

/**
 * 
 * 特別支出_メイン
 * 
 */
class Model_Expensesspecialmain extends \Orm\Model
{
	protected static $_table_name = 'expenses_special_main';

	public static function get_next_number($year)
	{
		$sql = 'SELECT'.PHP_EOL;
		$sql .= '	COALESCE(MAX(number), 0) + 1 AS next_number'.PHP_EOL;
		$sql .= 'FROM '.self::table().PHP_EOL;
		$sql .= 'WHERE year = :year';

		$params = [
			'year' => $year,
		];

		$result = DB::query($sql)
			->parameters($params)
			->execute()
			->current();

		return (int) $result['next_number'];
	}
	public static function insert_data($datas)
	{
		$sql = 'INSERT INTO '.self::table().' ('.PHP_EOL;
		$sql .= '	year,'.PHP_EOL;
		$sql .= '	number,'.PHP_EOL;
		$sql .= '	expense_date,'.PHP_EOL;
		$sql .= '	title,'.PHP_EOL;
		$sql .= '	amount,'.PHP_EOL;
		$sql .= '	category_id,'.PHP_EOL;
		$sql .= '	paid_by,'.PHP_EOL;
		$sql .= '	note,'.PHP_EOL;
		$sql .= '	created_at,'.PHP_EOL;
		$sql .= '	updated_at'.PHP_EOL;
		$sql .= ') VALUES ('.PHP_EOL;
		$sql .= '	:year,'.PHP_EOL;
		$sql .= '	:number,'.PHP_EOL;
		$sql .= '	:expense_date,'.PHP_EOL;
		$sql .= '	:title,'.PHP_EOL;
		$sql .= '	:amount,'.PHP_EOL;
		$sql .= '	:category_id,'.PHP_EOL;
		$sql .= '	:paid_by,'.PHP_EOL;
		$sql .= '	:note,'.PHP_EOL;
		$sql .= '	NOW(),'.PHP_EOL;
		$sql .= '	NOW()'.PHP_EOL;
		$sql .= ')';

		$params = [
			'year' => $datas['year'],
			'number' => $datas['number'],
			'expense_date' => $datas['expense_date'],
			'title' => $datas['title'],
			'amount' => $datas['amount'],
			'category_id' => $datas['category_id'],
			'paid_by' => $datas['paid_by'],
			'note' => $datas['note'],
		];

		$result = DB::query($sql)
			->parameters($params)
			->execute();
		return $result[0];
	}
}