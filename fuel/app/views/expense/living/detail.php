<div class="detail-main">

	<div class="detail-field">
		<div class="detail-label">支出日</div>
		<div class="detail-value">
			<?= e(date('Y/m/d', strtotime($expense['expense_date']))) ?>
		</div>
	</div>

	<div class="detail-field">
		<div class="detail-label">購入先</div>
		<div class="detail-value">
			<?= e($expense['store_name']) ?>
		</div>
	</div>

	<div class="detail-field">
		<div class="detail-label">カテゴリ</div>
		<div class="detail-value">
			<?= e($expense['category_name']) ?>
		</div>
	</div>

	<div class="detail-field">
		<div class="detail-label">タイトル</div>
		<div class="detail-value">
			<?= e($expense['title']) ?>
		</div>
	</div>

	<div class="detail-field">
		<div class="detail-label">金額</div>
		<div class="detail-value detail-amount">
			¥<?= number_format($expense['amount']) ?>
		</div>
	</div>

	<div class="detail-field">
		<div class="detail-label">立て替え者</div>
		<div class="detail-value">
			<?= Model_Expenseslivingmain::PAID_BY_MAP[$expense['paid_by']] ?>
		</div>
	</div>

	<div class="detail-field">
		<div class="detail-label">メモ</div>
		<div class="detail-value detail-note">
			<?= nl2br(e($expense['note'])) ?>
		</div>
	</div>

</div>


<?php if (!empty($items)): ?>

	<div class="detail-items-area">

		<div class="detail-section-title">
			明細
		</div>

		<table class="detail-items">
			<thead>
				<tr>
					<th>品名</th>
					<th>詳細カテゴリ</th>
					<th>金額</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($items as $item): ?>
					<tr>
						<td>
							<?= e($item['item_name']) ?>
						</td>

						<td>
							<?= e($item['detail_category_name']) ?>
						</td>

						<td class="amount">
							¥<?= number_format($item['amount']) ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

	</div>

<?php endif; ?>