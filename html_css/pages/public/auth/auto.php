<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="/html_css/css/auth.css">
</head>
<body>
	<form action="/login_post" method="post" class="form" autocomplete="off">
		<h1 class="form_title">Вход</h1>
		<div class="form_group">
			<input type="text" class="form_input" placeholder="Login" name="login">
			<img src="../../../../html_css/img/iconfinder_Rounded-31_2024644.png" class="icons">
		</div>
		<div class="form_group">
			<input type="password" class="form_input" placeholder="Password" name="password">
			<img src="../../../../html_css/img/icons8-password-24.png" class="icons">
		</div>
		<div class="form_group checkbox">
			<input type="checkbox" id="cb3" name="checkbox"> <label for="cb3">Запомнить меня</label>
		</div>
		<button class="form_button">Войти</button>
		<a href="/register_get">Регистрация</a>
		<div class="error">
			<?=error('login')?><br>
			<?=error('hash')?><br>
		</div>
	</form>
	
</body>
</html>