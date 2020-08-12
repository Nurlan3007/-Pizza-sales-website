<?php
require_once "../main_function/main_include.php";
$menu_id = $_POST['id'];
$user_id = $_SESSION['id'];

if(!isset($_SESSION['id'])){
	if(isset($_SESSION['basket'])){
		$item_id = array_column($_SESSION['basket'],"menu_id");
		if(!in_array($menu_id,$item_id)){
			$count = count($_SESSION['basket']);
			$count++;
			$basket = [
				'menu_id' => $menu_id,
				'user_id' => $user_id,];
			$_SESSION['basket'][$count] = $basket;
			$added_basket = $_SESSION['basket'];
			setcookie('basket',json_encode($added_basket),time() + (1000 * 60 * 60 * 24 * 31),"/");
		}
	}else{
		if(isset($_COOKIE['basket'])){
			$basket = json_decode($_COOKIE['basket'],true);
			for($i = 0; $i <= count($basket);$i++){
				$_SESSION['basket'][$i] = $basket[$i];
			}
		}

		$basket = [
			'menu_id' => $menu_id,
			'user_id' => $user_id,];

		$_SESSION['basket'][0] = $basket; 
	}
}else{
	function check_basket($user_id,$menu_id){
		global $mysqli;
		$check_basket = $mysqli -> prepare("
			SELECT count(*) as C 
			FROM `basket` 
			WHERE `user_id` = ? and `menu_id` = ?");
		$check_basket -> bind_param('ii',$user_id,$menu_id);
		if($check_basket -> execute()){
			$result = $check_basket -> get_result();
			$check_basket = $result -> fetch_assoc();
			return $check_basket;
		}
	}
	$check_basket = check_basket($user_id,$menu_id);
	if($check_basket['C'] > 0){
		$error = 'Уже есть';
		echo $error;
		die();
	}

	function insert_basket($user_id,$menu_id){
		global $mysqli;
		$insert_basket = $mysqli -> prepare("
			INSERT INTO `basket`(`user_id`,`menu_id`) 
			VALUES(?,?)");
		$insert_basket -> bind_param('ii',$user_id,$menu_id);
		$insert_basket -> execute();
	}
	insert_basket($user_id,$menu_id);

	$succes = 'Add in basket';
	echo $succes;
}