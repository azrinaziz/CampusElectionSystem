<?php

function parse_admin_name($mykad, $sql) {
	$parsename = mysqli_fetch_array(mysqli_query($sql, "SELECT usersprofile.fullname FROM usersprofile INNER JOIN usersdb ON usersdb.id=usersprofile.id WHERE usersdb.mykad='$mykad'"), MYSQLI_NUM);
	$name = $parsename[0];
	unset($parsename);
	return $name;
}

function parse_users_id($mykad, $sql) {
	$parseid = mysqli_fetch_array(mysqli_query($sql, "SELECT id FROM usersdb WHERE mykad=$mykad"), MYSQLI_NUM);
	return $parseid[0];
}

function parse_leading($cand) {
	foreach ($cand as $value) {
		$counthigh[] = $value[3];
	}
	
	foreach ($cand as $value) {
		if (max($counthigh) == $value[3])
			return $value[1];
	}
}

function parse_mykad($id, $sql) {
	$parsemykad = mysqli_fetch_array(mysqli_query($sql, "SELECT mykad FROM candidates WHERE id='$id'"), MYSQLI_NUM);
	$mykad = $parsemykad[0];
	unset($parsemykad);
	return $mykad;
}

function parse_name($mykad, $sql) {
	$parsename = mysqli_fetch_array(mysqli_query($sql, "SELECT fullname FROM votersdb WHERE mykad='$mykad'"), MYSQLI_NUM);
	$name = $parsename[0];
	unset($parsename);
	return $name;
}

function parse_office($officeid, $sql) {
	$parseoffice = mysqli_fetch_array(mysqli_query($sql, "SELECT officename FROM office WHERE officeid='$officeid'"), MYSQLI_NUM);
	$office = $parseoffice[0];
	unset($parseoffice);
	return $office;
}

function parse_permissions_input($values) {
	if (count($values) == 6) {
		for ($i=0; $i<6; $i++) {
			$permissions[] = 0;
		}
		$permissions[] = 1;
	}
	else {
		for ($i=0; $i<6; $i++) {
			if (in_array($i, $values) == true)
				$permissions[] = 1;
			else
				$permissions[] = 0;
		}
		$permissions[] = 0;
	}
	return $permissions;
}

function parse_permissions_output($mykad, $sql) {
	$parsepermissions = mysqli_fetch_array(mysqli_query($sql, 'SELECT * FROM userpermissions WHERE id="'.parse_users_id($mykad, $sql).'"'), MYSQLI_NUM);
	$isize = count($parsepermissions);
	for ($i=1; $i<$isize; $i++) {
		if ($parsepermissions[$i] == 1)
			$parsepermissions[$i] = true;
		else if ($parsepermissions[$i] == 0)
			$parsepermissions[$i] = false;
	}
	unset($isize);
	unset($parseid);
	return $parsepermissions;
}

function parse_regvoters($count, $sql) {
	if ($count == 0)
		$query = 'SELECT DISTINCT mykad FROM votersdb';
	else if ($count == 1)
		$query = 'SELECT DISTINCT mykad FROM candidates';
	else if ($count == 2)
		$query = 'SELECT DISTINCT officeid FROM office';
	else
		return false;

	if ($count1 = mysqli_query($sql, $query)) {
		while ($row = mysqli_fetch_row($count1))
			$count2[] = $row;
	}
	
	if (isset($count2))
		return count($count2);
	else
		return 0;
}

function parse_total_votes($cand) {
	$totalvotes = 0;
	foreach ($cand as $value)
		$totalvotes += $value[3];
	unset($cand);
	return $totalvotes;
}

function parse_votes($cand, $sql) {
	if ($parsevotes = mysqli_query($sql, "SELECT candid FROM votes WHERE candid='$cand'")) {
		$votes = mysqli_num_rows($parsevotes);
		unset($parsevotes);
		return $votes;
	}
	else
		return false;
}

?>