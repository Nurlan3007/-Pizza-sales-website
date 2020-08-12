<?php
$user_id = $_SESSION['id'];
$text = trim($_REQUEST['text']);

$serach = function () use($text)
{
	global $mysqli;
	$serach = $mysqli -> prepare("SELECT * FROM `menu` WHERE `name_menu` like '%$text%'");
	if($serach -> execute()){
		$result = $serach -> get_result();
		$serach = $result -> fetch_all(MYSQLI_ASSOC);
		return $serach;
	}
};
$select_serach = $serach();

if(count($select_serach) == 0)
	$error = ' Нечего не нашли,	';
// print_e($select_serach);
include_once 'html_css/pages/public/serach.php';

