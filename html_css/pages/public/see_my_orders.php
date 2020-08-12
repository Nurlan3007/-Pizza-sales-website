<?php 

if(!isset($_SESSION['id'])) {
	$user_id = $_SESSION['temporary_id']; 
}else{
	$user_id = $_SESSION['id'];
}

$select_order = $mysqli -> prepare("
	SELECT 
	`orders`.*,`order_product`.`menu_count` , 
	`menu`.`name_menu`,`menu`.`image`,`menu`.`price`,
	`users`.`login` ,`users`.`password`
	FROM `orders` 
	INNER JOIN `order_product` on `order_product`.`order_id` = `orders`.`id`
	INNER JOIN `menu` on `order_product`.`menu_id` = `menu`.`id`
	INNER JOIN `users` on `orders`.`user_id` = `users`.`id` 
	WHERE `orders`.`user_id` = ? ORDER BY `orders`.`date` DESC"
    );
$select_order -> bind_param('i',$user_id);
$select_order -> execute();
$result = $select_order -> get_result();
$select_order = $result -> fetch_all(MYSQLI_ASSOC);
if(count($select_order) == 0)
	$message = 'У вас нет заказов!!';

if(isset($_SESSION['temporary_id']))
	delete_temporary_users_and_his_orders($_SESSION['temporary_id']);


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>My orders</title>
	<link rel="stylesheet" href="html_css/css/head_or_foot.css">
	<link rel="stylesheet" href="html_css/css/style.css">
	<link rel="stylesheet" href="html_css/css/see_my_orders.css">
</head>
<body>
	<?php require_once 'header.php'; ?>
	<content class="content">
	<div class="container">
		<div class="content_value">
			<div class="serach">
				<form action="serach.php" method="post" class="form" autocomplete="off">
					<input type="text" placeholder="Название:" name="text">
					<img src="html_css/img/search.svg" class="img2">
				</form>
			</div>
			<?php foreach ($select_order as $key => $value) $sum += $value['price'];?>
			<h2 style="color:red"><?=$message?></h2>
			<h2><span>Sum price</span>: <?=$sum?></h2>
			<div class="menu">
				<?php foreach ($select_order as $key => $value): ?>
				<div class="menu_value">
					<div class="orders  name_price">
						<div class="img">
							<img src="html_css/img/<?=$value['image']?>" alt="">
						</div>
						<h2><?=$value['name_menu']?></h2>
						<h2><span></span> <?=$value['price']?> TG</h2>
						<h2><span>Count:</span> <?=$value['menu_count']?></h2>
						<h2><span>Street:</span> <?=$value['street']?></h2>
						<h2><span>House:</span> <?=$value['house']?></h2>
						<h2><span>Apartment:</span> <?=$value['apartment']?></h2>
						<?php 
						$date_create = new DateTime($value['date']);
						$date_create =  $date_create -> format('d:M').'<br>';
						?>
						<h2><span>Date:</span> <?=$date_create?></h2>
						
					</div>
				</div>	
				<?php endforeach ?>
			</div>
		</div>
	</div>
</content>	
</body>
</html>