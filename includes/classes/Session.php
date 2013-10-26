<?php

class Session{

	private $logged_in = false;
	public $user_id;
	
	private $msg = "";

	public function __construct(){
		session_start();
		
		$this->logged_in = $this->check_login();
	}
	
	public function login($user){
		$this->logged_in = true;
		$this->user_id = $user->id;
		$_SESSION['user_id'] = $user->id;
	}
	
	public function logout(){
		unset($_SESSION['user_id']);
		unset($this->user_id);
		$this->logged_in = false;
	}
	
	public function is_logged_in(){
		return $this->logged_in;
	}
	
	public function check_login(){
		if(isset($_SESSION['user_id'])){
			$this->logged_in = true;
			$this->user_id = $_SESSION['user_id'];
			return true;
		}
		else{
			unset($this->user_id);
			return false;
		}
	}
	public function set_msg($msg){
		$this->msg = $msg;
		$_SESSION['msg'] = $msg;
	}
	public function get_msg(){
		if(isset($_SESSION['msg'])){
			$this->msg = $_SESSION['msg'];
			unset($_SESSION['msg']);
			return $this->msg;
		}
		return false;
	}
}

$session = new Session();

?>