
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$get_options[4]['value']?></title>
	<link rel="stylesheet" href="/html_css/css/head_or_foot.css">
	<link rel="stylesheet" href="/html_css/css/style.css">
	<style>
		.content_value h2{
			text-align: center;
			padding-top: 10px;
		}
		.error{
			text-align: center;
			color:red;
			display: flex;

		}
	</style>
</head>
<body>
<?php require_once 'header.php'; ?>
<content class="content">
	<div class="container">
		<div class="content_value">
			<h2>Результат поиска: <?=$text?></h2>
			<div class="menu">
				<p class="error"><?php echo str_repeat($error, 30) ?></p>
				<?php foreach ($select_serach as $value): ?>
				<div class="menu_value">
					<div class="img">
						<img src="html_css/img/<?=$value['image']?>" alt="">
					</div>
					<div class="name_price">
						<h2>Name: <?=$value['name_menu']?></h2>
						<h2>Price: <?=$value['price'] ?>ТГ.</h2>
					</div>
					<div class="function">
						<?php if ($select_users['role_id'] != 3): ?>
							    <div class="basket">
									<button class="pass" data-id=<?=$value['id']?> >Корзина</button>
									<img src="html_css/img/basket.svg" class="basket_img">
								</div>	
								<input type="hidden" id="user_id" value="<?=$user_id?>">
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



