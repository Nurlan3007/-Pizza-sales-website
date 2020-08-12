<?php 
$user_id = $_SESSION['id'];
$menu_id = $_GET['menu_id'];

if(isset($_SESSION['id'])){
	$remove_from_basket = $mysqli -> prepare("DELETE FROM `basket` WHERE `menu_id` = ? and `user_id` = ? ");
	$remove_from_basket -> bind_param('ii',$menu_id,$user_id);
	$remove_from_basket -> execute();
}else{
	if(isset($_COOKIE['basket']))
		$basket = json_decode($_COOKIE['basket'],true);
	else
		$basket = $_SESSION['basket'];
	
	foreach ($basket  as $key => $value) {
		if($value['menu_id'] == $menu_id){
			unset($_SESSION['basket'][$key]);
			$added_basket = $_SESSION['basket'];
			setcookie('basket',json_encode($added_basket),time() + (1000 * 60 * 60 * 24 * 31),"/");
		}
	}
}


header('Location:/see_basket');


