$(function () {

	let itemIndex = 10;

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


	// カテゴリ変更
	$('#category-id').on('change', function () {
		if ($(this).val() === '1') {
			$('#items-area').show();
		} else {
			$('#items-area').hide();
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