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
	
	public static function insert_data($datas)
	{
		$sql = 'INSERT INTO '.self::table().' ('.PHP_EOL;
		$sql .= '	year, name, sort_order, is_active, created_at, updated_at'.PHP_EOL;
		$sql .= ') VALUES ('.PHP_EOL;
		$sql .= '	:year, :name, :sort_order, 1, NOW(), NOW()'.PHP_EOL;
		$sql .= ')';

		$params = [
			'year' => $datas['year'],
			'name' => $datas['name'],
			'sort_order' => $datas['sort_order'],
		];

		DB::query($sql)->parameters($params)->execute();
	}

	public static function update_data($datas)
	{
		$sql = 'UPDATE '.self::table().' SET'.PHP_EOL;
		$sql .= '	name = :name,'.PHP_EOL;
		$sql .= '	sort_order = :sort_order,'.PHP_EOL;
		$sql .= '	updated_at = NOW()'.PHP_EOL;
		$sql .= 'WHERE id = :id'.PHP_EOL;
		$sql .= 'AND year = :year'.PHP_EOL;
		$sql .= 'AND is_active = 1';

		$params = [
			'id' => $datas['id'],
			'year' => $datas['year'],
			'name' => $datas['name'],
			'sort_order' => $datas['sort_order'],
		];

		DB::query($sql)->parameters($params)->execute();
	}

	public static function logical_delete($id, $year)
	{
		$sql = 'UPDATE '.self::table().' SET'.PHP_EOL;
		$sql .= '	is_active = 0,'.PHP_EOL;
		$sql .= '	updated_at = NOW()'.PHP_EOL;
		$sql .= 'WHERE id = :id'.PHP_EOL;
		$sql .= 'AND year = :year'.PHP_EOL;
		$sql .= 'AND is_active = 1';

		$params = [
			'id' => $id,
			'year' => $year,
		];

		DB::query($sql)
			->parameters($params)
			->execute();
	}
}