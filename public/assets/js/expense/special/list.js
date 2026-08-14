$(function () {

	$('#year').on('change', function () {

		const year = $(this).val();
		const $category = $('#category_id');

		$category.prop('disabled', true);

		$.ajax({
			url: '/expense/special/category/get-by-year',
			type: 'GET',
			dataType: 'json',
			data: {
				year: year
			}
		})
		.done(function (categories) {

			$category.empty();

			// 「すべて」を先頭に追加
			$category.append(
				$('<option>', {
					value: 'all',
					text: 'すべて'
				})
			);

			// 対象年のカテゴリを追加
			$.each(categories, function (index, category) {
				$category.append(
					$('<option>', {
						value: category.id,
						text: category.name
					})
				);
			});

			// 年を変更したのでカテゴリは「すべて」に戻す
			$category.val('all');
		})
		.fail(function () {
			alert('カテゴリの取得に失敗しました。');
		})
		.always(function () {
			$category.prop('disabled', false);
		});

	});

});