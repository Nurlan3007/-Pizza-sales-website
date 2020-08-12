<?php 
$menu_id =  $_REQUEST['menu_id'];

function select_menu($menu_id){
	$mysqli = connect_database();
	$select_menu = $mysqli -> prepare("
	SELECT * FROM `menu`
	LEFT JOIN `rating` ON `rating`.`menu_id` = `menu`.`id`
	LEFT JOIN `comment` ON `comment`.`menu_id` = `menu`.`id`
	WHERE `menu`.`id` = ? GROUP BY `menu`.`id`");
	$select_menu -> bind_param('i',$menu_id);
	$select_menu -> execute();
	$result = $select_menu -> get_result();
	$select_menu = $result -> fetch_all(MYSQLI_ASSOC);
	return $select_menu;	
}

$select_menu = select_menu($menu_id);



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$get_options[4]['value']?></title>
	<link rel="stylesheet" href="html_css/css/head_or_foot.css">
	<link rel="stylesheet" href="html_css/css/create_order.css">
	<style>
		.publish{
			border:0;
			background: 0;
			color:#fff;
			background: #0071f0;
			padding: 5px;
			margin-bottom: 20px;
			font-size: 18px;
			cursor: pointer;
			box-shadow: 5px 5px 5px gray;
			border-radius: 10px;
			transition: background 0.6s;
			width: 200px;
			text-align: center;
		}
		.publish:hover{
			background:#3a7dc8;
		}
</style>
</head>
<body>
	<?php require_once 'html_css/pages/public/header.php'; ?>
	<div class="container_2">
		<content class="content">
			<div class="error">
					<?=error('main_name').'<br>'?>
					<?=error('description').'<br>'?>
					<?=error('price').'<br>'?>
					<?=error('photo')?><br>
					<?=error('descount')?>
				</div>
			<form action="/moderation_post" method="post" class="create" autocomplete="off" enctype="multipart/form-data">
			<?php foreach ($select_menu as $key => $value): ?>
				<div class="form_group main_button">
					<?php if ($value['publish'] == 1): ?>
						<a href="../../../admin_part/publish.php?menu_id=<?=$menu_id?>&p=<?=0?>" class="publish">Убрать для users</a>
					<?php else: ?>	
					<a href="../../../admin_part/publish.php?menu_id=<?=$menu_id?>&p=<?=1?>" class="publish">Опубликовать для users</a>
					<?php endif ?>
						
				</div>
				<div class="form_group">
					<label>Название товара</label>
					<input type="text" name="main_name" value="<?=$value['name_menu']?>" placeholder="Name product">
					<input type="hidden" name="menu_id" value="<?=$menu_id?>">
				</div>
				<div class="form_group">
					<label>Описание</label>
					<textarea name="description" placeholder="Description"><?=$value['value']?></textarea>
				</div>
				<div class="form_group">
					<label>Цена</label>
					<input type="text" name="price" value="<?=$value['price']?>" placeholder="Price">
				</div>
				<div class="form_group">
					<label>Скидка</label>
					<input type="text" name="descounts" value="<?=$value['descounts']?>" placeholder="Discount product">
				</div>
				<div class="form_group">
					<label>Изменить Фото</label>
					<input type="hidden" name="old_photo" value="<?=$value['image']?>">
					<input type="file" name="photo">
				</div>
				<div class="form_group">
					<label>Категория</label>
					<select name="categories">
						<?php foreach ($categories as $value): ?>
							<?php if($value['id'] == $select_menu[0]['category_id']): ?>
								<option value="<?=$value['id']?>"><?=$value['name']?></option>
							<?php endif; ?>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form_group form_submit">
					<input type="submit" value="Создать">
				</div>
        <?php endforeach ?>	
			</form>
		</content>
	</div>
</body>
</html>


