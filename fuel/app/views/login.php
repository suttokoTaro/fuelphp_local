<head>
	<meta charset="utf-8">
	<?php echo Asset::css('login.css'); ?>
</head>

<div class="login-container">
	<h4 class="title">ログイン画面</h4>

	<form action="" method="post">
		<div class="form-group">
			<input type="text" name="username" placeholder="Username" class="form">
			<input type="password" name="password" placeholder="Password" class="form">
		</div>
		<div class="message-group">
			<?php if (!empty($message)): ?>
				<p><?= e($message) ?></p>
			<?php endif; ?>
			<?php if (!empty($error_message)): ?>
				<p class="msg-error"><?= e($error_message) ?></p>
			<?php endif; ?>
		</div>

		<div class="button-group">
			<input name="login" type="submit" value="ログイン" class="button btn-login">
			<input name="signup" type="submit" value="新規登録" class="button btn-signup">
		</div>
	</form>
</div>

<?php
if (!empty($users)) {
	Debug::dump($users);
}
?>