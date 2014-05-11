<?php

$page_title = 'OTP Prompt';
require ('./bootstrap.php');
require ('./layout/header.php');
require ('./dbase/db-config.php');
require ('./include/otp-function.php');
require ('./include/parse-function.php');

if (!isset($_SESSION['voters']))
	header('location: ./ballotl.php');

?>
			<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST' autocomplete='off'>
				<br/>
				<h1>Welcome, <?php echo parse_name($_SESSION['voters'], $sql); ?>.</h1>
				<h2>Please enter your provided OTP number and click the 'Check' button to continue.</h2>
				<input class='textbox' type='password' maxlength='8' name='otp' size='30' placeholder='One-Time-Password' />
				<br/><br/>
				<p><input class='button' type='submit' value='Check' /></p>
			</form>
			<?php
			
				if (isset($_POST['otp'])) {
					$otpstatus = otp_check($_SESSION['voters'], $_POST['otp'], $sql);
					if ($otpstatus[0] == true)
						header('location: ./ballotc.php');
					else if ($otpstatus[0] == false) {
						if ($otpstatus[1] == true)
							echo '<script language=javascript>alert("You have entered an invalid OTP, please re-enter correct password or request new OTP from the election officer.");</script>';
						else
							echo '<script language=javascript>alert("You have not requested the OTP from the election officer.");</script>';
					}
				}
				require ('layout/footer.php');
			
			?>