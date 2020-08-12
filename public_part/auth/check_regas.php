<?php
$login = trim($_REQUEST['login']);
$email = trim($_REQUEST['email']);
$password = trim($_REQUEST['password']);
$phone = trim($_REQUEST['phone']);

# check_login
$reqular = preg_match('/^[A-Z]{1,}+[a-zA-Z_\d]{4,}/', $login,$m);
if($reqular == false)
	$_SESSION['error']['login'] = 'Логин должен сотоять из Большой буквы и цифр';

# check email
$regular = preg_match('/^[.A-Za-z0-9_-]+@[a-z0-9_-]+\.[a-z]+$/', $email, $m);
if ($regular == false) 
    $_SESSION['error']['email'] = 'Inncorrect email';


# check password sametest
if($password_1 != $password_2)
	$_SESSION['error']['password'] = 'Пароли не совпадают';

# check uniqiens
$arr = uniquens($login,$email);
if ($arr[0]['login'] > 0)
	$_SESSION['error']['login'] = 'Логин уже существует';
elseif ($arr[0]['email'] > 0)
   $_SESSION['error']['login'] = 'Email уже существует';

// 8 705 709 26 40


$phone = str_replace(' ','',$phone);
$r = preg_match('/^8|\+7([0-9]{10})/',$phone,$m);
if($r == false)
	$_SESSION['error']['phone'] = 'Inncorrect phone';


# old value
$_SESSION['old_v']['login'] = $login;$_SESSION['old_v']['email'] = $email;
if(count($_SESSION['error']) > 0){
	header('Location:/register_get');
	die();
}else{
	$role_id = 3;
	$password_hash = password_hash($password, PASSWORD_DEFAULT);
	// insert
	$insert = $mysqli -> prepare("INSERT INTO `users`(`login`,`email`,`phone`,`password`,`role_id`) VALUES(?,?,?,?,?)");
	$insert -> bind_param('ssisi',$login,$email,$phone,$password_hash,$role_id);
	$insert -> execute();
	header('Location:/login_get');
}

