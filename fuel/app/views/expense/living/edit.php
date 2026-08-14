<?php
	$flash_error = \Session::get_flash('error');
	$flash_success = \Session::get_flash('success');
?>

<div class="expense-container">
	<div class="page-header">
		<h3>日常生活出費 編集</h3>
	</div>
	<?php if ($flash_success): ?>
		<div class="message message-success">
			<?= e($flash_success); ?>
		</div>
	<?php endif; ?>
	<?php if ($flash_error): ?>
		<div class="message message-error">
			<?= e($flash_error); ?>
		</div>
	<?php endif; ?>
	<?php if (!empty($errors)): ?>
		<div class="message message-error">
			<div class="message-title">入力内容を確認してください</div>
			<ul>
				<?php foreach ($errors as $error): ?>
					<li><?= e($error); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

	<form method="post" class="expense-form">
		<div class="form-card">
			<div class="form-section-title">基本情報</div>
			<div class="form-grid">
				<div class="form-group">
					<label>支出日</label>
					<input type="date" name="expense_date" value="<?= $expense['expense_date'] ?? date('Y-m-d'); ?>">
				</div>
				<div class="form-group">
					<label>購入先</label>
					<select name="store_id">
						<?php foreach ($stores as $store): ?>
							<option value="<?= $store['id']; ?>" <?= ($expense['store_id'] ?? 0) === $store['id'] ? 'selected' : ''; ?>>
								<?= e($store['name']); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group form-group-full">
					<label>タイトル</label>
					<input type="text" name="title" value="<?= e($expense['title'] ?? ''); ?>">
				</div>
				<div class="form-group">
					<label>カテゴリ</label>
					<select name="category_id" id="category-id">
						<?php foreach ($categories as $category): ?>
							<option value="<?= $category['id']; ?>" <?= ($expense['category_id'] ?? 0) === $category['id'] ? 'selected' : ''; ?>>
								<?= e($category['name']); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label>立て替え者</label>
					<select name="paid_by">
						<?php foreach (Model_Expenseslivingmain::PAID_BY_MAP as $value => $label): ?>
							<option value="<?= $value; ?>" <?= ($expense['paid_by'] ?? '') == $value ? 'selected' : ''; ?>>
								<?= e($label); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label>金額</label>
					<div class="amount-input">
						<input type="number" name="amount" id="main-amount" min="0" placeholder="0" value="<?= e($expense['amount'] ?? ''); ?>">
						<span>円</span>
					</div>
				</div>
				<div class="form-group form-group-full">
					<label>メモ</label>
					<input type="text" name="note" value="<?= e($expense['note'] ?? ''); ?>">
				</div>
				<div class="form-group submit-group">
					<button type="submit" class="button-primary">登録する</button>
				</div>
			</div>
		</div>

		<div class="form-card" id="items-area">
			<div class="section-header">
				<div>
					<div class="form-section-title">明細</div>
				</div>
				<button type="button" id="add-item" class="button-secondary">＋ 明細を追加</button>
			</div>
			<div class="items-layout">
				<!-- 左側 -->
				<div class="items-main">
					<div id="items">
						<?php $row_count = max(10, count($items)); ?>
						<?php for ($i = 0; $i < $row_count; $i++): ?>
							<?php $item = $items[$i] ?? null; ?>
							<div class="item-row">
								<div class="item-name">
									<?php if ($i === 0): ?>
										<label>品名</label>
									<?php endif; ?>
									<input type="text" name="items[<?= $i; ?>][item_name]" placeholder="例：牛乳" class="item-name-js" value="<?= e($item['item_name'] ?? ''); ?>">
								</div>
								<div class="item-category">
									<?php if ($i === 0): ?>
										<label>詳細カテゴリ</label>
									<?php endif; ?>
									<select name="items[<?= $i; ?>][detail_category_id]" class="detail-category">
										<option value="">選択してください</option>
										<?php foreach ($detail_categories as $detail_category): ?>
											<option value="<?= $detail_category['id']; ?>" <?= $item && $item['detail_category_id'] == $detail_category['id'] ? 'selected' : ''; ?>>
												<?= e($detail_category['name']); ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="item-price">
									<?php if ($i === 0): ?>
										<label>金額</label>
									<?php endif; ?>
									<div class="amount-input">
										<input type="number" name="items[<?= $i; ?>][amount]" class="item-amount" min="0" placeholder="0" value="<?= e($item['amount'] ?? ''); ?>">
										<span>円</span>
									</div>
								</div>
								<div class="item-delete">
									<button type="button" class="remove-item">削除</button>
								</div>
							</div>
						<?php endfor; ?>
					</div>
				</div>
				<!-- 右側 -->
				<div class="items-side">
					<div class="summary">
						<div class="summary-row">
							<span>明細合計</span>
							<strong>
								<span id="items-total">0</span>
								<small>円</small>
							</strong>
						</div>
						<div class="summary-row unclassified">
							<span>未分類</span>
							<strong>
								<span id="unclassified-amount">0</span>
								<small>円</small>
							</strong>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>