<div class="special-create-page">
	<h2 class="page-title">特別支出 新規登録</h2>

	<form method="post" id="special-form">
		<div class="special-form-grid">
			<!-- 支出日 -->
			<div class="form-group">
				<label for="expense-date">支出日</label>
				<input type="date" id="expense-date" name="expense_date" value="<?= e(Input::post('expense_date', date('Y-m-d'))) ?>">
			</div>
			<!-- タイトル -->
			<div class="form-group">
				<label for="title">タイトル</label>
				<input type="text" id="title" name="title" value="<?= e(Input::post('title', '')) ?>">
			</div>
			<!-- カテゴリ -->
			<div class="form-group">
				<label for="category-id">カテゴリ</label>
				<select id="category-id" name="category_id">
					<option value="">選択してください</option>
					<?php foreach ($categories as $category): ?>
						<option value="<?= e($category['id']) ?>" <?= Input::post('category_id') == $category['id'] ? 'selected' : '' ?>>
							<?= e($category['name']) ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<!-- 合計金額 -->
			<div class="form-group">
				<label for="amount">合計金額</label>
				<input type="number" id="amount" name="amount" value="<?= e(Input::post('amount', '')) ?>">
			</div>
			<!-- 立替者 -->
			<div class="form-group">
				<label for="paid-by">立替者</label>
				<select id="paid-by" name="paid_by">
					<option value="1">共有口座</option>
					<option value="2">本人</option>
					<option value="3">配偶者</option>
				</select>
			</div>
			<!-- メモ -->
			<div class="form-group form-group-note">
				<label for="note">メモ</label>
				<textarea id="note" name="note"><?= e(Input::post('note', '')) ?></textarea>
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