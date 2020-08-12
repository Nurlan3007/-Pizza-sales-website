<?php

$user_id = $_SESSION['id'];

function exit_users($user_id){
	global $mysqli;
	if (isset($_COOKIE['password_cookie_token']) && !empty($_COOKIE['password_cookie_token']) ){
		$token = 1;
		$update_token = $mysqli -> prepare("UPDATE `users` SET `token` = ? WHERE `id` = ? ");
		$update_token -> bind_param('is',$token,$user_id);
		$update_token -> execute();
	}
	unset($_SESSION['id']); 
}
exit_users($user_id);
header('Location:/');
