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
</body>

</html>