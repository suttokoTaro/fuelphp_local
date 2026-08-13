$(function () {

	let itemIndex = $('#item-rows .item-row').length;


	// ==============================
	// 明細追加
	// ==============================

	$('#add-item').on('click', function () {

		const html = `
			<tr class="item-row">

				<td>
					<input
						type="text"
						name="items[${itemIndex}][item_name]"
						class="item-name"
					>
				</td>

				<td>
					<input
						type="number"
						name="items[${itemIndex}][amount]"
						class="item-amount"
					>
				</td>

				<td class="action-cell">
					<button
						type="button"
						class="btn-remove-item remove-item"
					>
						削除
					</button>
				</td>

			</tr>
		`;

		$('#item-rows').append(html);

		itemIndex++;

	});


	// ==============================
	// 明細削除
	// ==============================

	$(document).on('click', '.remove-item', function () {

		$(this)
			.closest('.item-row')
			.remove();

		calculateItems();

	});


	// ==============================
	// 明細金額変更
	// ==============================

	$(document).on('input', '.item-amount, #amount', function () {

		calculateItems();

	});


	// ==============================
	// 明細集計
	// ==============================

	function calculateItems() {

		let itemsTotal = 0;

		$('.item-amount').each(function () {

			const amount = parseInt($(this).val(), 10) || 0;

			itemsTotal += amount;

		});


		const totalAmount =
			parseInt($('#amount').val(), 10) || 0;


		const unclassified =
			totalAmount - itemsTotal;


		$('#items-total').text(
			itemsTotal.toLocaleString()
		);

		$('#unclassified-amount').text(
			unclassified.toLocaleString()
		);

	}


	calculateItems();

});