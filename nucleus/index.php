<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="Amit Bhola">
		<title>Amit Bhola</title>
		<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="../css/font-awesome.min.css" rel="stylesheet" media="screen">
		<link rel='stylesheet' href='../css/normalize.css' type='text/css'>
	</head>
	
	<body>
		
		<?php include '../navbar.php' ?>
		
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<form class="form-signin" action="auth.php" method="post">
						<h2 class="form-signin-heading">Please sign in</h2>
						<label for="uname" class="sr-only">Username</label>
						<input type="text" id="uname" name="uname" class="form-control" placeholder="Username" required autofocus>
						<br>
						<label for="pwd" class="sr-only">Password</label>
						<input type="password" id="pwd" name="pwd" class="form-control" placeholder="Password" required>
						<br>
						<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
					</form>
				</div>
			</div>
		</div>
		
		<br><br><br>
		
		<script type='text/javascript' src='../js/jquery.js'></script>
		<script src="../js/bootstrap.min.js" type="text/javascript"></script> 
		<!--[if lt IE 9]>
			<script src="js/ie.js"></script>
		<![endif]-->
	</body>
</html>