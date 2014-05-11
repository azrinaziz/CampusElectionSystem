<?php

function check_mykad($mykad, $sql) {
	$mykadcheck = mysqli_fetch_array(mysqli_query($sql, "SELECT mykad FROM votersdb WHERE mykad='$mykad'"), MYSQLI_NUM);
	if (!empty($mykadcheck))
		return true;
	else
		return false;
}

function check_mykad_validity($mykad) {
	$length = strlen($mykad);
	if ($length == 12) {
		if (strcspn($mykad, '0123456789') == 0)
			return true;
		else
			return false;
	}
	else
		return false;
}

function count_percentage($currval, $maxval) {
	if ($currval != 0 && $maxval != 0)
		return round(($currval / $maxval) * 100, 2);
	else
		return 0;
}

function get_office_id($officeid, $sql) {
	$parseofficeid = mysqli_fetch_array(mysqli_query($sql, "SELECT officeid FROM candidates WHERE id='$officeid'"), MYSQLI_NUM);
	$officeid = $parseofficeid[0];
	unset($parseofficeid);
	return $officeid;
}

function get_vote_status($mykad, $officeid, $sql) {
	if ($votestat = mysqli_query($sql, "SELECT candid FROM votes WHERE mykad='$mykad'")) {
		while ($row = mysqli_fetch_row($votestat))
			$votestatus[] = $row;
		unset($votestat);
	}
	
	if (isset($votestatus)) {
		foreach ($votestatus as $value)
			$parseid[] = get_office_id($value[0], $sql);
		unset($votestatus);
			
		foreach ($parseid as $value) {
			if ($officeid == $value) {
				$officematch = true;
				break;
			}
			else
				$officematch = false;
		}
	}
	else
		return false;
	return $officematch;
}

function set_office_list($sql) {
	if (!isset($_SESSION['officelist'])) {
		if ($alloffice = mysqli_query($sql, 'SELECT officeid FROM office')) {
			while ($row = mysqli_fetch_row($alloffice))
				$_SESSION['officelist'][] = $row;
		}
		else
			return false;
	}
}

function set_vote_status($mykad, $officelist, $sql) {
	foreach ($officelist as $value)
		$_SESSION['voted']['office'.$value[0]] = get_vote_status($mykad, $value[0], $sql);
}

?>