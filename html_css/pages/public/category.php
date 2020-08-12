<?php 

require_once '../../../main_function/main_include.php';

$category_id = $_REQUEST['category_id'];
$user_id = $_SESSION['id'];
$select_menu = $mysqli -> prepare("
	SELECT *
	FROM `menu` 
	inner join `categories` ON `menu`.`category_id` = `categories`.`id` 
	WHERE `category_id` = ? ORDER BY `menu`.`name_menu` DESC ");
$select_menu -> bind_param('i',$category_id);
$select_menu -> execute();
$result = $select_menu -> get_result();
$select_menu = $result -> fetch_all(MYSQLI_ASSOC);

$select_users = get_users();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$get_options[4]['value']?></title>
	<link rel="stylesheet" href="../../css/head_or_foot.css">
	<link rel="stylesheet" href="../../css/style.css">
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
			<h2><?=$select_menu[0]['name']?></h2>
			<div class="menu">

				<?php foreach ($select_menu as $key => $value): ?>
				<div class="menu_value">
					<div class="img">
						<img src="../../img/<?=$value['image']?>" alt="">
					</div>
					<div class="name_price">
						<h2>Name: <?=$value['name_menu']?></h2>
						<h2>Price: <?=$value['price']?>ТГ.</h2>
					</div>
					<div class="function">
						<?php if ($select_users['role_id'] == 3): ?>
							<div class="basket">
								<button class="pass" data-id=<?=$value['id']?> >Корзина</button>
								<img src="../../img/basket.svg" class="basket_img">
							</div>
								<input type="hidden" id="user_id" value="<?=$select_users['id']?>">
								<h3><a href="more_info_menu.php?menu_id=<?=$value['id']?>">Выбрать</a></h3>
						<?php else: ?>
								<h3><a href="">Модерация</a></h3>	
								<h3><a href="more_info_menu.php?menu_id=<?=$value['id']?>" class="choose">Выбрать</a></h3>	
						<?php endif ?>
					</div>	
					<div class="text">
						<p><?=$value['value']?></p>
					</div>
				</div>	
				<?php endforeach ?>
			</div>
		</div>
	</div>
</content>	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		$('.pass').on('click',function(){
			let idVal = $(this).data('id')
			let user_id = $('#user_id').val();
			$.ajax({
			  method: "POST",
			  url: "../../../public_part/pass.php",
			  data: { id:idVal,user_id:user_id }
			})
			  .done(function( msg ) {
			    alert( msg);
			});
		});
	});
</script>		
</body>
</html>





