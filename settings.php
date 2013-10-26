<?php $page = "Settings"; ?>
<?php require_once("includes/initialize.php"); ?>
<?php require_once("layout/header.php"); ?>
<?php if(!$session->is_logged_in()){
	redirect_to("index.php");
}
?>

<?php

	if(!empty($_GET['field'])){
		$field = $_GET['field'];
		
		switch($field){
			case "email":
				$field_text = "Email";
				$inp_type = "email";
				break;
			case "username":
				$field_text = "Username";
				$inp_type = "text";
				break;
			case "password":
				$field_text = "Password";
				$inp_type = "password";
				break;
		}
	}

?>

<div class="container">
<div class="row">
<?php if(empty($_GET['field'])){ ?>
<div class="col-lg-2 settings-back">
	<h4><a href="home.php"><?php icon("chevron-left"); ?> Back to Tasks</a></h4>
</div>

<div class="col-lg-8 panel panel-info account-settings-panel ">
	<?php
		if(!empty($_SESSION['confirm'])){
	?>	
	
		<div class="alert alert-success alert-dismissable">
  			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  			<?php echo $_SESSION['confirm']; ?>
		</div>
		
	<?php	
			unset($_SESSION['confirm']);
		}
	?>
	<div class="panel-heading">Account Settings </div>
	
    <ul class="list-group">
	    <li class="list-group-item clearfix">Username: <strong><?php echo $user->username; ?></strong><a href="settings.php?field=username" class="btn btn-mini btn-info pull-right"><strong>Modify Username</strong></a></li>
	    <li class="list-group-item clearfix">Email: <strong><?php echo $user->email; ?></strong><a href="settings.php?field=email" class="btn btn-mini btn-info pull-right"><strong>Modify Email</strong></a></li>
	    <li class="list-group-item clearfix"><a href="settings.php?field=password" class="btn btn-small btn-success pull-right btn-block"><strong>Update Password</strong></a></li>
	</ul>
</div>
</div>
<?php } ?>
<?php if(isset($field)){ ?>
	<div class="col-lg-2 settings-back">
	<h4><a href="settings.php"><?php icon("chevron-left"); ?> Back to Settings</a></h4>
</div>

<div class="col-lg-8">
	<?php
		if(!empty($_SESSION['match'])){
	?>	
	
		<div class="alert alert-danger alert-dismissable">
  			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  			<?php echo $_SESSION['match']; ?>
		</div>
		
	<?php	
			unset($_SESSION['match']);
		}
	?>
	<div class="panel panel-info account-settings-panel clearfix">
	
	<div class="panel-heading">Modify <?php echo $field_text; ?></div>
	<form action="update_settings.php" method="post">
	  <div class="form-group clearfix">
	    <label class="col-lg-3 control-label"><?php echo $field_text; ?></label>
	    <div class="col-lg-6">
	      <input name="<?php echo $field; ?>" type="<?php echo $inp_type; ?>" class="form-control" placeholder="<?php echo $field_text; ?>">
	    </div>
	  </div>
	  <div class="form-group clearfix">
	    <label class="col-lg-3 control-label">Confirm <?php echo $field_text; ?></label>
	    <div class="col-lg-6">
	      <input name="<?php echo $field; ?>2" type="<?php echo $inp_type; ?>" class="form-control" placeholder="Confirm <?php echo $field_text; ?>">
	    </div>
	  </div>
	  <div class="form-group">
	    <div class="col-lg-offset-4 col-lg-2">
	      <button type="submit" class="btn btn-info">Save <?php echo $field_text; ?></button>
	    </div>
	  </div>
	</form>
	</div>
</div>
</div>
<?php } ?>
</div>
<?php require_once("layout/footer.php"); ?>