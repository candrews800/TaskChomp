<?php
// This initializes all classes and functions

require_once("classes/Session.php");
require_once("classes/Database.php");

require_once("functions.php");
require_once("status_functions.php");

require_once("classes/DatabaseObject.php");
require_once("classes/User.php");

require_once("classes/Category.php");
require_once("classes/TaskList.php");
require_once("classes/Item.php");
require_once("classes/SubItem.php");

if(!empty($_COOKIE['email']) && !empty($_COOKIE['key']) && !$session->is_logged_in()){
	$email = $_COOKIE['email'];
	$key = $_COOKIE['key'];
	$user_array = User::user_exists($email);
	
	$user = User::find_by_id($user_array[0]->id);

	if($user->password == $key){
		$session->login($user);
	}
	
}

if($session->is_logged_in() && !isset($user)){
	$user = User::find_by_id($_SESSION['user_id']);
}

?>