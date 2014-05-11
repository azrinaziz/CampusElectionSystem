<?php

require ('./bootstrap.php');
require ('../include/db-function.php');
require ('../include/parse-function.php');
require ('../dbase/db-config.php');

if (isset($_GET['type']))
	echo '<script language=javascript>window.print()</script>';

?>
<html>
<head>
	<title>Report</title>
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
	<br/>VOTED STUDENTS LIST</p>
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
	<br/>ELECTION RESULTS</p>
	<?php } else { ?>
	<br/>NO REPORTS ARE GENERATED.</p>
	<?php } ?>
	<br/><p><b>THIS IS A COMPUTER GENERATED REPORT, NO SIGNATURE IS NEEDED</b></p>
</body>
</html>