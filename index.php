<?php

$page_title = 'Home';
require ('./bootstrap.php');
require ('./layout/header.php');
	
?>
			<h2>CAMPUS ELECTION SYSTEM</h2>
			<h3>MAIN MENU</h3>
			<br/>
			<table class='tablelist' cellpadding='8' cellspacing='0'>
				<tr>
					<td><br/><a href='./ballotl.php'><img src='images/ballot-box.png' alt='<?php echo 'icon' ?>' height='80' /><p>BALLOT STATION</p></a></td>
					<td><br/><a href='./results.php'><img src='images/chart.png' alt='<?php echo 'icon' ?>' height='80' /><p>LIVE RESULTS</p></a></td>
					<td><br/><a href='./admin/login.php'><img src='images/admin.png' alt='<?php echo 'icon' ?>' height='80' /><p>ADMINISTRATION</p></a></td>
				</tr>
			</table>
<?php require ('./layout/footer.php'); ?>