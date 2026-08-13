<div class="summary-page">

	<h2>日常生活出費 サマリ</h2>

	<form method="get" class="summary-filter">
		<label for="year">年</label>

		<select name="year" id="year">
			<?php for ($y = date('Y') - 5; $y <= date('Y') + 1; $y++): ?>
				<option value="<?= $y ?>" <?= $year == $y ? 'selected' : '' ?>>
					<?= $y ?>年
				</option>
			<?php endfor; ?>
		</select>

		<button type="submit">表示</button>
	</form>
	<?php

$categories_by_type = [];

foreach ($categories as $category) {
	$categories_by_type[$category['type']][] = $category;
}

?>

<table class="summary-table">

	<thead>

		<tr>
			<th rowspan="2">月</th>

			<?php foreach ($categories_by_type as $type => $type_categories): ?>
				<th colspan="<?= count($type_categories) ?>">
					<?= $type == 1 ? '日常支出' : '固定支出' ?>
				</th>
			<?php endforeach; ?>

			<th rowspan="2">総計</th>
		</tr>

		<tr>
			<?php foreach ($categories_by_type as $type_categories): ?>
				<?php foreach ($type_categories as $category): ?>
					<th>
						<?= e($category['name']) ?>
					</th>
				<?php endforeach; ?>
			<?php endforeach; ?>
		</tr>

	</thead>

	<tbody>

<?php for ($month = 1; $month <= 12; $month++): ?>

	<?php $month_total = 0; ?>

	<tr>

		<th class="month-cell"><?= $month ?>月</th>

		<?php foreach ($categories_by_type as $type_categories): ?>

			<?php foreach ($type_categories as $category): ?>

				<?php
				$amount = $summary[$month][$category['id']] ?? 0;
				$month_total += $amount;
				?>

				<td class="amount-cell <?= $amount == 0 ? 'is-zero' : '' ?>">
					<?= number_format($amount) ?>
				</td>

			<?php endforeach; ?>

		<?php endforeach; ?>

		<td class="amount-cell total-cell <?= $month_total == 0 ? 'is-zero' : '' ?>">
			<?= number_format($month_total) ?>
		</td>

	</tr>

<?php endfor; ?>

<tr class="grand-total">

	<th>総計</th>

	<?php $grand_total = 0; ?>

	<?php foreach ($categories_by_type as $type_categories): ?>

		<?php foreach ($type_categories as $category): ?>

			<?php
			$category_total = 0;

			for ($month = 1; $month <= 12; $month++) {
				$category_total += $summary[$month][$category['id']] ?? 0;
			}

			$grand_total += $category_total;
			?>

			<td class="amount-cell <?= $category_total == 0 ? 'is-zero' : '' ?>">
				<?= number_format($category_total) ?>
			</td>

		<?php endforeach; ?>

	<?php endforeach; ?>

	<td class="amount-cell total-cell">
		<?= number_format($grand_total) ?>
	</td>

</tr>

	</tbody>

</table>

</div>