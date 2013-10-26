<header>
   	<div class="container">
		<div class="row">
			<div class="col-6">
				<h1><a href="index.php" class="banner">Task<span class="text-info">Chomp</span></a></h1>
			</div>
			<div class="col-6">
				<?php if($session->is_logged_in()){ ?>
					<div class="well well-small clearfix menu-outer pull-right logged-in">
						<nav>
						<p class="pull-right">
							<strong><span class="text-muted">Welcome, </span><a href="settings.php" class="username" title="Account Settings"><?php echo $user->username; ?></a> </strong>
							<span class="menu-divider"> | </span>
							<a href="authenticate.php?logout" class="text-muted logout">Logout</a>							
						</p>
						</nav>
					</div>
				<?php } else{ ?>
				<div class="well well-small clearfix menu-outer pull-right">
					<nav>
					<form action="authenticate.php" method="post" class="form-inline login-form">
						<button type="submit" name="login" class="btn btn-info btn-small pull-right">Login</button>
					  
					 	<input type="password" name="password" class="form-control login-txt input-small pull-right" placeholder="Password" tabindex="2">
					  	<input type="email" name="email" class="form-control login-txt input-small pull-right" placeholder="Email" tabindex="1">
					  	
					  	<label class="pull-left remember text-muted">
					      <input name="remember" value="1" type="checkbox" class="check"> Remember me
					    </label>
					</form>
					<a href="forgot_password.php"><small class="pull-right text-muted forgot-password">Forgot your password?</small></a>
					</nav>
					</div>
				<?php } ?>
				
			</div>
		</div><!-- end header row -->
	</div><!-- end header container -->		
</header>
