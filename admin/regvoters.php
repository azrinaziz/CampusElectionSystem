<?php
	
$page_title = "Voter's Registration Form";
require ('./bootstrap.php');
require ('./layout/header.php');
require ('../dbase/db-config.php');
require ('../include/common-function.php');
require ('../include/otp-function.php');

if ($_SESSION['permissions'][3] == false && $_SESSION['permissions'][7] == false)
	echo '<script language=javascript>alert("You do not have permissions to view this page."); window.location.replace("./");</script>';

?>
			<h3><?php echo $page_title; ?></h3>
<?php

	if (!empty($_POST['mykad']) && !empty($_POST['fullname'])) {
		if (check_mykad($_POST['mykad'], $sql) == false) {
			if (check_mykad_validity($_POST['mykad']) == true) {
				$insertvoters = mysqli_query($sql, "INSERT INTO votersdb (mykad, fullname) VALUES ('".$_POST['mykad']."', '".strtoupper($_POST['fullname'])."')");
				if ($insertvoters == true)
					if (!empty($_POST['otpgen'])) {
						$otp = otp($_POST['mykad'], $sql);
						if ($otp == false)
							echo '<script language=javascript>alert("The registration is successful but the system could not generate the OTP. Please try again later."); window.location.replace("', $_SERVER['PHP_SELF'], '");</script>';
						else
							echo '<table class="box" cellpadding="0" cellspacing="0"><tr><td><p>The registration is successful and the OTP generated for <b>', strtoupper($_POST['fullname']), "</b> is:</p><h1>$otp</h1><p>Please write down the OTP before starting a new registration.</p></td></tr></table><br/>";
					}
					else
						echo '<script language=javascript>alert("The registration is successful!"); window.location.replace("', $_SERVER['PHP_SELF'], '");</script>';
				else
					echo '<script language=javascript>alert("The system had encountered one or more errors. Please try again later."); window.location.replace("', $_SERVER['PHP_SELF'], '");</script>';
			}
			else
				echo '<script language=javascript>alert("MyKad number is invalid, please re-enter."); window.location.replace("', $_SERVER['PHP_SELF'], '");</script>';
		}
		else
			echo '<script language=javascript>alert("This MyKad number is already registered."); window.location.replace("', $_SERVER['PHP_SELF'], '");</script>';
	}

?>
			<div class='form'>
				<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST'>
					<table class='formtable' cellpadding='20' cellspacing='0'>
						<tr>
							<td>MyKad Number*:</td>
							<td><input class='textboxform' type='number' maxlength='12' name='mykad' size='20' placeholder='MyKad Number' tabindex='1' /></td>
						</tr><tr>
							<td>Full Name*:</td>
							<td><input class='textboxform' type='text' maxlength='100' name='fullname' size='50' placeholder='Full Name' tabindex='2' /></td>
						</tr><tr>
							<td>Task(s):</td>
							<td><input type='checkbox' name='otpgen' value='otpgen' tabindex='3' checked />Generate OTP</td>
						</tr><tr>
							
							<td colspan='2'>* Indicates required field.</td>
						</tr>
					</table>
					<p><input class='button' type='submit' value='Register' tabindex='4' /></p>
				</form>
			</div>
<?php require ('./layout/footer.php'); ?>