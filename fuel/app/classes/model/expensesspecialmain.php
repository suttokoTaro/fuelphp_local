<?php

/**
 * 
 * 特別支出_メイン
 * 
 */
class Model_Expensesspecialmain extends \Orm\Model
{
	protected static $_table_name = 'expenses_special_main';

	/* 立て替え人 */
	const PAID_BY_SHARED = '1';
	const PAID_BY_NAOYA = '2';
	const PAID_BY_MAYU = '3';
	const PAID_BY_MAP = [
		self::PAID_BY_SHARED => '共有口座',
		self::PAID_BY_NAOYA => '直也',
		self::PAID_BY_MAYU => 'まゆ',
	];

	/**
	 * 指定した年の次の番号を取得する
	 * 
	 * @param int $year
	 * @return int
	 */
	public static function get_next_number($year)
	{
		$sql = 'SELECT COALESCE(MAX(number), 0) + 1 AS next_number'.PHP_EOL;
		$sql .= 'FROM '.self::table().PHP_EOL;
		$sql .= 'WHERE year = :year';

		$params = ['year' => $year,];
		$result = DB::query($sql)->parameters($params)->execute()->current();
		return (int) $result['next_number'];
	}

	/**
	 * 条件に合致した特別支出情報リストを取得する
	 * 
	 * @param array $conditions
	 * @return array
	 */
	public static function get_list($conditions)
	{
		$sql = 'SELECT m.*, c.name AS category_name'.PHP_EOL;
		$sql .= 'FROM '.self::table().' m'.PHP_EOL;
		$sql .= 'LEFT JOIN expenses_special_category_mst c'.PHP_EOL;
		$sql .= '	ON c.id = m.category_id'.PHP_EOL;
		$sql .= 'WHERE m.year = :year'.PHP_EOL;
		$params = ['year' => $conditions['year'],];

		if ($conditions['category_id'] !== 'all')
		{
			$sql .= '	AND m.category_id = :category_id'.PHP_EOL;
			$params['category_id'] = $conditions['category_id'];
		}
		if ($conditions['paid_by'] !== 'all')
		{
			$sql .= '	AND m.paid_by = :paid_by'.PHP_EOL;
			$params['paid_by'] = $conditions['paid_by'];
		}
		$sql .= 'ORDER BY m.number ASC'.PHP_EOL;
		$result = DB::query($sql)->parameters($params)->execute()->as_array();
		return $result;
	}

	/**
	 * 主キーをもとに、特別支出情報を取得する
	 * 
	 * @param int $id
	 * @return array
	 */
	public static function get_by_id($id)
	{
		$sql = 'SELECT m.*, c.name AS category_name'.PHP_EOL;
		$sql .= 'FROM '.self::table().' m'.PHP_EOL;
		$sql .= 'LEFT JOIN expenses_special_category_mst c'.PHP_EOL;
		$sql .= '	ON c.id = m.category_id'.PHP_EOL;
		$sql .= 'WHERE m.id = :id'.PHP_EOL;
		$params = ['id' => $id,];
		$result = \DB::query($sql)->parameters($params)->execute()->current();
		return $result;
	}

	/**
	 * 特別支出を登録する
	 * 
	 * @param array $datas
	 * @return int
	 */
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