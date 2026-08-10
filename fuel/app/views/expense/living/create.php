<form method="post">
	<div>
		<label>支出日</label>
		<input type="date" name="expense_date" value="<?php echo date('Y-m-d'); ?>">
	</div>
	<div>
		<label>店舗</label>
		<select name="store_id">
			<?php foreach ($stores as $store): ?>
				<option value="<?php echo $store['id']; ?>"><?php echo e($store['name']); ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div>
		<label>タイトル</label>
		<input type="text" name="title">
	</div>
	<div>
		<label>カテゴリ</label>
		<select name="category_id" id="category-id">
			<?php foreach ($categories as $category): ?>
				<option value="<?php echo $category['id'] ?>"><?php echo e($category['name']) ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div>
		<label>立て替え者</label>
		<select name="paid_by">
			<option value="<?php echo Model_Expenseslivingmain::PAID_BY_SHARED ?>">共有口座</option>
			<option value="<?php echo Model_Expenseslivingmain::PAID_BY_NAOYA ?>">直也</option>
			<option value="<?php echo Model_Expenseslivingmain::PAID_BY_MAYU ?>">まゆ</option>
		</select>
	</div>
	<div>
		<label>金額</label>
		<input type="number" name="amount" id="main-amount" min="0">円
	</div>
	<div>
		<label>メモ</label>
		<textarea name="note"></textarea>
	</div>
	<hr>
	<div id="items-area">
		<h3>明細</h3>
		<div id="items">
			<div class="item-row">
				<input type="text" name="items[0][item_name]" placeholder="品名">
				<select name="items[0][detail_category_id]">
					<option value="">詳細カテゴリ</option>
					<?php foreach ($detail_categories as $detail_category): ?>
						<option value="<?= $detail_category['id'] ?>">
							<?= e($detail_category['name']) ?>
						</option>
					<?php endforeach; ?>
				</select>
				<input type="number" name="items[0][amount]" class="item-amount" min="0" placeholder="金額">
				<button type="button" class="remove-item">削除</button>
			</div>
		</div>
		<button type="button" id="add-item">
			＋ 明細を追加
		</button>
		<div>
			明細合計：
			<span id="items-total">0</span> 円
		</div>
		<div>
			未分類：
			<span id="unclassified-amount">0</span> 円
		</div>
		<hr>
	</div>
	<button type="submit">登録する</button>
</form>
<p><?php echo Session::get_flash('error'); ?></p>