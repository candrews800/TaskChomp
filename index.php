<?php $page = "Home"; ?>
<?php require_once("includes/initialize.php"); ?>
<?php if($session->is_logged_in()){
	redirect_to("home.php");
}
?>
<?php require_once("layout/header.php"); ?>

<?php
	// Sign Up Details
	
	if(!empty($_SESSION['password_match'])){
		$password_match = 1;
		unset($_SESSION['password_match']);
	}
	
	if(!empty($_SESSION['password_length'])){
		$password_length = 1;
		unset($_SESSION['password_length']);
	}
	
	if(!empty($_SESSION['email_match'])){
		$email_match = 1;
		unset($_SESSION['email_match']);
	}
	
	if(!empty($_SESSION['username_match'])){
		$username_match = 1;
		unset($_SESSION['username_match']);
	}
	
	if(!empty($_SESSION['username_length'])){
		$username_length = 1;
		unset($_SESSION['username_length']);
	}
	
	if(!empty($_SESSION['username_type'])){
		$username_type = 1;
		unset($_SESSION['username_type']);
	}
	
	if(!empty($_SESSION['email'])){
		$email = $_SESSION['email'];
		unset($_SESSION['email']);
	}
	
	if(!empty($_SESSION['username'])){
		$username = $_SESSION['username'];
		unset($_SESSION['username']);
	}
?>

<?php echo $session->get_msg(); ?>

<div class="jumbotron">
      <div class="container">
        <h1>Organize it. <span class="text-info">Chomp it.</span></h1>
        <p>TaskChomp brings order to your chaotic life. Whether you are managing a complex project with multiple intermediate steps or needing a simple chore list for the day, TaskChomp is your solution.</p>
      </div>
    </div>
    
    <div class="container">
      <div class="row">
      	<div class="col-lg-8">
      		<div class="row">
		        <div class="col-lg-6 mkt-item">
		          <h2>Categories</h2>
		          <p>Use TaskChomp's category system to organize lists to your liking. Create your own categories for work, chores around the house, or anything else your heart desires.</p>
		        </div>
		        <div class="col-lg-6 mkt-item">
		          <img src="imgs/categories.gif" class="img-thumbnail">
		        </div>
        		<div class="col-lg-6 mkt-item">
        			<h2>Subtasks</h2>
          			<p>Want to get into the nitty gritty for all your tasks? With TaskChomp, you're given the ability to not only add subtasks to items in your lists but also update their individual status.</p>
        		</div>
        		<div class="col-lg-6 mkt-item">
        			<img src="imgs/sub-items.gif" class="img-thumbnail">
        		</div>
        	</div>
        </div>
        <div class="col-lg-4 panel panel-info">
          <div class="panel-heading text-center">
          	<h2 class="panel-title">Sign Up in Seconds</h2>
          	</div>
          	<div class="panel-body">
          <form action="signup.php" method="post" class="form-horizontal">
          	<div class="form-group <?php if(isset($username_match) || isset($username_length) || isset($username_type)){ echo "has-error"; }?>">
			  <label class="col-lg-5 control-label">Username</label>
			  <div class="col-lg-7">
			    <input type="text" name="username" class="form-control input-small" placeholder="Username" value="<?php if(isset($username)){echo $username; }?>" required>
			    <?php if(isset($username_match)){ ?>
				<span class="help-block text-center text-danger">Username already exists.</span>
				<?php } ?>
				<?php if(isset($username_length)){ ?>
				<span class="help-block text-center text-danger">Must be 1-20 characters.</span>
				<?php } ?>
				<?php if(isset($username_type)){ ?>
				<span class="help-block text-center text-danger">Must be A-Z or 0-9 characters.</span>
				<?php } ?>
			  </div>
			   
			</div>
          	
          	<div class="form-group <?php if(isset($email_match)){ echo "has-error"; }?>">
			  <label class="col-lg-5 control-label">Email Address</label>
			  <div class="col-lg-7">
			    <input type="email" name="email" class="form-control input-small" placeholder="Email" value="<?php if(isset($email)){echo $email; }?>" required>
			    <?php if(isset($email_match)){ ?>
			  <span class="help-block text-center text-danger">Email already exists.</span>
			  <?php } ?>
			  </div>
			  
			  
			</div>
			<div class="form-group <?php if(isset($password_match) || isset($password_length)){ echo "has-error"; }?>">
			  <label class="col-lg-5 control-label">Password</label>
			  <div class="col-lg-7">
			    <input type="password" name="password" class="form-control input-small" placeholder="Password" required>
			  </div>
			  <?php if(isset($password_length)){ ?>
			  <span class="help-block text-center text-danger">Must be 6-15 characters.</span>
			  <?php } ?>
			</div>
			
			<div class="form-group <?php if(isset($password_match) || isset($password_length)){ echo "has-error"; }?>">
			  <label class="col-lg-5 control-label">Verify Password</label>
			  <div class="col-lg-7">
			    <input type="password" name="password2" class="form-control input-small" placeholder="Verify Password" required>
			  </div>
			  <?php if(isset($password_match)){ ?>
			  <span class="help-block text-center text-danger">Passwords do not match.</span>
			  <?php } ?>			  
			</div>
          
          	<input type="submit" value="Register" class="btn btn-success pull-right" />
          </form>
          </div>
        </div>
      </div>

     
    </div> <!-- /container -->

<?php require_once("layout/footer.php"); ?>