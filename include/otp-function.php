<?php

function otp($mykad, $sql) {
	otp_existant_check($mykad, $sql);
	if (isset($mykad)) {
		$otp = otp_generator(false);
		$salt = otp_generator(true);
		$insertotp = mysqli_query($sql, "INSERT INTO otp (mykad, otp, salt) VALUES ('$mykad', '".crypt($mykad.$otp, $salt)."', '$salt')");
		unset($salt);
		if ($insertotp == true)
			return $otp;
		else
			return false;
	}
	else
		return false;
}

function otp_check($mykad, $input, $sql) {
	$otpcheck = mysqli_fetch_array(mysqli_query($sql, "SELECT otp, salt FROM otp WHERE mykad='$mykad'"), MYSQLI_NUM);
	if (!empty($otpcheck)) {
		if (crypt($mykad.$input, $otpcheck[1]) == $otpcheck[0])
			return array(true, null);
		else
			return array(false, true);
	}
	else
		return array(false, false);
}

function otp_existant_check($mykad, $sql) {
	$otpcheck = mysqli_fetch_array(mysqli_query($sql, "SELECT mykad FROM otp WHERE mykad='$mykad'"), MYSQLI_NUM);
	if (!empty($otpcheck))
		otp_remove($mykad, $sql);
}

function otp_generator($salt) {
	if ($salt == true)
		return '$2y$09$'.substr(str_shuffle(otp_string_list(true)), 0, 22);
	else
		return substr(str_shuffle(otp_string_list(false)), 0, 8);
}

function otp_remove($mykad, $sql) {
	return mysqli_query($sql, "DELETE FROM otp WHERE mykad=$mykad");
}

function otp_string_list($salt) {
	if ($salt == true)
		return '1234567890abcdefghijklmnopqrstuvwxyz';
	else
		return '1234567890';
}

function password_check($mykad, $input, $sql) {
	$passwordcheck = mysqli_fetch_array(mysqli_query($sql, "SELECT password, salt FROM usersdb WHERE mykad='$mykad'"), MYSQLI_NUM);
	if (crypt($mykad.$input, $passwordcheck[1]) == $passwordcheck[0])
		return true;
	else
		return false;
}

function password_salt_generator() {
	return '$2y$09$'.substr(str_shuffle(password_string_list()), 0, 22);
}

function password_string_list() {
	return '0123456789ghijklmnopqrstuvwxyz';
}
  
?>

