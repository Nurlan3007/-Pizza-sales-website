<?php
include_once 'config.php';

// Main functions
function connect_database(){
	$mysqli = new mysqli(DB_HOST,DB_NAME,DB_PASSWORD,DB_SCHEMA);
	return $mysqli;
}

$mysqli = connect_database();

function print_e($arr){
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

// check date order 
function check_date_order($order_id){
	$mysqli = connect_database();
	// delete order_product
	$delete_order_product = $mysqli -> prepare("DELETE FROM `order_product` WHERE `order_id` = ?");
	$delete_order_product -> bind_param('i',$order_id);
	$delete_order_product -> execute();
	// delete orders
	$delete_order = $mysqli -> prepare("DELETE FROM `orders` WHERE `id` = ?");
	$delete_order -> bind_param('i',$order_id);
	$delete_order -> execute();
}


// count descounts
function count_descount($cost,$percent){
	$result = (1 - $percent / 100) * $cost;
	return $result.'тг';
}



// uniqiuens name combo
function uniquens_name_combo($name,$category_id = 1){
	$mysqli = connect_database();
	$uniquens_name_combo = $mysqli -> prepare("SELECT count(*) AS C FROM `menu` WHERE `name_menu` = ? and `category_id` = ?");
	$uniquens_name_combo -> bind_param('si',$name,$category_id);
	$uniquens_name_combo -> execute();
	$result = $uniquens_name_combo -> get_result();
	$uniquens_name_combo = $result -> fetch_all(MYSQLI_ASSOC);
	return $uniquens_name_combo;
}




// Update count products 
function update_count_products($count_products,$name = "pagination"){
	$mysqli = connect_database();
	$update_products = $mysqli -> prepare("UPDATE `options` SET `value` = ? WHERE `name` = ?");
	$update_products -> bind_param('is',$count_products,$name);
	$update_products -> execute();
}


// Обновить курс доллара
function update_usd($course_curr,$name = 'course'){
	$mysqli = connect_database();
	$update_usd = $mysqli -> prepare("UPDATE `options` SET `value` = ? WHERE `name` = ?");
	$update_usd -> bind_param('is',$course_curr,$name);
	$update_usd -> execute();
}

// count products in website
function count_products(){
	$mysqli = connect_database();
	$count_products = $mysqli -> prepare("SELECT count(*) AS count FROM `menu`");
	if($count_products -> execute()){
		$result = $count_products -> get_result();
		$count_products = $result -> fetch_assoc();
		return $count_products['count'];
	}
}


// Получить доллар в рублях
function get_course($curr = "USD"){
	$data = file_get_contents(LINK);
	$course = json_decode($data,true);
	$course_valute = $course['Valute'];
	$course_curr = false;

	foreach ($course_valute as $key => $value) {
		if ($value["CharCode"] == $curr){
			$course_curr = $value['Value'];
			break;
		}
	}
	return $course_curr;
}


// Get from database options
function get_options(){
	$mysqli = connect_database();
	$select_options = $mysqli -> prepare("SELECT * FROM `options`");
	if($select_options -> execute()){
		$result = $select_options -> get_result();
		$select_options = $result -> fetch_all(MYSQLI_ASSOC);
		return $select_options;
	}
}

// перенаправить фотографию






// Check photo
function check_photo($photo){
	$allowed = ['gif', 'png', 'jpg','avg','jfif'];
	$photo = pathinfo($photo,PATHINFO_EXTENSION);
	if(!in_array($photo,$allowed)){
		$_SESSION['error']['photo'] = 'You should choose photo';
	}
}



// Сохраняем пользователя
function token(){
	$mysqli = connect_database();
	if (isset($_COOKIE['password_cookie_token']) && !empty($_COOKIE['password_cookie_token'])){
		$select_token = $mysqli -> prepare("SELECT * from `users` WHERE `token` = ?");
		$select_token -> bind_param('s',$_COOKIE['password_cookie_token']);
		if ($select_token -> execute() ){
			$result = $select_token -> get_result();
			$select_token = $result -> fetch_all(MYSQLI_ASSOC)[0];
			$_SESSION['id'] = $select_token['id'];
			return $_SESSION['id'];
		}
	}
}

// get login
function get_users($user_id){
	$mysqli = connect_database();
	$get_login =  $mysqli -> prepare("SELECT * FROM `users` WHERE `id` = ? ");
	$get_login -> bind_param('i',$user_id);
	$get_login -> execute();
	$result = $get_login -> get_result();
	$get_login = $result -> fetch_assoc();
	return $get_login;
}

// delete temporary users
function delete_temporary_users_and_his_orders($user_id){
	$mysqli = connect_database();
	$select_orders = $mysqli -> prepare('SELECT * FROM `orders`');
	if($select_orders -> execute()){
		$result = $select_orders -> get_result();	
		$select_orders = $result -> fetch_all(MYSQLI_ASSOC);
	}

	foreach ($select_orders as $key => $value) {
		$future_date = new DateTime($value['date']);
		$future_date -> modify('+2 day');
		$future_date = date_format($future_date, 'Y-m-d');
		$future_date = strtotime($future_date);

        $today_date = date('Y-m-d',time());
		$today_date = new DateTime($today_date);
		$today_date -> modify('+0 day');
		$today_date = date_format($today_date, 'Y-m-d');
		$today_date = strtotime($today_date);
		if($today_date > $future_date){
			$order_id = $value['id'];
			$delete_order_product = $mysqli -> prepare("DELETE FROM `order_product` WHERE `order_id` = ?");
			$delete_order_product -> bind_param('i',$order_id);
			$delete_order_product -> execute();

			$delete_orders = $mysqli -> prepare("DELETE FROM `orders` WHERE `id` = ?");
			$delete_orders -> bind_param('i',$order_id);
			$delete_orders -> execute();
			
			$user_id = $value['user_id'];
			$delete_temporary_users = $mysqli -> prepare("DELETE FROM `users` WHERE `id` = ?");
			$delete_temporary_users -> bind_param('i',$value['user_id']);
			$delete_temporary_users -> execute();
			unset($_SESSION['temporary_id']);
		}
	}		
}


// ошибки сессии
function error($key){
	$value = $_SESSION['error'][$key];
    unset($_SESSION['error'][$key]);
    return $value;
}


// Проверка на уникальность емайл и логина
function uniquens($login,$email){
	$arr = [];
	$mysqli = connect_database();
	//login
	$uniquens = $mysqli -> prepare("SELECT count(*) as L FROM `users` WHERE `login` = ?");
	$uniquens -> bind_param('s',$login);
	$uniquens -> execute();
	$result = $uniquens -> get_result();
	$uniquens_login = $result -> fetch_all(MYSQLI_ASSOC);
	// EMAIL
	$uniquens = $mysqli -> prepare("SELECT count(*) as E FROM `users` WHERE `email` = ?");
	$uniquens -> bind_param('s',$email);
	$uniquens -> execute();
	$result = $uniquens -> get_result();
	$uniquens_email = $result -> fetch_all(MYSQLI_ASSOC);
	if($uniquens_email[0]['E'] > 0 || $uniquens_login[0]['L'] > 0){
		$L = $uniquens_login[0]['L'];
	    $E = $uniquens_email[0]['E'];
		$arr[] = ['email' => $E,'login' => $L];
	}
	return $arr;
}

