<?php

$page_title = 'LIVE Election Results';
require ('./bootstrap.php');
require ('./layout/header.php');
require ('./dbase/db-config.php');
require ('./include/common-function.php');
require ('./include/db-function.php');
require ('./include/parse-function.php');

set_office_list($sql);

?>
			<h3><?php echo $page_title; ?></h3>
			<?php
			
				if (check_candidate($sql) == false) {
					echo '<h2>Data is currently not available. Please come back later.</h2>';
					header('Refresh: 10; URL = '.$_SERVER['REQUEST_URI']);
				}
				else {
					$isize = count($_SESSION['officelist']);
					for ($i=1; $i<=$isize; $i++) {
						$res = all_candidates($i, $sql, true);
				
			?>
				<table class='tablelist' cellpadding='8' cellspacing='0'>
				<?php
					
						echo '<tr>';
						echo '<td colspan="', count($res), '"><b>LIVE RESULT FOR THE ', parse_office($i, $sql), ' OFFICE</b></td>';
						echo '</tr><tr>';
						foreach ($res as $value) {
							echo '<th>', $value[1], '</th>';
						}
						echo '</tr><tr>';
						foreach ($res as $value) {
							echo '<td><img src="', $value[2], '" alt="" height="220" /></td>';
						}
						echo '</tr><tr>';
						foreach ($res as $value) {
							echo '<th><h2>', count_percentage($value[3], parse_total_votes($res)), '%</h2>';
							echo '<p>', $value[3];
							if ($value[3] <= 1)
								echo ' vote</p></td>';
							else
								echo ' votes</p></th>';
						}
						echo '</tr><tr>';
						echo '<td colspan="', count($res), '"><p>Leading Candidate: <b>', parse_leading($res, $sql), '</b></p></td>';
						echo '</tr>';
					
				?>
				</table>
			<?php
			
						if ($i != $isize)
							echo '<br/>';
						unset($res);
					}
					unset($isize);
					header('Refresh: 5; URL = '.$_SERVER['REQUEST_URI']);
				}
				require ('layout/footer.php');

			?>