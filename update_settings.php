<?php require_once("includes/initialize.php");

if(!$session->is_logged_in()){
	redirect_to("index.php");
	die();
}
else{	
	if(isset($_POST['password'])){
		
		if(strlen($_POST['password']) < 6 || strlen($_POST['password']) > 15){
			$_SESSION['match'] = "Passwords must be 6-15 characters in length.";
			redirect_to("settings.php?field=password");
			die();
		}
		elseif($_POST['password'] == $_POST['password2']){
			$user->password = sha1($_POST['password']);
			$user->update();
			$_SESSION['confirm'] = "Password successfully changed.";
			redirect_to("settings.php");
		}
		else{
			$_SESSION['match'] = "Passwords do not match.";
			redirect_to("settings.php?field=password");
			die();
		}
	}
	
	else if(isset($_POST['username'])){
		$username = $db->real_escape_string($_POST['username']);
		
		if($_POST['username'] == $_POST['username2']){
			$sql = "SELECT * FROM User WHERE username = '{$username}'";
			$result = $db->query($sql);
			
			if($result->num_rows > 0){
				$_SESSION['match'] = "Username: <strong>" . $username . "</strong> already exists.";
				redirect_to("settings.php?field=username");
				die();
			}
			else{
				$user->username = $username;
				$user->update();
				$_SESSION['confirm'] = "Username successfully changed.";
				redirect_to("settings.php");
			}
		}
		else{
			$_SESSION['match'] = "Usernames do not match.";
			redirect_to("settings.php?field=username");
			die();
		}
	}
	
	else if(isset($_POST['email'])){
		$email = $db->real_escape_string($_POST['email']);
		$sql = "SELECT * FROM User WHERE email = '{$email}'";
		$result = $db->query($sql);
		
		if($result->num_rows > 0){
			$_SESSION['match'] = "Email: <strong>" . $email . "</strong> already exists.";
			redirect_to("settings.php?field=email");
			die();
		}
		
		if($_POST['email'] == $_POST['email2']){
			$user->email = $email;
			$user->update();
			$_SESSION['confirm'] = "Email successfully changed.";
			redirect_to("settings.php");
		}
		else{
			$_SESSION['match'] = "Emails do not match.";
			redirect_to("settings.php?field=email");
			die();
		}
	}
		
}

?>
	