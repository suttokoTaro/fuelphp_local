<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<title>Suttoko APP</title>
	<?php echo \Asset::css('common.css'); ?>
</head>
<?php

$current_controller = \Request::active()->controller;
$current_action = \Request::active()->action;

$menus = [
	[
		'title' => '家計簿全体',
		'class' => 'all',
		'items' => [
			[
				'label' => '全体サマリ',
				'url' => 'expense/summary',
				'controller' => 'Controller_Expense',
				'action' => 'summary',
			],
			[
				'label' => '共有口座状況',
				'url' => 'expense/account',
				'controller' => 'Controller_Expense',
				'action' => 'account',
			],
			[
				'label' => '立て替え状況',
				'url' => 'expense/advance',
				'controller' => 'Controller_Expense',
				'action' => 'advance',
			],
		],
	],
	[
		'title' => '日常生活出費',
		'class' => 'living',
		'items' => [
			[
				'label' => '新規登録',
				'url' => 'expense/living/create',
				'controller' => 'Controller_Expense_Living_Create',
				'action' => 'index',
			],
			[
				'label' => '一覧',
				'url' => 'expense/living/list',
				'controller' => 'Controller_Expense_Living_List',
				'action' => 'index',
			],
			[
				'label' => 'サマリ',
				'url' => 'expense/living/summary',
				'controller' => 'Controller_Expense_Living_Summary',
				'action' => 'index',
			],
			[
				'label' => '店舗マスタ編集',
				'url' => 'expense/living/store',
				'controller' => 'Controller_Expense_Living',
				'action' => 'store',
			],
		],
	],
	[
		'title' => '特別支出',
		'class' => 'special',
		'items' => [
			[
				'label' => '新規登録',
				'url' => 'expense/special/create',
				'controller' => 'Controller_Expense_Special',
				'action' => 'create',
			],
			[
				'label' => '一覧',
				'url' => 'expense/special/index',
				'controller' => 'Controller_Expense_Special',
				'action' => 'index',
			],
			[
				'label' => 'サマリ',
				'url' => 'expense/special/summary',
				'controller' => 'Controller_Expense_Special',
				'action' => 'summary',
			],
			[
				'label' => 'カテゴリ編集',
				'url' => 'expense/special/category',
				'controller' => 'Controller_Expense_Special',
				'action' => 'category',
			],
		],
	],
];

?>
<body>
	<header class="app-header">
		<div class="header-left">
			<a href="<?= \Uri::create('top') ?>" class="app-title-link">
				<span class="app-title">Suttoko APP</span>
			</a>
		</div>
		<div class="header-right">
		</div>
	</header>

	<div class="app-layout">
		<aside class="app-sidebar">

	<nav class="sidebar-nav">

		<?php foreach ($menus as $menu): ?>

			<div class="nav-section nav-section-<?= $menu['class'] ?>">

				<div class="nav-section-title">
					<?= e($menu['title']) ?>
				</div>

				<ul class="nav-list">

					<?php foreach ($menu['items'] as $item): ?>

						<?php
						$is_active =
							$current_controller === $item['controller']
							&&
							$current_action === $item['action'];
						?>

						<li>
							<a
								href="<?= \Uri::create($item['url']) ?>"
								class="<?= $is_active ? 'active' : '' ?>"
							>
								<?= e($item['label']) ?>
							</a>
						</li>

					<?php endforeach; ?>

				</ul>

			</div>

		<?php endforeach; ?>

	</nav>

</aside>
		<main class="app-main">
			<?= $content ?>
		</main>
	</div>

	<?php echo Asset::js('jquery-4.0.0.js'); ?>
	<?php if (!empty($js)): ?>
		<?php foreach ($js as $file): ?>
			<?php echo Asset::js($file); ?>
		<?php endforeach; ?>
	<?php endif; ?>

</body>

</html>