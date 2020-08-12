<?php
require_once 'router.php';
require_once 'route.php';

$router = new Router($_SERVER['REQUEST_URI']);

// AUTO	
$router -> get('/login_get','Authcontroller@get_login_page');	
$router -> post('/login_post','Authcontroller@post_login_action');	

// REGAS
$router -> get('/register_get','Authcontroller@get_register_page');
$router -> post('/register_post','Authcontroller@post_register_action');

// SEARCH
$router -> post('/serach_post',function(){
	global $mysqli;
	include_once 'public_part/serach.php';
	die();
});

// CHOOSE MENU
$router -> get('/choose_menu',function(){
	global $mysqli;
	include_once 'public_part/choose_menu.php';
	die();
});

// UPDATE MENU
$router -> get('/moderation',function(){
	include_once 'html_css/pages/moderator/update_menuOrcombo.php';
	die();
});

$router -> post('/moderation_post',function(){
	global $mysqli;
	include_once 'admin_part/update_menu.php';
	die();
});

// Create menu
$router -> get('/create_menu',function(){
	global $mysqli;
	include_once 'html_css/pages/moderator/create_menu.php';
	die();
});

$router -> post('/add_order',function(){
	global $mysqli;	
	include_once 'admin_part/add_menu.php';
	die();
});

// CREATE Combo
$router -> get('/create_combo',function(){
    global $mysqli;
	include_once 'html_css/pages/moderator/create_combo.php';
	die();
});

$router -> post('/add_combo',function(){
	global $mysqli;
	include_once 'admin_part/add_combo.php';
	die();
});

// List Users
$router -> get('/list_users',function(){
	global $mysqli;
	include_once 'html_css/pages/moderator/list_users.php';
	die();
});

$router -> get('/order_users',function(){
	global  $mysqli;
	include_once 'html_css/pages/moderator/orders_users.php';
	die();
});

$router -> get('/options_site',function(){
	global $mysqli;
	include_once 'html_css/pages/moderator/options_site.php';
	die();
});


$router -> get('/exit',function(){
	global $mysqli;
	include_once 'public_part/exit_Fromprofile.php';
	die();
});

$router -> get('/see_basket',function(){
	global $mysqli;
	include_once 'html_css/pages/public/see_basket.php';
	die();
});


$router -> get('/see_my_orders',function(){
	global $mysqli;
	include_once 'html_css/pages/public/see_my_orders.php';
	die();
});

// create orders for users
$router -> get('/create_order_users',function(){
	include_once 'html_css/pages/public/createOrder.php';
	die();
});

$router -> post('/create_order_users_post',function(){
	global $mysqli;
	require_once 'public_part/create_orders.php';
	die();
});

// CREATE A TEMPORARY USER
$router -> post('/create_temporary_user',function(){
	global $mysqli;
	include_once 'public_part/create_temporary_user.php';
	die();
});

// remove from basket
$router -> get('/remove_from_basket',function(){
	global $mysqli;
	include_once 'public_part/remove_from_basket.php';
	die();
});


$router -> run();
