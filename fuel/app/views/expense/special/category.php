<div class="special-category-page">

	<h2 class="page-title">特別支出 カテゴリ編集</h2>


	<!-- 年フィルタ -->
	<form method="get" class="category-filter">

		<label for="year">年</label>

		<select name="year" id="year">
			<?php for ($y = date('Y') - 5; $y <= date('Y') + 2; $y++): ?>
				<option
					value="<?= $y ?>"
					<?= $year == $y ? 'selected' : '' ?>
				>
					<?= $y ?>年
				</option>
			<?php endfor; ?>
		</select>

		<button type="submit" class="btn-filter">
			表示
		</button>

	</form>


	<!-- カテゴリ編集 -->
	<form method="post" id="category-form">

		<input
			type="hidden"
			name="year"
			value="<?= e($year) ?>"
		>

		<div class="category-header">

			<div class="category-year-title">
				<?= e($year) ?>年のカテゴリ
			</div>

			<button
				type="button"
				id="add-category"
				class="btn-add"
			>
				＋ カテゴリ追加
			</button>

		</div>


		<table class="category-table">

			<thead>
				<tr>
					<th class="col-name">カテゴリ名</th>
					<th class="col-sort">表示順</th>
					<th class="col-action">操作</th>
				</tr>
			</thead>

			<tbody id="category-rows">

				<?php foreach ($categories as $index => $category): ?>

					<tr class="category-row">

						<td>

							<input
								type="hidden"
								name="categories[<?= $index ?>][id]"
								value="<?= e($category['id']) ?>"
							>

							<input
								type="text"
								name="categories[<?= $index ?>][name]"
								value="<?= e($category['name']) ?>"
								class="category-name"
							>

						</td>

						<td>

							<input
								type="number"
								name="categories[<?= $index ?>][sort_order]"
								value="<?= e($category['sort_order']) ?>"
								class="category-sort"
							>

						</td>

						<td class="action-cell">

							<button
								type="button"
								class="btn-delete remove-category"
							>
								削除
							</button>

						</td>

					</tr>

				<?php endforeach; ?>

			</tbody>

		</table>


		<div class="category-footer">

			<button
				type="submit"
				class="btn-save"
			>
				保存
			</button>

		</div>

	</form>

</div>