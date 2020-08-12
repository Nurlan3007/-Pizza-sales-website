<?php
require_once '../main_function/main_include.php';

$menu_id = $_GET['menu_id'];
$publish_one = $_GET['p'];
$publish = $mysqli -> prepare("UPDATE `menu` SET `publish` = ? WHERE `id` = ?");
$publish -> bind_param('ii',$publish_one,$menu_id);
$publish -> execute();
header('Location:../index.php');