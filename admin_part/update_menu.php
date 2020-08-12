<?php
$name = trim($_POST['main_name']);
$description = trim($_POST['description']);
$price = trim($_POST['price']);
$descount = trim($_POST['descounts']);
$menu_id = $_REQUEST['menu_id'];

$name_photo = $_FILES['photo']['name'];
$tmp_name = $_FILES['photo']['tmp_name'];
if(strlen($name_photo) != 0){
	check_photo($name_photo);
}else{
	$name_photo = $_POST['old_photo'];
}

if(preg_match('/\d+/',$price,$m) == false)
	$_SESSION['error']['price'] = 'Price error';

if(preg_match('/\d*/',$descount,$m) == false)
	$_SESSION['error']['descount'] = 'Descount error';


if( count($_SESSION['error']) > 0 ){
	header("Location: {$_SERVER['HTTP_REFERER']}");
	die();
}

move_uploaded_file($tmp_name,'../html_css/img/' . $name_photo);

function update_menu($menu_id,$name,$description,$price,$descount,$name_photo){
	global $mysqli;
	$update_menu = $mysqli -> prepare('
		UPDATE `menu` SET `name_menu` = ? , `value` = ? , `image` = ?,`descounts` = ? ,`price` = ? WHERE `id` = ?');
	$update_menu -> bind_param('sssiii',$name,$description,$name_photo,$descount,$price,$menu_id);
	$update_menu -> execute();
}
update_menu($menu_id,$name,$description,$price,$descount,$name_photo);

header('Location:/');
