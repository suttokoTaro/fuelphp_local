$(function () {

	let categoryIndex = $('#category-rows .category-row').length;


	// カテゴリ追加
	$('#add-category').on('click', function () {

		const html = `
			<tr class="category-row">

				<td>

					<input
						type="hidden"
						name="categories[${categoryIndex}][id]"
						value=""
					>

					<input
						type="text"
						name="categories[${categoryIndex}][name]"
						value=""
						class="category-name"
					>

				</td>

				<td>

					<input
						type="number"
						name="categories[${categoryIndex}][sort_order]"
						value="${(categoryIndex + 1) * 10}"
						class="category-sort"
					>

				</td>

				<td class="action-cell">

					<button
						type="button"
						class="btn-delete remove-category"
					>
						削除
					</button>

				</td>

			</tr>
		`;

		$('#category-rows').append(html);

		categoryIndex++;

	});


	// カテゴリ削除
	$(document).on('click', '.remove-category', function () {

		$(this)
			.closest('.category-row')
			.remove();

	});

});