<?php

	require ('./bootstrap.php');
	require ('../dbase/db-config.php');
	require ('../include/otp-function.php');
	require ('../include/parse-function.php');
	
	if (isset($_GET['logout']) && $_GET['logout'] == 1) {
		session_destroy();
		header('location: ../');
	}
	
	if (isset($_GET['error']) && $_GET['error'] == 0)
		$error = 'Access denied, please try again.';
		
	if (isset($_GET['error']) && $_GET['error'] == 1)
		$error = 'Please login to continue.';
		
	if (isset($_POST['mykad']) && isset($_POST['password'])) {
		if (password_check($_POST['mykad'], $_POST['password'], $sql) == true) {
			$_SESSION['mykad'] = $_POST['mykad'];
			$_SESSION['permissions'] = parse_permissions_output($_POST['mykad'], $sql);
			header('location: ./');
		}
		else
			header('location: ./login.php?error=0');
	}
	
?>
<html>
<head>
	<title>Login Page | CES Administrator</title>
	<link href='./site.css' rel='stylesheet' type='text/css' />
</head>
<body>
	<div id='loginform'>
		<div id='logobox'>
			<img src='../images/cict-logo.png' alt='<?php echo 'Cosmpoint College of Technology' ?>' height='40' />
		</div>
		<h2>Campus Election System</h2>
		<p>Administration Center</p>
		<div id='loginbox'>
			<?php
			
				if (isset($error))
					echo '<div id="errorbox"><p><b>ERROR: </b>', $error, '</p></div><br/>';
					
			?>
			<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST' autocomplete="off">
				<p>MyKad Number</p>
				<p><input class='logintextbox' type='number' name='mykad' /></p><br/>
				<p>Password</p>
				<p><input class='logintextbox' type='password' name='password' /></p><br/>
				<p><input class='loginbutton' type='submit' value='Log In' /></p>
			</form>
		</div>
	</div>
</body>
</html>