<?php

function all_candidates($officeid, $sql, $resultpage) {
	if ($cand1 = mysqli_query($sql, "SELECT candidates.id, votersdb.fullname, candidates.photopath FROM candidates INNER JOIN votersdb ON candidates.mykad=votersdb.mykad WHERE officeid='$officeid' ORDER BY candidates.id ASC")) {
		while ($row = mysqli_fetch_row($cand1))
			$cand2[] = $row;
	}
	
	if ($resultpage == true) {
		$isize = count($cand2);
		for ($i=0; $i<$isize; $i++) {
			$cand2[$i][] = parse_votes($cand2[$i][0], $sql);
		}
		unset($isize);
		return $cand2;
	}
	else
		return $cand2;
}

function check_candidate($sql) {
	return($insertvoters = mysqli_query($sql, 'SELECT id FROM candidates'));
}

function vote_summary($mykad, $sql) {
	if ($votestat = mysqli_query($sql, "SELECT candid FROM votes WHERE mykad='$mykad'")) {
		while ($row = mysqli_fetch_row($votestat))
			$votestatus[] = $row;
		unset($votestat);
	}
	
	foreach ($votestatus as $value) {
		if ($cand1 = mysqli_query($sql, 'SELECT votersdb.fullname, candidates.photopath, candidates.officeid FROM candidates INNER JOIN votersdb ON candidates.mykad=votersdb.mykad WHERE id="'.$value[0].'"')) {
		while ($row = mysqli_fetch_row($cand1))
			$cand2[] = $row;
		}
	}
	return($cand2);
}

function voted_voters($sql) {
	if ($vote1 = mysqli_query($sql, 'SELECT DISTINCT mykad FROM votes')) {
		while ($row = mysqli_fetch_row($vote1)) {
			$vote2[][] = parse_name($row[0], $sql);
			$vote2[count($vote2)-1][] = $row[0];
		}
	}
	sort($vote2);
	return ($vote2);
}

?>