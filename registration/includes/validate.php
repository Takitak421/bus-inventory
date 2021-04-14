<?php

function validate_string($string) {
	$string = filter_var($string, FILTER_SANITIZE_STRING);
	// not valid if empty string	
	if ($string == "") {
		return false;
	}
	return $string;
}

function validate_number($number) {
	$number = filter_var($number, FILTER_SANITIZE_NUMBER_INT);
	$number = filter_var($number, FILTER_VALIDATE_INT);
	return $number;
}