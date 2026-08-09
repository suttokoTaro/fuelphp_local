<h1>日常生活費入力</h1>

<?php if ($success = Session::get_flash('success')): ?>
	<p>
		<?= e($success) ?>
	</p>
<?php endif; ?>

<?php if (!empty($errors)): ?>
	<ul>
		<?php foreach ($errors as $error): ?>
			<li>
				<?= e($error->get_message()) ?>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>


<?= Form::open([
	'action' => 'expense/living/create',
	'method' => 'post',
]) ?>


<div>
	<?= Form::label('支出日', 'expense_date') ?>

	<?= Form::input(
		'expense_date',
		Input::post('expense_date', date('Y-m-d')),
		[
			'type' => 'date',
			'id' => 'expense_date',
		]
	) ?>
</div>


<div>
	<?= Form::label('お店', 'store_id') ?>

	<?= Form::select(
		'store_id',
		Input::post('store_id'),
		[
			'' => '選択してください',
			1 => 'スーパー',
			2 => 'コンビニ',
			3 => 'ドラッグストア',
			4 => 'Amazon',
			5 => 'その他',
		],
		[
			'id' => 'store_id',
		]
	) ?>
</div>


<div>
	<?= Form::label('タイトル', 'title') ?>

	<?= Form::input(
		'title',
		Input::post('title'),
		[
			'id' => 'title',
			'maxlength' => 255,
		]
	) ?>
</div>


<div>
	<?= Form::label('金額', 'amount') ?>

	<?= Form::input(
		'amount',
		Input::post('amount'),
		[
			'type' => 'number',
			'id' => 'amount',
			'min' => 0,
		]
	) ?>

	円
</div>


<div>
	<?= Form::label('カテゴリ', 'category_id') ?>

	<?= Form::select(
		'category_id',
		Input::post('category_id'),
		[
			'' => '選択してください',
			1 => '食費',
			2 => '日用品',
			3 => '外食',
			4 => '光熱費',
			5 => 'その他',
		],
		[
			'id' => 'category_id',
		]
	) ?>
</div>


<div>
	<?= Form::label('支払元', 'paid_by') ?>

	<?= Form::select(
		'paid_by',
		Input::post('paid_by'),
		[
			'' => '選択してください',
			'self' => '自分',
			'wife' => '妻',
			'shared' => '共有口座',
		],
		[
			'id' => 'paid_by',
		]
	) ?>
</div>


<div>
	<?= Form::label('メモ', 'note') ?>

	<?= Form::textarea(
		'note',
		Input::post('note'),
		[
			'id' => 'note',
			'rows' => 5,
		]
	) ?>
</div>


<div>
	<?= Form::submit('submit', '登録') ?>
</div>


<?= Form::close() ?>