<?php  
$from = $_REQUEST['from'];
$login      = $_REQUEST['login'];
$user_id    = $_REQUEST['user_id'];
$menu_id    = $_REQUEST['menu_id'];
$street     = trim($_REQUEST['street']);
$house      = trim($_REQUEST['house']);
$addres     = trim($_REQUEST['Addres']);
$apartment  = trim($_REQUEST['apartment']);
$floor      = trim($_REQUEST['floor']);
$menu_count = trim($_REQUEST['count']);
// print_e($_POST);
if(strlen($menu_id) == 0){
	if(!isset($_SESSION['id'])){
		$basket = json_decode($_COOKIE['basket'],true);
		$item_id = array_column($basket,'menu_id');
	}else{
		$sql = "SELECT `menu_id` FROM `basket` WHERE `user_id` = ?";
		$select_menuid = $mysqli -> prepare($sql);
		$select_menuid -> bind_param('i',$_SESSION['id']);
		$select_menuid -> execute();
		$result = $select_menuid -> get_result();
		$select_menu_id = $result -> fetch_all(MYSQLI_ASSOC);
	}	
}

// print_e($_POST);

# CHEKC INFO
$r = preg_match('/^[0-9]+\/+[0-9]+/',$house,$m);
if($r == false)
	$_SESSION['error']['house'] = 'House error';
	

$r = preg_match('/\d+/',$floor,$m);
if($r == false)
	$_SESSION['error']['floor'] = 'floor error';



$r = preg_match('/\d+/',$menu_count,$m);
if($r == false)
	$_SESSION['error']['menu_count'] = 'Menu count should be number';

// unset($_SESSION['error']['menu_count']);


if(count($_SESSION['error']) > 0){
	header("Location:/create_order_users?last_id=$user_id&from=$from&menu_id=$menu_id");
    die;
}

$sql = "INSERT INTO `orders`(`street`,`house`,`apartment`,`user_id`) VALUES(?,?,?,?)";
$insert_order = $mysqli -> prepare($sql);
$insert_order -> bind_param('ssii',$street,$house,$apartment,$user_id);
$insert_order -> execute();

$last_id = $mysqli -> insert_id;

$combo_id = 26;
$sql = "INSERT INTO `order_product`(`order_id`,`menu_id`,`combo_id`,`menu_count`) VALUES(?,?,?,?)";
$insert_order_product = $mysqli -> prepare($sql);
if(isset($_SESSION['id'])){
	if($from != 'basket'){
		$insert_order_product -> bind_param('iiii',$last_id,$menu_id,$combo_id,$menu_count);
		$insert_order_product -> execute();
	}else{
		foreach ($select_menu_id as $key => $value) {
			$insert_order_product -> bind_param('iiii',$last_id,$value['menu_id'],$combo_id,$menu_count);
			$insert_order_product -> execute();
		}
	}	
}else{
	if($from != 'basket'){
		$insert_order_product -> bind_param('iiii',$last_id,$menu_id,$combo_id,$menu_count);
		$insert_order_product -> execute();
	}else{
		foreach ($item_id as $key => $value) {
			$insert_order_product -> bind_param('iiii',$last_id,$value,$combo_id,$menu_count);
			$insert_order_product -> execute();
		}
	}	
	
}


header('Location:/see_my_orders');

