<?php 

$menu_id = $_REQUEST['menu_id'];
$category_id = $_REQUEST['category_id'];

if($category_id == 1){
	$sql = "SELECT * FROM `menu` 
			JOIN `combo` ON `combo`.`name_combo_id` = `menu`.`id` 
			WHERE `menu`.`id` = ? and `menu`.`category_id` = ?";
	$select_menu = $mysqli -> prepare($sql);
	$select_menu -> bind_param('ii',$menu_id,$category_id);
	$select_menu -> execute();
	$result = $select_menu -> get_result();
	$select_combo = $result -> fetch_all(MYSQLI_ASSOC);
	$select_menu_id = [];
	foreach ($select_combo as $key => $value) {
		$select_menu_id[] = $value['menu_id'];
	}
}else{
	$sql = "SELECT `menu`.*,`categories`.`name` FROM `menu`
			inner join `categories` ON `menu`.`category_id` = `categories`.`id` 
			WHERE `menu`.`id` = ?";
	$select_menu = $mysqli -> prepare($sql);
	$select_menu -> bind_param('i',$menu_id);
	$select_menu -> execute();
	$result = $select_menu -> get_result();
	$select_combo = $result -> fetch_all(MYSQLI_ASSOC);
}

include_once 'html_css/pages/public/more_info_menu.php';