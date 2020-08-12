<?php 
$category_id = $_REQUEST['category'];

$name_combo  = trim($_REQUEST['name_combo']);
$description = trim($_REQUEST['description']);
$price       = trim($_REQUEST['price']);
$descounts   = trim($_REQUEST['descounts']);




	
$pizza       = $_REQUEST['pizza'];
$drinks      = $_REQUEST['drinks'];
$desert      = $_REQUEST['desert'];
$snakcs      = $_REQUEST['snakcs'];

# check name

$uniquens_name_combo = uniquens_name_combo($name_combo);
if($uniquens_name_combo[0]['C'] > 0)
	$_SESSION['error']['name_combo'] = 'Комбо уже существует';
elseif (strlen($name_combo) < 1) 
	$_SESSION['error']['name_combo'] = 'Имя комбо должен быть больше чем один символ';	

# check price
if(strlen($price) == 0){
	$_SESSION['error']['price'] = 'Price error';	
}


// if(strlen($description) > 700)
// 	$description = substr_replace($description,'!@#',800,0);



$name_photo = $_FILES['photo']['name'];
$tmp_name = $_FILES['photo']['tmp_name'];
check_photo($name_photo);

if(count($_SESSION['error']) > 0){
	header("Location:/create_combo?category_id=$category_id");
	die();
}

move_uploaded_file($tmp_name , 'html_css/img/'.$name_photo );


# INSERT IN DATABASE

# name_combo

function insert_combo($name_combo,$text,$price,$descount,$image,$category_id){
	global $mysqli;
	$insert_combo = $mysqli -> prepare("INSERT INTO `menu`(`name_menu`,`category_id`,`value`,`price`,`descounts`,`image`) 
		VALUES(?,?,?,?,?,?)");
	$insert_combo -> bind_param('sisiis',$name_combo,$category_id,$text,$price,$descount,$image);
	$insert_combo -> execute();
	return $mysqli -> insert_id;
}
$name_combo_id = insert_combo($name_combo,$description,$price,$descounts,$name_photo,$category_id);

# pizza

function insert_menu($array,$combo_id)
{
	global $mysqli;
	foreach ($array as $key => $value) {
		$insert_menu = $mysqli -> query("INSERT INTO `combo`(`menu_id`,`name_combo_id`) VALUES('$value','$combo_id')");
		// $insert_combo -> bind_param('ii',$value,$combo_id);
		// $insert_combo -> execute();
	}
}

if(count($pizza) > 0)
	insert_menu($pizza,$name_combo_id);
if(count($drinks) > 0)
	insert_menu($drinks,$name_combo_id);
if(count($snakcs) > 0)
	insert_menu($snakcs,$name_combo_id);
if(count($desert) > 0)
	insert_menu($desert,$name_combo_id);


	header("Location:../index.php");