
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="/html_css/css/head_or_foot.css">
	<link rel="stylesheet" href="/html_css/css/style.css">
	<link rel="stylesheet" href="/html_css/css/more_info.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			let text_combo = $('.text_value').text();
			if(text_combo.length > 3000){
				$('.text_value').html(text_combo.substr(0,800));
			}
			$('#read_more').on('click',function(){
				$('.text_value').html(text_combo.substr(0,100000));
			});
			$('#read_min').on('click',function(){
				$('.text_value').html(text_combo.substr(0,800));
			});
		});
	</script>
</head>
<body>
	<?php require_once 'header.php'; ?>
	<content class="content">
		<div class="container">
			<div class="content_value">
				<div class="combo">
					<div class="combo_photo">
						<img src="/html_css/img/<?=$select_combo[0]['image']?>" alt="">
					</div>
					<div class="info_combo">
						<div class="combo_text">
							<p class="text_value">
								<?=$select_combo[0]['value']?>
							</p>
							<?php if(strlen($select_combo[0]['value']) > 3000 ): ?>
								<button type="button" id="read_more">Read more</button>
								<button type="button" id="read_min">Read min</button>
							<?php endif; ?>
						</div>
						
						<div class="combo_name">
							<h2>Name: <?=$select_combo[0]['name_menu']?></h2>
						</div>
						<div class="combo_price" style="">
							<h2>Price: <?=$select_combo[0]['price'].' тг'?></h2>
						</div>
						<div class="combo_descount">
							<h2>Descount: <?=$select_combo[0]['descounts'] . '%'?></h2>
						</div>
						<?php if($select_combo[0]['descounts'] > 1): ?>
							<div class="combo_price" style="">
								<h2>Price NOW: <?=count_descount($select_combo[0]['price'],$select_combo[0]['descounts'])?></h2>
							</div>
						<?php endif; ?>	
						<div class="form">
							<input type="hidden" name="menu_id" value="<?=$menu_id?>">
							<a href="/create_order_users?menu_id=<?=$menu_id?>"><input type="submit" value="Заказать"></a>
						</div>
					</div>	
				</div>	
				<h2>Состоит из </h2>
				<div class="menu">
				<?php if(isset($select_menu_id)): ?>	
					<?php foreach ($select_menu_id as $key => $value): ?>
						<?php 
						$select_menu = $mysqli -> query("SELECT * FROM `menu` WHERE `id` = '$value'");
						$select_menu = $select_menu -> fetch_all(MYSQLI_ASSOC);	
						?>
					<div class="menu_value">
						<div class="img">
							<img src="/html_css/img/<?=$select_menu[0]['image']?>" alt="">
						</div>
						<div class="name_price">
							<h2>Name: <?=$select_menu[0]['name_menu']?></h2>
						</div>
						
						<div class="text">
							<p><?=$select_menu[0]['value']?></p>

						</div>
					</div>	
					<?php endforeach ?>
				<?php endif; ?>	
			</div>
			</div>
		</div>
	</content>
	
</body>
</html>
