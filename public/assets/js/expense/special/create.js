$(function () {

	let currentCategoryYear = null;

	const initialExpenseDate = $('#expense-date').val();

	if (initialExpenseDate) {
		currentCategoryYear = initialExpenseDate.substring(0, 4);
	}

	// ==============================
	// 支出日変更
	// ==============================

	$('#expense-date').on('change', function () {

		const expenseDate = $(this).val();

		if (!expenseDate) {
			clearCategories();
			return;
		}

		const year = expenseDate.substring(0, 4);

		// 同じ年なら取得し直さない
		if (year === currentCategoryYear) {
			return;
		}

		loadCategories(year);

	});


	// ==============================
	// カテゴリ取得
	// ==============================

	function loadCategories(year) {

		const $category = $('#category-id');
		const url = $category.data('url');

		$category
			.prop('disabled', true)
			.empty()
			.append(
				$('<option>', {
					value: '',
					text: '読み込み中...'
				})
			);


		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'json',
			data: {
				year: year
			}
		})
		.done(function (categories) {

			$category.empty();

			$category.append(
				$('<option>', {
					value: '',
					text: '選択してください'
				})
			);


			$.each(categories, function (index, category) {

				$category.append(
					$('<option>', {
						value: category.id,
						text: category.name
					})
				);

			});


			currentCategoryYear = year;

		})
		.fail(function () {

			$category
				.empty()
				.append(
					$('<option>', {
						value: '',
						text: 'カテゴリの取得に失敗しました'
					})
				);

		})
		.always(function () {

			$category.prop('disabled', false);

		});

	}


	// ==============================
	// カテゴリクリア
	// ==============================

	function clearCategories() {

		$('#category-id')
			.empty()
			.append(
				$('<option>', {
					value: '',
					text: '選択してください'
				})
			);

		currentCategoryYear = null;

	}

	// 金額変更時
	$(document).on('input', '.item-amount, #amount', function () {
		calculateTotal();
	});
	// 合計金額の再計算
	function calculateTotal() {
		let itemsTotal = 0;
		$('.item-amount').each(function () {
			itemsTotal += Number($(this).val()) || 0;
		});

		const mainAmount = Number($('#amount').val()) || 0;
		const unclassifiedAmount = mainAmount - itemsTotal;
		$('#items-total').text(
			itemsTotal.toLocaleString()
		);
		$('#unclassified-amount').text(
			unclassifiedAmount.toLocaleString()
		);
	}

});