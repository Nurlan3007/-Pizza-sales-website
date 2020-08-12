<?php  

function select_Users(){
	global $mysqli;
	$select_users = $mysqli -> prepare("SELECT * FROM `users` ORDER BY `id` DESC ");
	$select_users -> execute();
	$result = $select_users -> get_result();
	$select_users = $result -> fetch_all(MYSQLI_ASSOC);
	return $select_users;
}
$select_users = select_Users();
$countusers = count($select_users);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$get_options[4]['value']?></title>
	<link rel="stylesheet" href="http://pizza/html_css/css/head_or_foot.css">
	<link rel="stylesheet" href="http://pizza/html_css/css/list_users.css">
</head>
<body>
	<?php require_once 'html_css/pages/public/header.php'; ?>
	<div class="container">
		<h2>Users:<?=$countusers?></h2>
		<div class="users">

			<table>
				<thead>
					<tr>
						<?php foreach ($select_users[0] as $key => $value): ?>
							<th class="key"><?=$key?></th>
							
						<?php endforeach ?>

					</tr>
				</thead>
				<tbody>
					<?php foreach ($select_users as  $value): ?>
					<tr>
						<th><?=$value['id']?></th>
						<th><?=substr($value['login'],0,30)?></th>
						<th><?=substr($value['email'],0,40)?></th>
						<th><?=substr($value['password'],0,10)?>?></th>
						<?php if ($value['role_id'] == 3): ?>
								<th>User</th>
						<?php endif ?>
						<?php if ($value['role_id'] == 2): ?>
								<th>Moderator</th>
						<?php endif ?>
						<?php if ($value['role_id'] == 1): ?>
								<th>Admin</th>
						<?php endif ?>
						
						<th><?=substr($value['token'],0,10)?></th>
						<th><?=$value['phone']?></th>
						<th><?=$value['ban']?></th>
						<th class="ban"><a href="../admin_part/ban.php?user_id=<?=$value['id']?>">Забанить</a></th>
						<th class="no_ban"><a href="/beat_off.php?user_id=<?=$value['id']?>">Отбанить</a></th>
					</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>


