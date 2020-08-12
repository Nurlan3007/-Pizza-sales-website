<?php
// print_e($_REQUEST);
$login = trim($_REQUEST['login']);$password = trim($_REQUEST['password']);

# select users
$select_login = $mysqli -> prepare("SELECT `id`,`password`,`login` FROM `users` WHERE `login` = ? ");
$select_login -> bind_param('s',$login);
$select_login -> execute();
$get_result  = $select_login -> get_result();
$users = $get_result -> fetch_all(MYSQLI_ASSOC)[0];

$hash = $users['password'];
if (!password_verify($password, $hash)) 
    $_SESSION['error']['hash'] = 'Pароль или логи не правильный';

if(count($_SESSION['error']) > 0){
	// $authcotroller = new Authcontroller();
	// $authcotroller -> get_login_page();
	header('Location:/login_get');
	die();
}

if(isset($_POST['checkbox'])){
	$hash_token = md5($password);
	$update_token = $mysqli -> prepare("UPDATE `users` SET `token` = ? WHERE `login` = ?");
	$update_token -> bind_param('ss',$hash_token,$login);
	$update_token -> execute();
	setcookie('password_cookie_token',$hash_token,time() + (1000 * 60 * 60 * 24 * 31),"/");
}else{
	if(isset($_COOKIE['password_cookie_token'])){
		$update_token = $mysqli -> query("UPDATE `users` SET `token` = ' ' WHERE `login` = '$login'");
		setcookie('password_cookie_token',"",time()- 3600,"/");
		
	}
}


$_SESSION['id'] = $users['id'];
header('Location:/');
