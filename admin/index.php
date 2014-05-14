<?php

$page_title = 'Home';
require ('./bootstrap.php');
require ('./layout/header.php');
require ('../dbase/db-config.php');
require ('../include/parse-function.php');

?>
			<h3><?php echo $page_title; ?></h3>
			<div class='form'>
				<h5>Welcome to the CES Administrative Control Panel, <?php echo parse_admin_name($_SESSION['mykad'], $sql); ?>.</h5><br/>
				<h4>Statistics</h4>
				<p>There are <b><?php echo parse_regvoters(0, $sql); ?></b> registered voters.</p>
				<p>There are <b><?php echo parse_regvoters(1, $sql); ?></b> candidates.</p>
				<p>There are <b><?php echo parse_regvoters(2, $sql); ?></b> offices to be contested.</p>
				<br/>
				<h4>Notices</h4>
				<ul>
					<li><p>Please contact the administrator to change your password.</p></li>
					<li><p>Click <a href='../results.php'>here</a> to view live results.</p></li>
				</ul>
			</div>

<?php require ('layout/footer.php'); ?>