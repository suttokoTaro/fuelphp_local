$(function () {

	let itemIndex = 20;

	// 明細追加
	$('#add-item').on('click', function () {

		const $row = $('#items .item-row:first').clone();

		// 入力値をリセット
		$row.find('input').val('');
		$row.find('select').val('');

		 // 追加行ではlabel不要
		$row.find('label').remove();

		// nameのindexを変更
		$row.find('[name]').each(function () {
			const name = $(this).attr('name');

			$(this).attr(
				'name',
				name.replace(/items\[\d+\]/, `items[${itemIndex}]`)
			);
		});

		$('#items').append($row);

		itemIndex++;
	});


	// 明細削除
	$(document).on('click', '.remove-item', function () {
		$(this).closest('.item-row').remove();
		calculateTotal();
	});


	// 金額変更
	$(document).on('input', '.item-amount, #main-amount', function () {
		calculateTotal();
	});

	// タブ遷移
	$(document).on('keydown', '.item-name-js, .item-amount', function (e) {

		if (e.key !== 'Tab' && e.key !== 'Enter') {
			return;
		}

		const className = $(this).hasClass('item-name-js')
			? '.item-name-js'
			: '.item-amount';

		const $inputs = $(className);
		const index = $inputs.index(this);

		const nextIndex = e.shiftKey
			? index - 1
			: index + 1;

		// Enterの場合は必ずsubmitを防止
		if (e.key === 'Enter') {
			e.preventDefault();
		}

		if (nextIndex >= 0 && nextIndex < $inputs.length) {

			// Tabの通常動作も防止
			e.preventDefault();

			$inputs.eq(nextIndex).focus();
		}
	});

	$('.expense-form').on('keydown', function (e) {
		if (e.key === 'Enter') {
			e.preventDefault();
		}
	});

	// カテゴリ変更
	$('#category-id').on('change', function () {
		const categoryId = $(this).val();
		const $itemsArea = $('#items-area');
		const $detailCategories = $itemsArea.find('select[name$="[detail_category_id]"]');

		if (categoryId === '1') {
			// 食費：明細表示、詳細カテゴリ選択可能
			$itemsArea.show();
			$detailCategories.prop('disabled', false);

		} else if (categoryId === '2' || categoryId === '9') {
			// 日用品：明細表示、詳細カテゴリ選択不可
			$itemsArea.show();

			// 選択済みの値があればクリア
			$detailCategories.val('');
			$detailCategories.prop('disabled', true);

		} else {
			// その他：明細非表示
			$itemsArea.hide();

			// 詳細カテゴリをクリア
			$detailCategories.val('');
			$detailCategories.prop('disabled', true);
		}
	});


	function calculateTotal() {

		let itemsTotal = 0;

		$('.item-amount').each(function () {
			itemsTotal += Number($(this).val()) || 0;
		});

		const mainAmount = Number($('#main-amount').val()) || 0;

		const unclassifiedAmount = mainAmount - itemsTotal;

		$('#items-total').text(
			itemsTotal.toLocaleString()
		);

		$('#unclassified-amount').text(
			unclassifiedAmount.toLocaleString()
		);
	}

});