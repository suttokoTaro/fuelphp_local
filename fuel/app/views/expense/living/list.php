<h2 class="page-title">生活費一覧</h2>

<form method="get" action="">
	<div class="filter-area">
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
			<label for="paid_by">立て替え者</label>
			<select name="paid_by" id="paid_by">
				<option value="all" <?= $paid_by === 'all' ? 'selected' : '' ?>>すべて</option>
				<option value="1" <?= (string) $paid_by === '1' ? 'selected' : '' ?>>共有口座</option>
				<option value="2" <?= (string) $paid_by === '2' ? 'selected' : '' ?>>直也</option>
				<option value="3" <?= (string) $paid_by === '3' ? 'selected' : '' ?>>まゆ</option>
			</select>
		</div>
		<button type="submit">検索</button>
		<div class="filter-total">
			<span class="filter-total-label">合計金額</span>
			<span class="filter-total-amount">
				¥<?= number_format($total_amount) ?>
			</span>
		</div>
	</div>
</form>

<table class="expense-list">
	<thead>
		<tr>
			<th>No.</th>
			<th>支出日</th>
			<th>購入先</th>
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
					<td><?= e($expense['number']) ?></td>
					<td><?= e(date('Y/m/d', strtotime($expense['expense_date']))) ?></td>
					<td><?= e($expense['store_name']) ?></td>
					<td><?= e($expense['title']) ?></td>
					<td class="amount">¥<?= number_format($expense['amount']) ?></td>
					<td><?= e($expense['category_name']) ?></td>
					<td><?= Model_Expenseslivingmain::PAID_BY_MAP[$expense['paid_by']] ?></td>
					<td class="operation">
						<a href="<?= Uri::create('expense/living/edit/'.$expense['id']) ?>" class="btn-edit">編集</a>
						<button type="button" class="btn-detail" data-id="<?= $expense['id'] ?>">
							詳細
						</button>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td colspan="8" class="empty">
					該当するデータはありません
				</td>
			</tr>
		<?php endif; ?>
	</tbody>
</table>

<div id="detail-modal" class="modal">
	<div class="modal-overlay"></div>
	<div class="modal-content">
		<div class="modal-header">
			<h2>支出詳細 #<?= e($expense['number']) ?></h2>
			<button type="button" class="modal-close">×</button>
		</div>
		<div id="detail-modal-body">
			<!-- Ajaxで取得した内容をここに表示 -->
		</div>
	</div>
</div>