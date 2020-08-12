<?php 
require_once 'main_function/main_include.php';
require_once 'modules/result_router.php';


if(count($_REQUEST['category_id']) == 0)
	$category_id = 2;
else
	$category_id = $_REQUEST['category_id'];

$select_users = get_users($_SESSION['id']);
if($select_users['role_id'] == 3 or $select_users['role_id'] == '' ){
	$publish = 1;
	$select_menu = $mysqli -> prepare("
		SELECT `menu`.*,`categories`.`name`
		FROM `menu`
		inner join `categories` ON `menu`.`category_id` = `categories`.`id` 
		WHERE `category_id` = ? and `menu`.`publish` = ?  ORDER BY `menu`.`date_create` DESC 
	");
	$select_menu -> bind_param('ii',$category_id,$publish);
	$select_menu -> execute();
}else{
	$select_menu = $mysqli -> prepare("
		SELECT `menu`.*,`categories`.`name`
		FROM `menu`
		inner join `categories` ON `menu`.`category_id` = `categories`.`id` 
		WHERE `category_id` = ?   ORDER BY `menu`.`date_create` DESC 
	");
	$select_menu -> bind_param('i',$category_id);
	$select_menu -> execute();
}	
$result = $select_menu -> get_result();
$select_menu = $result -> fetch_all(MYSQLI_ASSOC);





?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Pizza.nu</title>
	<link rel="stylesheet" href="http://pizza/html_css/css/head_or_foot.css">
	<link rel="stylesheet" href="http://pizza/html_css/css/style.css">
</head>
<body>
	<?php require_once 'html_css/pages/public/header.php'; ?>
<content class="content">
	<div class="container">
		<!-- <div class="paralax"></div> -->
		<div class="content_value">
			<div class="serach">
				<form action="/serach_post" method="post" class="form" autocomplete="off">
					<input type="text" placeholder="Название:" name="text">
					<img src="html_css/img/search.svg" class="img2">
				</form>
			</div>
			<h2><span class="donnot_seeMaxw_1"><?=$select_menu[0]['name']?></span></h2>
			<div class="menu">

			<?php foreach ($select_menu as $value): ?>
				<div class="menu_value">
					<div class="img">
						<img src="html_css/img/<?=$value['image']?>">
					</div>
					<div class="name_price">
						<h2><?=$value['name_menu']?></h2>
						<h2> <?=$value['price']?>ТГ.</h2>
					</div>
					<div class="function">
						<?php if ($select_users['role_id'] == 3 or $select_users['role_id'] == ''): ?>
							<div class="basket">
								<button class="pass" data-id=<?=$value['id']?> >Корзина</button>
								<img src="html_css/img/basket.svg" class="basket_img">
							</div>
								<input type="hidden" id="user_id" value="<?=$select_users['id']?>">
								<h3><a href="/choose_menu?menu_id=<?=$value['id']?>&category_id=<?=$value['category_id']?>">Выбрать</a></h3>
						<?php else: ?>
								<h3><a href="/moderation?menu_id=<?=$value['id']?>">Модерация</a></h3>	
								<h3><a href="/choose_menu?menu_id=<?=$value['id']?>&category_id=<?=$value['category_id']?>" class="choose">Выбрать</a></h3>	
						<?php endif ?>
					</div>	
					<div class="text">
						<p><?=substr($value['value'],0,600)?></p>
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
		let html = $('.text').text();
		$('.pass').on('click',function(){
			let idVal = $(this).data('id')
			let user_id = $('#user_id').val();
			$.ajax({
			  method: "POST",
			  url: "public_part/add_basket.php",
			  data: { id:idVal,user_id:user_id }
			})
			.done(function( msg ) {
			    alert(msg);
			});
	    });
	});
</script>		
</body>
</html>





