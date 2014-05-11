<?php

$page_title = 'Ballot Login';
require ('./bootstrap.php');
require ('./layout/header.php');
require ('./dbase/db-config.php');
require ('./include/common-function.php');
require ('./include/db-function.php');

if (check_candidate($sql) == false)
	echo '<script language=javascript>window.location.replace("'.$_SERVER['REQUEST_URI'].'");</script>';

if (isset($_SESSION['voters']) || isset($_SESSION['voted']) || isset($_SESSION['officelist']))
	$_SESSION = array();

set_office_list($sql);

?>
			<br/>
			<h1>Welcome to the Campus Election System (CES)</h1>
			<?php
			
				if (check_candidate($sql) == false) {
					echo '<h2>The ballot box is currently closed.</h2>';
					header('Refresh: 10; URL = '.$_SERVER['REQUEST_URI']);
				}
				else {
				
			?>
			<h2>Please enter your MyKad number and click the 'Check' button to continue.</h2>
			<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST'>
				<input class='textbox' type='number' maxlength='12' name='mykad' size='30' placeholder='MyKad Number' />
				<p>Example: 881210223333
				<p>Please make sure you have already obtained the One-Time-Password (OTP) before voting from our authorised election officer.</p>
				<p><input class='button' type='submit' value='Check' /></p>
			</form>
			<?php
			
				}
				if (isset($_POST['mykad'])) {
					if (check_mykad($_POST['mykad'], $sql) == true) {
						set_vote_status($_POST['mykad'], $_SESSION['officelist'], $sql);
						if (count(array_filter($_SESSION['voted'])) == count($_SESSION['voted'])) {
							session_destroy();
							echo '<script language=javascript>alert("You have already finished voting. Thank you."); window.location.replace("'.$_SERVER['REQUEST_URI'].'");</script>';
						}
						else {
							$_SESSION['voters'] = $_POST['mykad'];
							header('location: ./otpprompt.php');
						}
					}
					else
						echo '<script language=javascript>alert("Your input is invalid, please re-enter the correct MyKad number.");</script>';
				}
				require ('./layout/footer.php');
				
			?>