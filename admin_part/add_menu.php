<?php
// Values
$main_name = trim($_REQUEST['main_name']);
$description = trim($_REQUEST['description']);
$price = trim($_REQUEST['price']);
$descounts = $_REQUEST['descounts'];
$category_id = $_REQUEST['category_id'];

// CHECK
$error = [];
if(strlen($main_name) <= 2)
	$_SESSION['error']['main_name'] = 'Забыли название';


if(!is_numeric($price))
	$_SESSION['error']['price'] = 'Price should be number';


$name_photo = $_FILES['photo']['name'];

// check PHOTO
check_photo($name_photo);

if(count($_SESSION['error']) > 0)
{
	header("Location:/create_menu?category_id=$category_id");
    exit();
}
 
$tmp_name = $_FILES['photo']['tmp_name'];
move_uploaded_file($tmp_name , 'html_css/img/' . $name_photo);

function insert_menu($main_name,$description = "",$image,$category_id,$price,$descounts=0)
{
	global $mysqli;
	$insert_menu = $mysqli -> prepare("
		INSERT INTO `menu`(`name_menu`,`value`,`image`,`category_id`,`price`,`descounts`)
		VALUES(?,?,?,?,?,?)");
	$insert_menu -> bind_param('sssiii',$main_name,$description,$image,$category_id,$price,$descounts);
	$insert_menu -> execute();
}
insert_menu($main_name,$description,$name_photo,$category_id,$price);
header('Location:/');

























































































































































































































































