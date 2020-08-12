<?php 
require_once '../main_function/main_include.php';
$user_id = $_REQUEST['user_id'];

$ban_value = 1;
$ban = $mysqli -> prepare("UPDATE `users` SET `ban` = ? WHERE `id` = ? ");
$ban -> bind_param('ii',$ban_value,$user_id);
$ban -> execute();

header('Location:/list_users');

