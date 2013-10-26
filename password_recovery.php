<?php $page = "Home"; ?>
<?php require_once("includes/initialize.php"); ?>
<?php if($session->is_logged_in()){
	redirect_to("home.php");
}
?>
<?php 
	$disabled = "";
	if(!empty($_GET['email']) && !empty($_GET['key'])){
		$email = $_GET['email']; 
		$key = $_GET['key']; 
	
		$user = User::user_exists($email);
		
		if(!($user[0]->password == $key)){
			redirect_to("forgot_password.php");
			die();
		}
		if(!empty($_POST['password']) && !empty($_POST['password2'])){
			$password = $_POST['password'];
			$password2 = $_POST['password2'];
			
			if(strlen($password) < 6 || strlen($password) > 15){
				$message = "Passwords must be 6-15 characters in length. Try again.";
			}
			
			elseif($password == $password2){
				$message = "Password Successfully Changed.";
				$user[0]->password = sha1($password);
				$user[0]->update();
				$disabled = "disabled";
			}
			else{
				$message = "Passwords do not match. Try again.";
			}
		}
	}
	else{
		redirect_to("forgot_password.php");
		die();
	}
?>
<?php require_once("layout/header.php"); ?>

<div class="container">
<div class="row">

	<div class="col-lg-2 forgot-back">
		<h4><a href="index.php"><?php icon("chevron-left"); ?> Forgot Password</a></h4>
	</div>

<div class="col-lg-9 panel panel-info account-settings-panel ">
	<?php if(isset($message)){ ?>
		<div class="alert alert-warning alert-dismissable">
  			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  			<?php echo $message; ?>
		</div>
    <?php } ?>
	<div class="panel-heading">Password Recovery</div>

	<form class="form-inline" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	  <div class="form-group forgot-email pull-left">
	    <label>Password:</label>
	    <input type="password" name="password" class="form-control" placeholder="Password" <?php echo $disabled; ?>>
	  </div>
	
		<div class="form-group forgot-email pull-left clear-fix">
	    <label>Confirm Password:</label>
	    <input type="password" name="password2" class="form-control" placeholder="Confirm Password" <?php echo $disabled; ?>>
	  </div>
		
	  <button type="submit" class="btn btn-success pull-right reset-pw" <?php echo $disabled; ?>>Reset Password</button>
	</form>
</div>
</div>
</div>

<?php require_once("layout/footer.php"); ?>