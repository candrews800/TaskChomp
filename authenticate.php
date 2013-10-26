<?php
require_once("includes/initialize.php");

if(isset($_POST['login'])){
	if(isset($_POST['email']) && isset($_POST['password'])){
		$user = new User();
		$email = $_POST['email'];
		$password = sha1($_POST['password']);
		$valid = $user->authenticate($email, $password);
		if($valid && isset($_POST['remember'])){
			setcookie("email", $email, time()+3600*24*30);
			setcookie("key", $password, time()+3600*24*30);
		}
		header('Location: ' . 'home.php');
	}
}
if(isset($_GET['logout'])){
	$session->logout();
	setcookie("email", "", time()-3600);
	setcookie("key", "", time()-3600);
	header('Location: ' . 'index.php');
}
