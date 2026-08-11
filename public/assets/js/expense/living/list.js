$(function () {

	$('.btn-detail').on('click', function () {

		const id = $(this).data('id');

		$.ajax({
			url: '/expense/living/detailajax/' + id,
			type: 'GET',
			dataType: 'html'
		})
		.done(function (html) {

			$('#detail-modal-body').html(html);

			$('#detail-modal').fadeIn(150);
		})
		.fail(function () {

			alert('詳細情報の取得に失敗しました。');
		});
	});


	// ×ボタン
	$('.modal-close').on('click', function () {

		$('#detail-modal').fadeOut(150);
	});


	// 背景クリック
	$('.modal-overlay').on('click', function () {

		$('#detail-modal').fadeOut(150);
	});

});