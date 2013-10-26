<?php $page = "Home"; ?>
<?php require_once("includes/initialize.php"); ?>
<?php if($session->is_logged_in()){
	redirect_to("home.php");
}
?>
<?php if(!empty($_POST['email'])){
	$email = $_POST['email']; 

	$user = User::user_exists($email);
	
	$url = "http://taskchomp.com/password_recovery.php?email={$email}&key=" . $user[0]->password;
	
	$to = $email;
	$subject = "Password Recovery - TaskChomp.com";
	$message = "Greetings, " . $user[0]->username . "\r\n \r\n";
	$message.= "Please click the following link and fill out the form to reset your password. \r\n";
	$message.= $url . "\r\n \r\n";
	$message.= "Sincerely, \r\nThe TaskChomp Team";
	
	$headers = 'From: donotreply@taskchomp.com' . "\r\n" .
    'Reply-To: webmaster@taskchomp.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
	
	mail($to, $subject, $message, $headers);
}?>
<?php require_once("layout/header.php"); ?>

<div class="container">
<div class="row">

	<div class="col-lg-2 forgot-back">
		<h4><a href="index.php"><?php icon("chevron-left"); ?> Back to Home</a></h4>
	</div>

<div class="col-lg-9">
	<?php if(isset($email)){ ?>
		<div class="alert alert-success alert-dismissable ">
  			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  			An email has been sent to <strong><?php echo $email; ?></strong> with instructions on retrieving your password.
		</div>
    <?php } ?>
	<div class="panel panel-info account-settings-panel clearfix">
	
	<div class="panel-heading">Forget your password?</div>

	<form class="form-inline" method="post" action="forgot_password.php">
	  <div class="form-group forgot-email pull-left">
	    <label>Enter your Email address:</label>
	    <input type="email" name="email" class="form-control" placeholder="Enter email">
	  </div>
	
	  <button type="submit" class="btn btn-success pull-right">Get Password</button>
	</form>
</div>
</div>
</div>
</div>

<?php require_once("layout/footer.php"); ?>