
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="/html_css/css/auth.css">
</head>
<body>
	<div class="wrong"></div>
	<form action="/register_post" method="post" class="form" autocomplete="off">
		<h1 class="form_title">Регистрация</h1>
		<div class="form_group">
			<input type="text" class="form_input" placeholder="Login" name="login" >
			<img src="../../../../html_css/img/iconfinder_Rounded-31_2024644.png" class="icons">
		</div>
		<div class="form_group">
			<input type="text" class="form_input" placeholder="Email" name="email" >
			<img src="../../../../html_css/img/iconfinder_42-Email_2123873.png" class="icons">
		</div>
		<div class="form_group">
			<input type="phone" class="form_input" placeholder="Phone" name="phone" >
			<img src="../../../../html_css/img/iconfinder_phone1_172517.png" class="icons">
		</div>
		<div class="form_group password_form">
		    <input type="password" id="password" class="form_input" placeholder="Password" name="password" >
			<img src="../../../../html_css/img/iconfinder_misc-_eye_vision_1276868.png" class="show-password icons">
		</div>
		<button class="form_button" type="submit">Отправить</button>
		<a href="/login_get">Вход</a>

		<div class="error">
			 <?=error('login');?><br>
			 <?=error('email');?><br>
			 <?=error('phone')?>
		</div>
	</form>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			let pass = $('#password');
			$('.show-password').click(function() {
				  pass.attr('type', pass.attr('type') === 'password' ? 'text' : 'password');
			});
		});
	</script>

	
</body>
</html>