<?php
	
$page_title = "Voters' List";
require ('./bootstrap.php');
require ('./layout/header.php');
require ('../dbase/db-config.php');

if ($_SESSION['permissions'][5] == false && $_SESSION['permissions'][7] == false)
	echo '<script language=javascript>alert("You do not have permissions to view this page."); window.location.replace("./");</script>';

?>
			<h3><?php echo $page_title; ?></h3>
			<table class='tablelist' cellpadding='8' cellspacing='0'>
				<tr>
					<th>MyKad Number</th>
					<th>Full Name</th>
					<th>OTP Requested?</th>
				</tr>
				<?php
					if ($result = mysqli_query($sql, 'SELECT * FROM votersdb ORDER BY fullname ASC')) {
						while ($row = mysqli_fetch_row($result)) {
							echo '<tr>';
							echo '<td>', $row[0], '</td>';
							echo '<td align="left">', $row[1], '</td>';
							$otpcheck = mysqli_fetch_array(mysqli_query($sql, 'SELECT mykad FROM otp WHERE mykad="'.$row[0].'"'), MYSQLI_NUM);
							if (!empty($otpcheck))
								echo '<td>&#x2714</td>';
							else
								echo '<td>&#x2718</td>';
							echo '</tr>';
						}
					}
				?>
			</table>
<?php require ('layout/footer.php'); ?>