<?php

$sqlhost = 'localhost';
$sqlusername = 'root';
$sqlpassword = '';
$sqldbname = 'ces';
$sql = mysqli_connect($sqlhost, $sqlusername ,$sqlpassword ,$sqldbname);

if (mysqli_connect_errno($sql)) {
	echo '<p>Failed to connect to MySQL: '. mysqli_connect_error().'</p>';
}

?>