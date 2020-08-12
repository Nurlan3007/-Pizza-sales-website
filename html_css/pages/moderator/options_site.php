<?php 


$course_curr = get_course();
$options = get_options();

if($options[0]['value'] != $course_curr)
	update_usd($course_curr);

$count_products = count_products();

if($count_products != $options[4]['value'])
	update_count_products($count_products);



?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$options[4]['value']?></title>
	<link rel="stylesheet" href="html_css/css/head_or_foot.css">
	<link rel="stylesheet" href="html_css/css/options.css">
</head>
<body>
	<?php require_once 'html_css/pages/public/header.php'; ?>
<div class="container">	
	<div class="info">
		<table class="table">
			<thead class="thead">
				<tr>
					<th>ID</th>
					<th>Системная название</th>
					<th>Название опции</th>
					<th>Значение</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($options as $value): ?>
				<tr>
		            <th class="id"><?=$value['id']?></th>
		            <th><?=$value['name']?></th>
		            <form action="">
			            <th><input type="" value="<?=$value['options_name']?>"></th>
			            <th><input type="" value="<?=$value['value']?>"></th>
			        </form>    
				</tr>
				<?php endforeach ?>
			
			</tbody>
		</table>
	</div>
</div>	
</body>
</html>