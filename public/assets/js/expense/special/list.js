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

	// ========================================
	// 対象年変更
	// ========================================

	$('#year').on('change', function () {

		const year = $(this).val();
		const $category = $('#category_id');

		$category.prop('disabled', true);

		$.ajax({
			url: '/expense/special/categoryajax',
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
					value: 'all',
					text: 'すべて'
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

			$category.val('all');
		})
		.fail(function () {
			alert('カテゴリの取得に失敗しました。');
		})
		.always(function () {
			$category.prop('disabled', false);
		});

	});


	// ========================================
	// 詳細モーダル
	// ========================================

	$('.btn-detail').on('click', function () {

		const id = $(this).data('id');

		$('#detail-modal-body').html(
			'<div class="detail-loading">読み込み中...</div>'
		);

		$('#detail-modal').addClass('is-open');

		$.ajax({
			url: '/expense/special/detailajax/' + id,
			type: 'GET',
			dataType: 'html'
		})
		.done(function (html) {
			$('#detail-modal-body').html(html);
		})
		.fail(function () {
			$('#detail-modal-body').html(
				'<div class="detail-error">詳細情報の取得に失敗しました。</div>'
			);
		});

	});


	// ========================================
	// モーダルを閉じる
	// ========================================

	$('.modal-close, .modal-overlay').on('click', function () {
		$('#detail-modal').removeClass('is-open');
	});


	// ESCでも閉じる
	$(document).on('keydown', function (e) {

		if (e.key === 'Escape') {
			$('#detail-modal').removeClass('is-open');
		}

	});

});