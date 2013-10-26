<?php require_once("includes/initialize.php"); ?>
<?php
	
	$username = $db->real_escape_string($_POST['username']);
	$email = $db->real_escape_string($_POST['email']);
	$password = $db->real_escape_string($_POST['password']);
	$password2 = $db->real_escape_string($_POST['password2']);
	
	$bad_combo = false;
	
	if(empty($username) || empty($email) || empty($password) || empty($password2)){
		redirect_to("index.php");
	}
	
	if($password != $password2){
		$_SESSION['password_match'] = 1;
		$bad_combo = true;
		$_SESSION['username'] = $username;
		$_SESSION['email'] = $email;
	}
	
	if(strlen($password) < 6 || strlen($password) > 15){
		$_SESSION['password_length'] = 1;
		$bad_combo = true;
		$_SESSION['username'] = $username;
		$_SESSION['email'] = $email;
	}
	
	$sql = "SELECT * FROM User WHERE email = '{$email}'";
	$result = $db->query($sql);
	
	if($result->num_rows > 0){
		$_SESSION['email_match'] = 1;
		$bad_combo = true;
	}
	
	$sql = "SELECT * FROM User WHERE username = '{$username}'";
	$result2 = $db->query($sql);
	
	if($result2->num_rows > 0){
		$_SESSION['username_match'] = 1;
		$bad_combo = true;
	}

	if(!ctype_alnum($username)){
		$_SESSION['username_type'] = 1;
		$bad_combo = true;
	}

	if(strlen($username) > 20 || strlen($username) < 1){
		$_SESSION['username_length'] = 1;
		$bad_combo = true;
	}
	
	if($bad_combo){
		redirect_to("index.php");
		die();
	}
	else{
		$user = User::create_user($username, $email, sha1($password));
		
		$session->login($user);
		
		$category = new Category();
		$category->title = "Personal";
		$category->user_id = $session->user_id;
		$category->create();
		
		redirect_to("home.php");
	}
?>