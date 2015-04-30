<?php
	
class App 
{
	protected $controller = 'home';
	protected $method = 'index';
	protected $params = [];
	
	public function __construct()
	{
		//parse the url
		$url = $this->parseUrl();
		
		//if controller ($url[0]) exist in file. 
		if(file_exists('../app/controllers/' . $url[0] . '.php')) {
			//set class's controller to that controller from url
			$this->controller = $url[0];
			
			//remove first item from array
			unset($url[0]);
		}
		
		//add in the implementation file of the controller
		//require it here so we only require the controller file we want instead of requiring all controller files at the top
		require_once '../app/controllers/' . $this->controller . '.php';
		
		//convert controller to an object
		$this->controller = new $this->controller;
		
		//check to see if method is in url. Note url[1] is checked because unset removes the element but doesn't not reset the base key
		if(isset($url[1])) {
			//check to see if method is in a class object (controller)
			if(method_exists($this->controller, $url[1])) {
				$this->method = $url[1];
				unset($url[1]);
			}
		}
		
		//if url is not empty. rebase the url and set it to param
		$this->params = $url ? array_values($url) : [];
		call_user_func_array([$this->controller, $this->method], $this->params);
	}
	
	//get the url. cut the last /, filter off weird characters, explode elements separated by / into array. First element should be controller, 2nd element action, 3rd+ elements are parameters
	public function parseUrl() {
		if(isset($_GET['url'])) {
			return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
		}
	}
}
	
?>