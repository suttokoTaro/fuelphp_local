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
			<a href="<?= \Uri::create('menu') ?>" class="app-title-link">
				<span class="app-title">Suttoko APP</span>
			</a>
		</div>
		<div class="header-right">
			<?php if (\Auth::check()): ?>
				<div class="login-info">ログイン中：
					<span class="username"><?= e(\Auth::get_screen_name()) ?></span>
				</div>
				<form action="logout" method="POST">
					<ipnut type="submit" value="Logout" class="logout">
				</form>
			<?php endif; ?>
		</div>
	</header>
	<main class="app-main">
		<?= $content ?>
	</main>
</body>

</html>