<?php 


$select_order = $mysqli -> prepare("
	SELECT `orders`.*,`order_product`.`menu_count` , `menu`.`name_menu`,`menu`.`image`,`menu`.`price`,`users`.`login` 
	FROM `orders` 
	INNER JOIN `order_product` on `order_product`.`order_id` = `orders`.`id`
	INNER JOIN `menu` on `order_product`.`menu_id` = `menu`.`id`
	INNER JOIN `users` on `orders`.`user_id` = `users`.`id` 
	ORDER BY `orders`.`date` DESC"
    );
$select_order -> execute();
$result = $select_order -> get_result();
$select_order = $result -> fetch_all(MYSQLI_ASSOC);




foreach ($select_order as $key => $value) {
	$date = new DateTime($value['date']);
	$date -> modify('+2 day');
	$future_date =  $date -> format('d').'<br>';
	$now_date = date('d');
	$result=($future_date < $now_date);
	if($result == true){
		check_date_order($value['id']);
	}
}





?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="html_css/css/head_or_foot.css">
	<link rel="stylesheet" href="html_css/css/style.css">
	<style>
		.orders{
			width: 300px;
			text-align: left;
			/*box-shadow: 4px 4px 4px gray;*/
			padding: 30px;
		}
		.menu{

			margin-right: 30px;
			flex-wrap: wrap;
		}
		.orders h2 span{
			color:#0071f0;
		}
		.orders h2{
			width: 300px;
			word-wrap: break-word; /* Перенос слов */ 
			margin-left:30px;
		}
	</style>
</head>
<body>
	<?php require_once 'html_css/pages/public/header.php'; ?>
	<content class="content">
	<div class="container">
		<div class="content_value">
			<div class="serach">
				<form action="serach.php" method="post" class="form" autocomplete="off">
					<input type="text" placeholder="Название:" name="text">
					<img src="https://vk.com//images/svg_icons/ic_head_loupe.svg" class="img2">
				</form>
			</div>
			<h2><?=$select_menu[0]['name']?></h2>
			<div class="menu">
				<?php foreach ($select_order as $key => $value): ?>
				<div class="menu_value">
					<div class="orders  name_price">
						<h2><span>Who ordered</span> : <?=$value['login']?></h2>
						<div class="img">
							<img src="html_css/img/<?=$value['image']?>" alt="">
						</div>
						<h2><?=$value['name_menu']?></h2>
						<h2><?=$value['price']?> TG</h2>
						<h2><span>Count:</span> <?=$value['menu_count']?></h2>
						<h2 style="text-align: center;">Where need send order?</h2>
						<h2><span>Street:</span> <?=$value['street']?></h2>
						<h2><span>House:</span> <?=$value['house']?></h2>
						<h2><span>Apartment:</span> <?=$value['apartment']?></h2>
						<?php 
						$date_create = new DateTime($value['date']);
						$date_create =  $date_create -> format('d.m.Y;H:i:s').'<br>';
						?>
						<h2><span>Date_create:</span> <?=$date_create?></h2>
						
					</div>
				</div>	
				<?php endforeach ?>
			</div>
		</div>
	</div>
</content>	
</body>
</html>
