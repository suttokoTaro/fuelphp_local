<h2 class="page-title special-page-title">特別支出 一覧</h2>

<form method="get" action="">
	<div class="special-filter-area">

		<div class="filter-item">
			<label for="year">対象年</label>
			<select name="year" id="year">
				<?php for ($y = date('Y'); $y >= 2020; $y--): ?>
					<option value="<?= $y ?>" <?= (int) $year === $y ? 'selected' : '' ?>>
						<?= $y ?>年
					</option>
				<?php endfor; ?>
			</select>
		</div>

		<div class="filter-item">
			<label for="category_id">カテゴリ</label>
			<select name="category_id" id="category_id">
				<option value="all">すべて</option>

				<?php foreach ($categories as $category): ?>
					<option
						value="<?= e($category['id']) ?>"
						<?= (string) $category_id === (string) $category['id'] ? 'selected' : '' ?>
					>
						<?= e($category['name']) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="filter-item">
			<label for="paid_by">立て替え者</label>
			<select name="paid_by" id="paid_by">
				<option value="all" <?= $paid_by === 'all' ? 'selected' : '' ?>>すべて</option>
				<option value="1" <?= (string) $paid_by === '1' ? 'selected' : '' ?>>共有口座</option>
				<option value="2" <?= (string) $paid_by === '2' ? 'selected' : '' ?>>直也</option>
				<option value="3" <?= (string) $paid_by === '3' ? 'selected' : '' ?>>まゆ</option>
			</select>
		</div>

		<button type="submit" class="btn-search">
			検索
		</button>

		<div class="filter-total">
			<span class="filter-total-label">合計金額</span>
			<span class="filter-total-amount">
				¥<?= number_format($total_amount) ?>
			</span>
		</div>

	</div>
</form>


<div class="special-list-wrapper">

	<table class="special-expense-list">
		<thead>
			<tr>
				<th>No.</th>
				<th>支出日</th>
				<th>タイトル</th>
				<th>金額</th>
				<th>カテゴリ</th>
				<th>立て替え者</th>
				<th>操作</th>
			</tr>
		</thead>

		<tbody>
			<?php if (!empty($expenses)): ?>

				<?php foreach ($expenses as $expense): ?>
					<tr>
						<td class="number">
							<?= e($expense['number']) ?>
						</td>

						<td>
							<?= e(date('Y/m/d', strtotime($expense['expense_date']))) ?>
						</td>

						<td class="title">
							<?= e($expense['title']) ?>
						</td>

						<td class="amount">
							¥<?= number_format($expense['amount']) ?>
						</td>

						<td>
							<span class="category-badge">
								<?= e($expense['category_name']) ?>
							</span>
						</td>

						<td>
							<?= Model_Expensesspecialmain::PAID_BY_MAP[$expense['paid_by']] ?>
						</td>

						<td class="operation">
							<a
								href="<?= Uri::create('expense/special/edit/'.$expense['id']) ?>"
								class="btn-edit"
							>
								編集
							</a>

							<button
								type="button"
								class="btn-detail"
								data-id="<?= $expense['id'] ?>"
							>
								詳細
							</button>
						</td>
					</tr>
				<?php endforeach; ?>

			<?php else: ?>

				<tr>
					<td colspan="7" class="empty">
						該当するデータはありません
					</td>
				</tr>

			<?php endif; ?>
		</tbody>
	</table>

</div>


<div id="detail-modal" class="modal">
	<div class="modal-overlay"></div>

	<div class="modal-content">

		<div class="modal-header">
			<h2>特別支出 詳細</h2>

			<button type="button" class="modal-close">
				×
			</button>
		</div>

		<div id="detail-modal-body">
			<!-- Ajaxで取得 -->
		</div>

	</div>
</div>