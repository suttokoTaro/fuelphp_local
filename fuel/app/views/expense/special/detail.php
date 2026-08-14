<div class="special-detail">

	<div class="detail-info-grid">

		<div class="detail-field">
			<span class="detail-label">No.</span>
			<span class="detail-value">
				<?= e($expense['number']) ?>
			</span>
		</div>

		<div class="detail-field">
			<span class="detail-label">支出日</span>
			<span class="detail-value">
				<?= e(date('Y/m/d', strtotime($expense['expense_date']))) ?>
			</span>
		</div>

		<div class="detail-field detail-title">
			<span class="detail-label">タイトル</span>
			<span class="detail-value">
				<?= e($expense['title']) ?>
			</span>
		</div>

		<div class="detail-field">
			<span class="detail-label">カテゴリ</span>
			<span class="detail-value">
				<span class="detail-category-badge">
					<?= e($expense['category_name']) ?>
				</span>
			</span>
		</div>

		<div class="detail-field">
			<span class="detail-label">立て替え者</span>
			<span class="detail-value">
				<?= e(Model_Expensesspecialmain::PAID_BY_MAP[$expense['paid_by']] ?? '') ?>
			</span>
		</div>

		<div class="detail-field">
			<span class="detail-label">合計金額</span>
			<span class="detail-value detail-total-amount">
				¥<?= number_format($expense['amount']) ?>
			</span>
		</div>

	</div>


	<?php if (!empty($expense['note'])): ?>

		<div class="detail-note">
			<span class="detail-label">メモ</span>

			<div class="detail-note-text">
				<?= nl2br(e($expense['note'])) ?>
			</div>
		</div>

	<?php endif; ?>


	<div class="detail-items">

		<div class="detail-section-title">
			明細
		</div>

		<table class="detail-items-table">
			<thead>
				<tr>
					<th>品名</th>
					<th>金額</th>
				</tr>
			</thead>

			<tbody>
				<?php if (!empty($items)): ?>

					<?php foreach ($items as $item): ?>
						<tr>
							<td>
								<?= e($item['item_name']) ?>
							</td>

							<td class="amount">
								¥<?= number_format($item['amount']) ?>
							</td>
						</tr>
					<?php endforeach; ?>

				<?php else: ?>

					<tr>
						<td colspan="2" class="empty">
							明細はありません
						</td>
					</tr>

				<?php endif; ?>
			</tbody>
		</table>

	</div>

</div>