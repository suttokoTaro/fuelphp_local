<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<title>Suttoko APP</title>
	<?php echo \Asset::css('common.css'); ?>
</head>

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
	<main class="app-main">
		<?= $content ?>
	</main>

	<?php echo Asset::js('jquery-4.0.0.js'); ?>
	<?php if (!empty($js)): ?>
		<?php foreach ($js as $file): ?>
			<?php echo Asset::js($file); ?>
		<?php endforeach; ?>
	<?php endif; ?>
</body>

</html>