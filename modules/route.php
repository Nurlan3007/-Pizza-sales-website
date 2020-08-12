<?php 
class Route
{
	private $path;
	private $action;
	public function __construct($path,$action){
		$this -> path = $path;
		$this -> action = $action;
	}

	public function GetNameFilesFromDirectory($path){
		$dir = $path; 
		if(is_dir($dir)) {
		     $files = scandir($dir); 
		     array_shift($files); 
		     array_shift($files);
		     return $files;
		}else {
			echo "{$dir} -такой директории нет";
			return false;
		}
	}

	public function match($uri){
		// echo $uri.'<br>';
		// echo $this -> path;
		if($uri == $this->path){
			// echo "{$uri}Good";
			return True;
		}else{
			// echo 'Bad';
			return false;
		}
	}

	public function call(){
		//function
		// controller
		if(is_string($this -> action)){
			$controlleFiles = $this -> GetNameFilesFromDirectory('controlles/');
			foreach ($controlleFiles as $file) 
				include_once 'controlles/'.$file;
			$segments = explode('@',$this->action);
			$object = new $segments[0]();
			call_user_func([$object,$segments[1]]);
		}else{
			call_user_func($this->action);
		}
	}	
}







