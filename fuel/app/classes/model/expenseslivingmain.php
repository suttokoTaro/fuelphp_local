<?php

class Model_Expenseslivingmain extends \Orm\Model
{
	protected static $_table_name = 'expenses_living_main';

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
		$sql = 'SELECT COALESCE(MAX(`number`), 0) + 1 AS next_number'.PHP_EOL;
		$sql .= 'FROM '.self::table().PHP_EOL;
		$sql .= 'WHERE year = :year'.PHP_EOL;

		$params = ['year' => $year,];
		$result = DB::query($sql)->parameters($params)->execute()->current();
		return (int) $result['next_number'];
	}

	/**
	 * 条件に合致した日常生活費情報リストを取得する
	 * 
	 * @param array $conditions
	 * @return array
	 */
	public static function get_list($conditions)
	{
		$sql = 'SELECT m.*, s.name AS store_name, c.name AS category_name'.PHP_EOL;
		$sql .= 'FROM '.self::table().' m'.PHP_EOL;
		$sql .= 'INNER JOIN expenses_living_store_mst s ON s.id = m.store_id'.PHP_EOL;
		$sql .= 'INNER JOIN expenses_living_category_mst c ON c.id = m.category_id'.PHP_EOL;
		$sql .= 'WHERE m.year = :year'.PHP_EOL;
		$params = ['year' => $conditions['year'],];

		if ($conditions['paid_by'] !== 'all')
		{
			$sql .= 'AND paid_by = :paid_by'.PHP_EOL;
			$params['paid_by'] = $conditions['paid_by'];
		}
		$sql .= 'ORDER BY m.number ASC'.PHP_EOL;
		$result = DB::query($sql)->parameters($params)->execute()->as_array();
		return $result;
	}

	/**
	 * 日常生活費を登録する
	 * 
	 * @param array $datas
	 * @return int
	 */
	public static function insert($datas)
	{
		$sql = 'INSERT INTO '.self::table().' ('.PHP_EOL;
		$sql .= '	year, number, expense_date, store_id, title, amount, category_id, paid_by, note, created_at, updated_at'.PHP_EOL;
		$sql .= ') VALUES ('.PHP_EOL;
		$sql .= '	:year, :number, :expense_date, :store_id, :title, :amount, :category_id, :paid_by, :note, NOW(), NOW()'.PHP_EOL;
		$sql .= ')'.PHP_EOL;

		$params = [
			'year' => $datas['year'],
			'number' => $datas['number'],
			'expense_date' => $datas['expense_date'],
			'store_id' => $datas['store_id'],
			'title' => $datas['title'],
			'amount' => $datas['amount'],
			'category_id' => $datas['category_id'],
			'paid_by' => $datas['paid_by'],
			'note' => $datas['note'],
		];
		$result = DB::query($sql)->parameters($params)->execute();
		return $result[0];
	}
}