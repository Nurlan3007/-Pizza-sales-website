<?php 
$category_id = $_GET['category_id'];

if($_REQUEST['category_id'] == 1)
	header("Location:/create_combo?category_id=$category_id");
if($_REQUEST['category_id'] == 6 || $_REQUEST['category_id'] == 7 || $_REQUEST['category_id'] == 8)
	header('Location:/');

$select_name = $mysqli -> prepare("SELECT `name` FROM `categories` WHERE `id` = ?");
$select_name -> bind_param('i',$category_id);
$select_name -> execute();
$result = $select_name -> get_result();
$select_name = $result -> fetch_assoc();


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title<?=$get_options[4]['value']?>></title>
	<link rel="stylesheet" href="html_css/css/head_or_foot.css">
	<link rel="stylesheet" href="html_css/css/create_order.css">
</head>
<body>
	<?php require_once 'html_css/pages/public/header.php'; ?>
	<div class="container_2">
		<content class="content">
			<div class="error">
					<?=error('main_name').'<br>'?>
					<?=error('description').'<br>'?>
					<?=error('price').'<br>'?>
					<?=error('photo')?>
				</div>
			<form action="/add_order" method="post" class="create" autocomplete="off" enctype="multipart/form-data">
				<div class="form_group">
					<label>Категория</label>
					<input type="text" value="<?=$select_name['name']?>">
					<input type="hidden" name="category_id" value="<?=$category_id?>">
				</div>
				<div class="form_group">
					<label>Название товара</label>
					<input type="text" name="main_name" placeholder="Name product">
				</div>
				<div class="form_group">
					<label>Описание</label>
					<textarea name="description" placeholder="Description"></textarea>
				</div>
				<div class="form_group">
					<label>Цена</label>
					<input type="text" name="price" placeholder="Price">
				</div>
				<div class="form_group">
					<label>Скидка</label>
					<input type="text" name="descounts" placeholder="Discount product">
				</div>
				<div class="form_group">
					<label>Фото</label>
					<input type="file" name="photo" >
				</div>
				
				<div class="form_group form_submit">
					<input type="submit" value="Создать">
				</div>

			</form>
		</content>
	</div>
</body>
</html>