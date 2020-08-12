<?php  
if(!isset($_SESSION['id']))
	$user_id = $_GET['last_id'];
else
	$user_id = $_SESSION['id'];


$users = get_users($user_id);
$user_id = $users['id'];
$menu_id = $_REQUEST['menu_id'];

$combo_id = $_REQUEST['combo_id'];

// Переменные, управляющие конструкции (условные операторы, циклы), массивы, работа с файлами, html теги, css свойства, sql запросы и т.д.


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="html_css/css/head_or_foot.css">
	<link rel="stylesheet" href="html_css/css/create_order.css">
</head>
<body>
	<?php require_once 'header.php'; ?>
	<div class="container_2">
		<content class="content">
			
			<h2 style="color:red"><?=$error?></h2>
			<?php if (!isset($users['id'])): ?>
				<h2>Информации о вас</h2>
					<form action="/create_temporary_user" method="post" class="create" autocomplete="off">
						<div class="form_group">
							<div class="error">
								<?=error('phone').'<br>'?>
								<?=error('email').'<br>'?>
								<?=error('login').'<br>'?>
							</div>
							<label>Login</label>
							<input type="hidden" name="menu_id"   value="<?=$menu_id?>">
							<input type="hidden" name="menu_id"   value="<?=$menu_id?>">
							<input type="hidden" name="from"       value="<?=$_GET['from']?>">
							<input type="text" placeholder="login" name="login">
						</div>
						<div class="form_group">
							<label>Phone</label>
							<input type="phone" placeholder="phone" name="phone">
						</div>
						<div class="form_group form_submit">
							<input type="submit" value="Create">
						</div>
					</form>
			<?php else: ?>		
			

			<form action="/create_order_users_post" method="post" class="create" autocomplete="off">
				<div class="form_group">
					<label>Login</label>
					<input type="text" name="user_login" value = "<?=$users['login']?>" placeholder="<?=$users['login']?>" disabled>
					<input type="hidden" name="menu_id"   value="<?=$menu_id?>">
					<input type="hidden" name="user_id"   value="<?=$users['id']?>" >
					<input type="hidden" name="from"      value="<?=$_GET['from']?>" >
					<input type="hidden" name="combo_id"  value="<?=$combo_id?>">
				</div>
				<div class="form_group">
					<label>Улица</label>
					<input type="text" name="street" placeholder="Street" >
				</div>
				<div class="form_group">
					<label>Дом</label>
					<input name="house" placeholder="Дом" >
				</div>
				<div class="form_group">
					<label>Квартира</label>
					<input type="" name="apartment" placeholder="Квартира"  >
				</div>
				<div class="form_group">
					<label>Этаж</label>
					<input type="" name="floor" placeholder="Этаж" >
				</div>
					<div class="form_group">
						<label>Количество</label>
						<input type="" name="count" placeholder="Количество" >
					</div>
				<div class="form_group form_submit">
					<input type="submit" value="Заказать">
				</div>
			</form>
			<div class="error">
					<?=error('street').'<br>'?>
					<?=error('house').'<br>'?>
					<?=error('floor').'<br>'?>
					<?=error('apartment').'<br>'?>
					<?=error('menu_count').'<br>'?>
			</div>
			<?php endif ?>	
		</content>
	</div>
</body>
</html>

