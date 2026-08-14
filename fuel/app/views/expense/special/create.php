<?php
	$flash_error = \Session::get_flash('error');
	$flash_success = \Session::get_flash('success');
?>
<div class="special-create-page">
	<h3 class="page-title">特別支出 新規登録</h3>
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

	<form method="post" id="special-form">
		<div class="special-form-grid">
			<div class="form-group">
				<label for="expense-date">支出日</label>
				<input type="date" id="expense-date" name="expense_date" value="<?= $form['expense_date'] ?? date('Y-m-d'); ?>">
			</div>
			<div class="form-group">
				<label for="title">タイトル</label>
				<input type="text" id="title" name="title" value="<?= e($form['title'] ?? ''); ?>">
			</div>
			<div class="form-group">
				<label for="category-id">カテゴリ</label>
				<select id="category-id" name="category_id" data-url="<?= \Uri::create('expense/special/category/get-by-year') ?>">
					<?php foreach ($categories as $category): ?>
						<option value="<?= e($category['id']); ?>" <?= ($form['category_id'] ?? 0) == $category['id'] ? 'selected' : ''; ?>>
							<?= e($category['name']); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="amount">合計金額</label>
				<input type="number" id="amount" name="amount" value="<?= e($form['amount'] ?? ''); ?>">
			</div>
			<div class="form-group">
				<label for="paid-by">立替者</label>
				<select id="paid-by" name="paid_by">
					<?php foreach (Model_Expenseslivingmain::PAID_BY_MAP as $value => $label): ?>
						<option value="<?= $value; ?>" <?= ($form['paid_by'] ?? '') == $value ? 'selected' : ''; ?>>
							<?= e($label); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group form-group-note">
				<label for="note">メモ</label>
				<input type="text" id="note" name="note" value="<?= e($form['note'] ?? ''); ?>">
			</div>
		</div>
		<div class="items-section">
			<div class="items-header">
				<div class="items-title">明細</div>
				<button type="button" id="add-item" class="btn-add-item">＋ 明細追加</button>
			</div>
			<table class="items-table">
				<thead>
					<tr>
						<th>品名</th>
						<th class="amount-column">金額</th>
						<th class="action-column">操作</th>
					</tr>
				</thead>
				<tbody id="item-rows">
					<?php for ($i = 0; $i < 10; $i++): ?>
						<tr class="item-row">
							<td>
								<input type="text" name="items[<?= $i ?>][item_name]" class="item-name">
							</td>
							<td>
								<input type="number" name="items[<?= $i ?>][amount]" class="item-amount">
							</td>
							<td class="action-cell">
								<button type="button" class="btn-remove-item remove-item">
									削除
								</button>
							</td>
						</tr>
					<?php endfor; ?>
				</tbody>
			</table>
			<div class="items-footer">
				<div class="items-summary">
					<div>
						明細合計：
						<span id="items-total">0</span> 円
					</div>
					<div>
						未分類：
						<span id="unclassified-amount">0</span> 円
					</div>
				</div>
				<button type="submit" class="btn-register">
					登録
				</button>
			</div>
		</div>
	</form>
</div>