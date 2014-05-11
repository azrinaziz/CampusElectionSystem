<?php

function form_gender() {
	return array('Male', 'Female', 'Hermaphrodite');
}

function form_malaysian_states() {
	return array('Federal Territory', 'Johor', 'Kedah', 'Kelantan', 'Malacca', 'Negeri Sembilan', 'Pahang', 'Perak', 'Perlis', 'Penang', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu');
}

function form_year() {
	$year = array();
	for ($i=strftime('%Y')-150; $i<=strftime('%Y'); $i++)
		array_push($year, $i);
	return $year;
}

?>