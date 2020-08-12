<?php  

function users($user_id){
	global $mysqli;
	$select = $mysqli -> prepare("SELECT * FROM `users` WHERE `id` = ?");
	$select -> bind_param("i",$user_id);
	$select -> execute();
	$result = $select -> get_result();
    $users = $result -> fetch_assoc();
    return $users;
}

if(isset($_SESSION['id'])){
	$users = get_users($_SESSION['id']);
}

function categories(){
	global $mysqli;
    $select_categories = $mysqli -> prepare("SELECT `id`,`name` FROM `categories`");
    $select_categories -> execute();
    $result = $select_categories -> get_result();
    $select_categories = $result -> fetch_all(MYSQLI_ASSOC);
    return $select_categories;
}
$categories = categories($user_id);
$get_options = get_options();
$site_title = $get_options[4]['value'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$get_options[2]['value']?></title>
</head>
<body>
	<header class="header">
		<div class="container">
			<div class="head_value">
				<div class="head_right">
					<div class="title">
						<h1><?=substr($site_title,0,5)?><span><?=substr($site_title,5,3)?></span></h1>
					</div>
					<div class="phone">
						<h3>
							<span class="donnot_seeMaxw_1">Звонить по номеру:</span>
							<a href=""><?=$get_options[2]['value']?></a>
						</h3>
						<a href="">Отзывы</a>
					</div>
				</div>
				<div class="head_middle">
					<h3>Доставка пиццы по <a href="#">(Астане)</a></h3>
					<div class="head_middle_bottom">
						<h5>Если мы не смогли доставить пиццу за час мы отдаем пиццу бесплатно</h5>
					</div>
				</div>
				<div class="profile">
					 <nav class="menu" style="padding-top: 0;">
		                <ul>
		                	<?php /* if : 1 */ if (!isset($_SESSION['id'])): ?>
		                		 <li><a href="/login_get" class="i">Войти</a>
		                		 	<ul>
		                		 		<li><a href="/see_basket">Корзина</a></li>
		                		 		<li><a href="/see_my_orders">Заказы</a></li>
		                		 	</ul>
		                		 </li>
		                    <?php else: ?>
		                    <li><a href="#" class="i"><?=$users['login']?></a>
		                        <ul>
		                        	<?php /*if : 2*/if ($users['role_id'] == 2): ?>
				                		<li><a href="#">Cоздать</a>
				                			<ul>
				                				<?php foreach ($categories as $value): ?>
												<li><a href="/create_menu?category_id=<?=$value['id']?>"><?=$value['name']?></a></li>
												<?php endforeach ?>
											</ul>
				                		</li>
				                		<li><a href="/list_users">Список users</a></li>
				                		<li><a href="/order_users">Заказы users</a></li>
				                		<li><a href="#">Message</a></li>
				                		<li><a href="/options_site">Инфо о сайте</a></li>
				                		<li><a href="/exit">Выйти</a></li>
				                	<?php else:  ?>	
				                		<li><a href="/see_my_orders">Заказы</a></li>
			                            <li><a href="/see_basket">Корзина</a></li>
			                            <li><a href="/exit">Выйти</a></li>
			                	<?php /*if : 2*/endif ?>
			                <?php /*if : 1*/endif ?>	
		                        </ul>
		                    </li>
		                </ul>
		            </nav>
				</div>
			</div>
			<div class="head_top_categories">
				<?php foreach ($categories as $value): ?>
					<a href="/?category_id=<?=$value['id']?>"><?=$value['name']?></a>
				<?php endforeach ?>
			</div>
		</div>
	</header>

</body>
</html>
