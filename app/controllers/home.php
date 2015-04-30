<?php
	
class Home extends Controller{
	public function index($name = '', $name2 = ''){
		$user = $this->model('user');
		$user->name = $name;
		
		$this->view('home/index', ['name' => $user->name]);
	}
	
	public function test() {
		echo 'home/test';
	}
}
?>