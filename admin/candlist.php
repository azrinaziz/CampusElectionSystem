<?php
	
$page_title = "Candidates' List";
require ('./bootstrap.php');
require ('./layout/header.php');
require ('../dbase/db-config.php');

if ($_SESSION['permissions'][4] == false && $_SESSION['permissions'][7] == false)
	echo '<script language=javascript>alert("You do not have permissions to view this page."); window.location.replace("./");</script>';

?>
			<h3><?php echo $page_title; ?></h3>
			<table class='tablelist' cellpadding='8' cellspacing='0'>
				<tr>
					<th>MyKad Number</th>
					<th>Full Name</th>
					<th>Contested Office</th>
					<th>Candidate's Picture</th>
				</tr>
				<?php
				
					if ($result = mysqli_query($sql, 'SELECT candidates.id, candidates.mykad, votersdb.fullname, office.officename, candidates.photopath FROM candidates INNER JOIN votersdb ON votersdb.mykad=candidates.mykad INNER JOIN office ON office.officeid=candidates.officeid ORDER BY votersdb.fullname ASC')) {
						while ($row = mysqli_fetch_row($result)) {
							echo '<tr>';
							echo '<td>', $row[1], '</td>';
							echo '<td style="text-align:justify;">', $row[2], '</td>';
							echo '<td>', $row[3], '</td>';
							echo '<td><img src=".', $row[4], '" alt="" height="150" /></td>';
							echo '</tr>';
						}
					}
					
				?>
			</table>
<?php require ('layout/footer.php'); ?>