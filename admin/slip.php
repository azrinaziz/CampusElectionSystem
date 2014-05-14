<?php

require ('./bootstrap.php');
require ('../include/db-function.php');
require ('../include/parse-function.php');
require ('../dbase/db-config.php');

if (isset($_GET['mykad']) && isset($_GET['otp'])) {
	//echo '<script language=javascript>window.print()</script>';
	$page_title = $_GET['mykad'];
}

?>
<html>
<head>
	<title><?php echo $page_title; ?></title>
	<link href='./report.css' rel='stylesheet' type='text/css' />
</head>
<body>
	<div style='text-align:center;'><img src='../images/cict-logo.png' alt='<?php echo 'Cosmpoint College of Technology' ?>' height='60' /></div>
	<div style='text-align:center;'>
		<p>OTP for <b><?php echo $_GET['mykad']; ?></b> is:</p>
		<p style="font-family:Consolas,'Lucida Console','Courier New',monospace;font-size: 40px;font-weight: bold;"><?php echo $_GET['otp']; ?></p>
		<p>WARNING: Do not reveal this OTP to anyone. Please request new OTP if this slip is missing.</p>
	</div>
</body>
</html>