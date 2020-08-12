<?php 

$basket = json_decode($_COOKIE['basket'],true);

$user_id = $_SESSION['id'];
$count_in_basket = count($select_basket);

if(!isset($_SESSION['id'])){
	if(isset($_COOKIE['basket'])){
		foreach($basket as $value){
			if(isset($value['menu_id'])){
				$sql = "SELECT * FROM `menu`
					WHERE `id` = ? ORDER BY `id` DESC";
				$select_basket = $mysqli -> prepare($sql);
				$select_basket -> bind_param('i',$value['menu_id']);
				$select_basket -> execute();
				$result = $select_basket -> get_result();
				$select_basket = $result -> fetch_all(MYSQLI_ASSOC);
				$sum += $select_basket[0]['price'];
				$count += count($select_basket[0]['id']);
			}	
		}	
	}
}else{
	$sql = "SELECT * FROM `basket`
			INNER JOIN `menu` ON `basket`.`menu_id` = `menu`.`id` 
			WHERE `user_id` = ? ORDER BY `basket`.`id` DESC";
	$select_basket = $mysqli -> prepare($sql);
	$select_basket -> bind_param('i',$_SESSION['id']);
	$select_basket -> execute();
	$result = $select_basket -> get_result();
	$select_basket = $result -> fetch_all(MYSQLI_ASSOC);
	
	foreach ($select_basket as  $value){
		$sum += $value['price'];
		$count += count($value['id']);
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Basket</title>
	<link rel="stylesheet" href="html_css/css/head_or_foot.css">
	<link rel="stylesheet" href="html_css/css/style.css">
	<style>
		.order_all{
			display: flex;
			flex-direction: column;
		}
	</style>
</head>
<body>
	<?php require_once 'header.php' ?>
<content class="content">
	<div class="container">
		<div class="content_value">
			<div class="serach">
				<form action="serach.php" method="post" class="form" autocomplete="off">
					<input type="text" placeholder="Название:" name="text">
					<img src="html_css/img/search.svg" class="img2">
				</form>
			</div>
			<div class="order_all">
				<h2><a href="/create_order_users?from=basket">Заказать</a></h2>
				<h2>Sum: <?=$sum ?></h2>
			</div>
			<h2>Количество: <?=$count?></h2>
			<div class="menu">
			<?php if (!isset($_SESSION['id'])): ?>
	            <?php if(isset($_COOKIE['basket'])): ?>
						<?php foreach($basket as $value):?>
							<?php if(isset($value['menu_id'])):?>
									<?php $sql = "SELECT * FROM `menu`
										WHERE `id` = ? ORDER BY `id` DESC";
									$select_basket = $mysqli -> prepare($sql);
									$select_basket -> bind_param('i',$value['menu_id']);
									$select_basket -> execute();
									$result = $select_basket -> get_result();
									$select_basket = $result -> fetch_all(MYSQLI_ASSOC);
									?>
									
									
								<div class="menu_value">
									<div class="img">
										<img src="html_css/img/<?=$select_basket[0]['image']?>" alt="">
									</div>
									<div class="name_price">
										<h2>Name: <?=$select_basket[0]['name_menu']?></h2>
										<h2>Price: <?=$select_basket[0]['price']?>ТГ.</h2>
									</div>
									<div class="function">
										<input type="hidden" id="user_id" value="<?=$select_users['id']?>">
										<!-- <h3><a href="more_info_menu.php?menu_id=<?=$value['menu_id']?>&category_id=<?=$value['category_id']?>">Выбрать</a></h3> -->
										<h3><a href="/remove_from_basket?menu_id=<?=$select_basket[0]['id']?>">Убрать из корзины</a></h3>
									</div>	
									<div class="text">
										<p><?=$value['value']?></p>
									</div>
								</div>
							<?php endif; ?>	
						<?php endforeach ?>
					<?php endif; ?>
				<?php else: ?>
					<?php foreach ($select_basket as  $value): ?>
						<div class="menu_value">
							<div class="img">
								<img src="html_css/img/<?=$value['image']?>" alt="">
							</div>
							<div class="name_price">
								<h2>Name: <?=$value['name_menu']?></h2>
								<h2>Price: <?=$value['price']?>ТГ.</h2>
							</div>
							<div class="function">
								<input type="hidden" id="user_id" value="<?=$select_users['id']?>">
								<!-- <h3><a href="more_info_menu.php?menu_id=<?=$value['menu_id']?>&category_id=<?=$value['category_id']?>">Выбрать</a></h3> -->
								<h3>
									<a href="/remove_from_basket?menu_id=<?=$value['menu_id']?>&user_id=<?=$value['user_id']?>">Убрать из корзины</a>
								</h3>
							</div>	
							<div class="text">
								<p><?=$value['value']?></p>
							</div>
						</div>	
					<?php endforeach; ?>	
			<?php endif ?>	


		</div>
		</div>
	
	</div>
</content>		
</body>
</html>
