<html>
<head>
	<title><?php echo $page_title; ?> | CES Administrator</title>
	<link href='./site.css' rel='stylesheet' type='text/css' />
</head>
<body>
	<div id='container'>
		<div id='left'>
			<div id='logo'>
				<a href='./'><img src='../images/cict-logo.png' alt='<?php echo 'Cosmpoint College of Technology' ?>' height='30' /></a>
				<p><b>CES ADMINISTRATION</b></p>
			</div>
			<div id='navigation'>
				<ul>
					<li><a href='./'>Home</a></li>
					<?php //<li><a href="#">Your Profile</a></li> ?>
					<?php
					
						if ($_SESSION['permissions'][1] == true || $_SESSION['permissions'][7] == true)
							echo '<li><a href="./otpgen.php">OTP Generator</a></li>';
						
						if ($_SESSION['permissions'][2] == true || $_SESSION['permissions'][7] == true)
							echo '<li><a href="./regcand.php">Register Candidates</a></li>';
							
						if ($_SESSION['permissions'][3] == true || $_SESSION['permissions'][7] == true)
							echo '<li><a href="./regvoters.php">Register Voters</a></li>';
							
						if ($_SESSION['permissions'][4] == true || $_SESSION['permissions'][7] == true)
							echo "<li><a href='./candlist.php'>Candidates' List</a></li>";
							
						if ($_SESSION['permissions'][5] == true || $_SESSION['permissions'][7] == true)
							echo "<li><a href='./voterslist.php'>Voters' List</a></li>";
							
						if ($_SESSION['permissions'][6] == true || $_SESSION['permissions'][7] == true)
							echo '<li><a href="./supervisor.php">Supervisor</a></li>';
					
					?>
					<li><a href="./login.php?logout=1">Logout</a></li>
				</ul>
			</div>
		</div>
		<div id='right'>