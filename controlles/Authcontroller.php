<?php 
class Authcontroller
{

	public function get_login_page(){
		echo $_GET['id'];
		include_once 'html_css/pages/public/auth/auto.php';
		die();
	}

	public function post_login_action(){
		global $mysqli;
		include_once 'public_part/auth/auto.php';
		die();
	}

	public function get_register_page(){
		include_once 'html_css/pages/public/auth/regas.php';
		die();
	}

	public function post_register_action(){
		global $mysqli;
		include_once 'public_part/auth/check_regas.php';
		die();
	}

}


