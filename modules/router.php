<?php 
class Router
{
	private $uri;
	private $routes = [];

	function __construct($uri)
	{
		$this->uri = parse_url($uri, PHP_URL_PATH);
	}

	public function get($get,$action){
		$route = new Route($get,$action);
		// print_e($route);
		$this -> routes['GET'][] = $route;
		// print_e($routes);

	}

	public function post($post,$action){
		$route = new Route($post,$action);
		$this -> routes['POST'][] = $route;
	}

	public function run(){
		if(!isset($this -> routes[$_SERVER['REQUEST_METHOD']])){
			echo ':(';
			return false;
		}
		// echo $_SERVER['REQUEST_METHOD'];
		foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
			// print_e($route);
			if($route->match($this->uri)){
				$route->call();
				return True;
			}
		}
		echo 'Error 404';	
		return false;
		
	}
}



