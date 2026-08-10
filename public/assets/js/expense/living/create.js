$(function () {

	let itemIndex = 1;

	$('#add-item').on('click', function () {
		const html = `
			<div class="item-row">
				<input
					type="text"
					name="items[${itemIndex}][item_name]"
					placeholder="品名"
				>
				<select name="items[${itemIndex}][detail_category_id]">
					<option value="">詳細カテゴリ</option>
					<?php foreach ($detail_categories as $detail_category): ?>
						<option value="<?= $detail_category['id'] ?>">
							<?= e($detail_category['name']) ?>
						</option>
					<?php endforeach; ?>
				</select>
				<input
					type="number"
					name="items[${itemIndex}][amount]"
					class="item-amount"
					min="0"
					placeholder="金額"
				>
				<button type="button" class="remove-item">
					削除
				</button>
			</div>
		`;
		$('#items').append(html);
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
		$('#items-total').text(itemsTotal.toLocaleString());
		$('#unclassified-amount').text(
			unclassifiedAmount.toLocaleString()
		);
	}
});