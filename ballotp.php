<?php

require ('./bootstrap.php');
require ('./dbase/db-config.php');
require ('./include/common-function.php');

if (!isset($_SESSION['voters']) || !isset($_SESSION['voted']) || !isset($_GET['vote']))
	header('location: ./index.php');

set_office_list($sql);
set_vote_status($_SESSION['voters'], $_SESSION['officelist'], $sql);

if ($_SESSION['voted']['office'.get_office_id($_GET['vote'], $sql)] == false) {
	$insertvote = mysqli_query($sql, 'INSERT INTO votes (candid, mykad) VALUES ('.$_GET['vote'].', "'.$_SESSION['voters'].'")');
	if ($insertvote == true)
		header('location: ./ballotc.php?votestatus=0');
	else
		header('location: ./ballotc.php?votestatus=1');
}
else
	header('location: ./ballotc.php?votestatus=2');

?>