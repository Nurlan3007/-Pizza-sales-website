<?php 
$login = trim($_POST['login']);
$phone = trim($_POST['phone']);
$menu_id = $_REQUEST['menu_id'];
$from = $_REQUEST['from'];

$phone = str_replace(' ','',$phone);
$r = preg_match('/(^8|\+7)([0-9]{10})/',$phone,$m);
if($r == false)
	$_SESSION['error']['phone'] = 'Inncorrect phone';


if(count($_SESSION['error']) > 0){
	if($from == 'basket'){
		header("Location:/create_order_users?from=basket&menu_id=$menu_id");
	}else{
		header("Location:/create_order_users?menu_id=$menu_id");
	}
	die();
}

$role_id  = 3;
$password = 1;
$email    = 1;
$insert = $mysqli -> prepare("INSERT INTO `users`(`login`,`password`,`email`,`phone`,`role_id`) VALUES(?,?,?,?,?)");
$insert -> bind_param('sisii',$login,$password,$email,$phone,$role_id);
$insert -> execute();
$last_id_user = $mysqli -> insert_id;
$_SESSION['temporary_id'] = $last_id_user;


header("Location:/create_order_users?last_id=$last_id_user&from=$from&menu_id=$menu_id");



