<!DOCTYPE html>
<?php

session_name('cesadmin');
if (session_status() == PHP_SESSION_NONE)
    session_start();

if ($_SERVER['PHP_SELF'] != '/ces/admin/login.php') {
	if (empty($_SESSION['mykad']) && empty($_SESSION['permissions']))
		header('location: ./login.php?error=1');
}

?>