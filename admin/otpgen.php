<?php
	
$page_title = 'OTP Generator';
require ('./bootstrap.php');
require ('./layout/header.php');
require ('../dbase/db-config.php');
require ('../include/common-function.php');
require ('../include/otp-function.php');

if ($_SESSION['permissions'][1] == false && $_SESSION['permissions'][7] == false)
	echo '<script language=javascript>alert("You do not have permissions to view this page."); window.location.replace("./");</script>';
	
set_office_list($sql);

?>
			<h3><?php echo $page_title; ?></h3>
			<center><form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST'>
				<table cellpadding='10' cellspacing='0'>
					<tr>
						<td><input class='logintextbox' type='number' maxlength='12' name='mykad' size='30' placeholder='MyKad Number' /></td>
						<td><p><input class='loginbutton' type='submit' value='Generate' /></p></td>
					</tr><tr>
						<td colspan='2' style='text-align:center;'><label><input type='checkbox' name='slip' value='slip' />Print OTP slip</label><br/></td>
					</tr>
				</table>
			</form>
			<?php
			
				if (isset($_POST['mykad'])) {
					if (check_mykad($_POST['mykad'], $sql) == true) {
						set_vote_status($_POST['mykad'], $_SESSION['officelist'], $sql);
						if (count(array_filter($_SESSION['voted'])) == count($_SESSION['voted']))
							echo '<script language=javascript>alert("The owner of this MyKad number is already voted."); window.location.replace("', $_SERVER['PHP_SELF'], '");</script>';
						else {
							$otp = otp($_POST['mykad'], $sql);
							if ($otp == false)
								echo '<script language=javascript>alert("The system is unable to generate the OTP. Please try again later."); window.location.replace("', $_SERVER['PHP_SELF'], '");</script>';
							else
								if (isset($_POST['slip']) && $_POST['slip'] == 'slip')
									echo "<script language=javascript>window.open('./slip.php?mykad=", $_POST['mykad'], "&otp=$otp', '_blank', 'toolbar=no, scrollbars=no, resizable=no, top=100, left=400, width=500, height=250');</script>";
								else
									echo '<table class="box" cellpadding="0" cellspacing="0"><tr><td><p>OTP generated for <b>', $_POST['mykad'], "</b> is:</p><h1>$otp</h1><p>Please write down the OTP before regenerating OTP for others.</p></td></tr></table><br/>";
						}
					}
					else
						echo '<script language=javascript>alert("Your input is invalid, please re-enter the correct MyKad number.");</script>';
				}
			?>
			
			</center>
<?php require ('./layout/footer.php'); ?>