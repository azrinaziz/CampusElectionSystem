<?php

require ('./bootstrap.php');
require ('../include/db-function.php');
require ('../include/parse-function.php');
require ('../dbase/db-config.php');

if (isset($_GET['type'])) {
	echo '<script language=javascript>window.print()</script>';
	if ($_GET['type'] == 'electionwin')
		$page_title = 'Election Result';
	if ($_GET['type'] == 'votedvoters')
		$page_title = 'Voted Student List';
}

?>
<html>
<head>
	<title><?php echo $page_title; ?> Report</title>
	<link href='./report.css' rel='stylesheet' type='text/css' />
</head>
<body>
	<table class='formtable'>
		<tr>
			<td><img src='../images/cict-logo.png' alt='<?php echo 'Cosmpoint College of Technology' ?>' height='30' /></td>
			<td><p><b>Cosmopoint Sdn. Bhd.</b><br/>Tingkat GF, Wisma Sachdev, 16-2,<br/>Jalan Raja Laut, 50350 Kuala Lumpur<br/>Tel: 03-2694 9455 | Fax: 03-2691 4079</p></td>
		</tr>
	</table>
	<p><b>CAMPUS ELECTION SYSTEM REPORT:</b>
	<?php if (isset($_GET['type']) && $_GET['type'] == 'votedvoters')  { ?>
	<br/><?php echo strtoupper($page_title); ?></p>
	<?php
	
			$voted = voted_voters($sql);
			$isize = count($voted);
	
	?>
	<p>Total Students Voted: <?php echo $isize; ?></p>
	<table class='listtable'>
		<tr>
			<th><p>&#8470</p></th>
			<th><p>Name</p></th>
			<th><p>MyKad Number</p></th>
		</tr>
		<?php
		
			for ($i=0; $i<$isize; $i++) {
				$j = $i+1;
				echo '<tr>';
				echo "<td><p>$j</p></td>";
				echo '<td class="alignjustify"><p>'.$voted[$i][0].'</p></td>';
				echo '<td><p>'.$voted[$i][1].'</p></td>';
				echo '</tr>';
				unset($j);
			}
			unset($voted);
			
		?>
	</table>
	<?php } else if (isset($_GET['type']) && $_GET['type'] == 'electionwin') { ?>
	<br/><?php echo strtoupper($page_title); ?></p>
	<p>Total Candidates: <?php echo parse_regvoters(1, $sql); ?><br/>Total Offices: <?php echo parse_regvoters(2, $sql); ?></p>
	<?php
	
		require ('../include/common-function.php');
		set_office_list($sql);
		if (check_candidate($sql) == false)
			echo '<h5>Data is currently not available.</h5>';
		else {
			$isize = count($_SESSION['officelist']);
			for ($i=1; $i<=$isize; $i++) {
				$res = all_candidates($i, $sql, true);
				
	?>
	<h5>RESULT FOR THE <?php echo parse_office($i, $sql); ?> OFFICE</h5>
	<table class='listtable'>
		<tr>
			<th><p>&#8470</p></th>
			<th><p>Candidate's Name</p></th>
			<th><p>MyKad Number</p></th>
			<th><p>Votes</p></th>
			<th><p>Percentage</p></th>
		</tr>
	<?php
	
				$totalvotes = 0;
				$totalpercent = 0;
				$jsize = count($res);
				for ($j=0; $j<$jsize; $j++) {
					$k = $j+1;
					echo '<tr>';
					echo "<td><p>$k</p></td>";
					echo '<td class="alignjustify"><p>', $res[$j][1], '</p></td>';
					echo '<td><p>', parse_mykad($res[$j][0], $sql), '</p></td>';
					echo '<td><p>', $res[$j][3], '</p></td>';
					echo '<td><p>', count_percentage($res[$j][3], parse_total_votes($res)), '%</p></td>';
					echo '</tr>';
					$totalvotes += $res[$j][3];
					$totalpercent += count_percentage($res[$j][3], parse_total_votes($res));
					unset($k);
				}
				echo '<tr>';
				echo '<td colspan="3"></td>';
				echo '<td class="bordertop"><p><b>', $totalvotes, '</b></p></td>';
				echo '<td class="bordertop"><p><b>', $totalpercent, '%</b></p></td>';
				echo '</tr>';
		
	?>
	</table>
	<p>Leading Candidate: <b><?php echo parse_leading($res, $sql); ?></b></p>
	<?php
			
				if ($i != $isize)
					echo '<br/><br/>';
				unset($res);
			}
			unset($isize);
			unset($totalvotes);
			unset($totalpercent);
		}
	
	?>
	<?php } else { ?>
	<br/>NO REPORTS ARE GENERATED.</p>
	<?php } ?>
	<br/><p><b>THIS IS A COMPUTER GENERATED REPORT, NO SIGNATURE IS NEEDED</b></p>
</body>
</html>