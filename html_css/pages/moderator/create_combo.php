<?php 
$category_id = $_REQUEST['category_id'];

$select_categories = $mysqli -> query("SELECT * FROM `categories` WHERE `id` != 6 and `id` != 7 and `id` != 8 and `id` != 1");
$select_categories = $select_categories -> fetch_all(MYSQLI_ASSOC);

$select_name = $mysqli -> prepare("SELECT `name` FROM `categories` WHERE `id` = ?");
$select_name -> bind_param('i',$category_id);
$select_name -> execute();
$result = $select_name -> get_result();
$select_name_categories = $result -> fetch_assoc();

$select_menu = $mysqli -> prepare("SELECT * from `menu` ");
$select_menu -> execute();
$result = $select_menu -> get_result();
$select_menu = $result -> fetch_all(MYSQLI_ASSOC);

foreach ($select_menu as $key => $value) {
	if($value['category_id'] == 2){
		$pizza[$key] = $value;
	}
	if($value['category_id'] == 3){
		$snakcs[$key] = $value;
	} 
	if($value['category_id'] == 4){
		$desert[$key] = $value;
	}
	if($value['category_id'] == 5){
		$drinks[$key] = $value;
	}
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title<?=$get_options[2]['value']?>></title>
	<link rel="stylesheet" href="html_css/css/head_or_foot.css">
	<link rel="stylesheet" href="html_css/css/create_order.css">
	<link rel="stylesheet" href="html_css/css/list_users.css">
	<style>
		.menu{
			display: flex;
			flex-direction: row;
			justify-content: space-between;
		}
		.menu h2{
			background: #7e96ec;
			color:#fff;
			padding: 10px;
		}
		.pizza h4,.dessert h4,.drinks h4,.snakcs h4{
			border:1px solid #7e96ec;
			padding: 0px;
		}
	</style>
</head>
<body>
	
	<?php require_once 'html_css/pages/public/header.php'; ?>
	<div class="container_2">
		<content class="content">
			<br>
			<div class="error">
				<br>
					<?=error('name_combo').'<br>'?>
					<?=error('menu').'<br>'?>
					<?=error('price').'<br>'?>
					<?=error('photo')?>
				</div>
			<form action="/add_combo" method="post" class="create" autocomplete="off" enctype="multipart/form-data">
				
				<div class="form_group">
					<label>Название комбо</label>
					<input type="text" name="name_combo" placeholder="Name product">
				</div>
				<div class="form_group">
					<label>Описание</label>
					<textarea name="description" placeholder="Description"></textarea>
				</div>
				<div class="form_group">
					<label>Цена</label>
					<input type="text" name="price" placeholder="Price">
				</div>
				<div class="form_group menu">
					<div class="pizza">
						<h2>PIZZA</h2>
						<?php foreach ($pizza as $key => $value): ?>
							<h4><input type="checkbox" name="pizza[<?=$value['id']?>]" value="<?=$value['id']?>"><?=$value['name_menu']?></h4>
						<?php endforeach ?>
					</div>
					<div class="dessert">
						<h2>DESSERT</h2>
						<?php foreach ($desert as $key => $value): ?>
							<h4>
								<input type="checkbox" name="desert[<?=$value['id']?>]" value="<?=$value['id']?>"><?=$value['name_menu']?></h4>
						<?php endforeach ?>
					</div>
					<div class="drinks">
						<h2>Drinks</h2>
						<?php foreach ($drinks as $key => $value): ?>
							
						<h4>
							<input type="checkbox" name="drinks[<?=$value['id']?>]" value="<?=$value['id']?>"><?=$value['name_menu']?></h4>
						<?php endforeach ?>
					</div>
					<div class="snakcs">
						<h2>SNAKCS</h2>
						<?php foreach ($snakcs as $key => $value): ?>
							<h4>
								<input type="checkbox" name="snakcs[<?=$value['id']?>]" value="<?=$value['id']?>"><?=$value['name_menu']?></h4>
						<?php endforeach ?>
					</div>
				</div>
				<div class="form_group">
					<label>Скидка</label>
					<input type="text" name="descounts" placeholder="Discount product">
				</div>
				<div class="form_group">
					<label>Фото</label>
					<input type="file" name="photo" >
				</div>
				<div class="form_group">
					<label>Category</label>
					<input type="text" value="<?=$select_name_categories['name']?>">
					<input type="hidden"  name="category" value="<?=$category_id?>">
				</div>
				
				<div class="form_group form_submit">
					<input type="submit" value="Создать">
				</div>
			</form>
		</content>
	</div>
</body>
</html>