<?php

$page_title = 'Ballot Center';
require ('./bootstrap.php');
require ('./layout/header.php');
require ('./dbase/db-config.php');
require ('./include/common-function.php');
require ('./include/db-function.php');
require ('./include/parse-function.php');

if (!isset($_SESSION['voters']) || !isset($_SESSION['voted']))
	header('location: ./ballotl.php');
	
if (isset($_GET['votestatus'])) {
	if ($_GET['votestatus'] == 0)
		echo '<script language=javascript>alert("Your vote is successfully submitted. Please vote for the next category (if applicable).");</script>';
	else if ($_GET['votestatus'] == 1)
		echo '<script language=javascript>alert("The system had encountered one or more errors. Please try again later.");</script>';
	else if ($_GET['votestatus'] == 2)
		echo '<script language=javascript>alert("Your have already voted for this category.");</script>';
}

set_office_list($sql);
set_vote_status($_SESSION['voters'], $_SESSION['officelist'], $sql);
	
if (count(array_filter($_SESSION['voted'])) == count($_SESSION['voted']))
	echo '<script language=javascript>window.location.replace("./finished.php");</script>';

?>
			<h3><?php echo $page_title; ?></h3>
			<p><b>INSTRUCTIONS:</b> Click the candidate's picture to vote.</p>
			<?php
				
				$isize = count($_SESSION['officelist']);
				for ($i=1; $i<=$isize ; $i++) {
					$res = all_candidates($i, $sql, false);
			
			?>
			<table class='tablelist' cellpadding='8' cellspacing='0'>
				<?php
					
					echo '<tr>';
					echo '<td colspan="', count($res),'"><b>', parse_office($i, $sql), ' CANDIDATE</b></td>';
					echo '</tr><tr>';
					foreach ($res as $value)
						echo '<th>', $value[1];
					echo '</tr><tr>';
					foreach ($res as $value)
						echo '<td><a href="./ballotp.php?vote=', $value[0], '"><img src="', $value[2], '" alt="', $value[1], '" height="220" /></a></td>';
					echo '</tr>';
					
				?>
			</table>
			<?php
			
					if ($i != $isize)
						echo '<br/>';
					unset($res);
				}
				unset($isize);
				require ('layout/footer.php');
				
			?>