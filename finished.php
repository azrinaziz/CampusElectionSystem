<?php

$page_title = 'Thank You!';
require ('./bootstrap.php');
require ('./layout/header.php');
require ('./dbase/db-config.php');
require ('./include/common-function.php');
require ('./include/db-function.php');
require ('./include/otp-function.php');
require ('./include/parse-function.php');

if (!isset($_SESSION['voters']) || !isset($_SESSION['voted']))
	header('location: ./ballotl.php');

set_office_list($sql);
set_vote_status($_SESSION['voters'], $_SESSION['officelist'], $sql);
	
if (count(array_filter($_SESSION['voted'])) != count($_SESSION['voted']))
	header('location: ./ballotc.php');

?>
			<p>Thank you for voting. You have been logged out. This is the candidate(s) you have voted:</p>
			<table class='tablelist' cellpadding='8' cellspacing='0'>
				<?php
				
					foreach (vote_summary($_SESSION['voters'], $sql) as $value) {
						echo '<tr><th width="200"><img src="', $value[1], '" alt="', $value[0], '" height="160" /></th>';
						echo' <td><p>FOR ', parse_office($value[2], $sql), ' OFFICE<br/><h3>', $value[0], '</h3></td></tr>';
					}
				
				?>
			</table>
<?php

otp_remove($_SESSION['voters'], $sql);
session_destroy();
header('Refresh: 5; URL=./ballotl.php');
require ('layout/footer.php');

?>