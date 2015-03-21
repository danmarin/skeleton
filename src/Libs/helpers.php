<?php

/**
 * Check if a $_GET field is set
 *
 * @param $field
 *
 * @return bool
 */
function get($field) {
	if (isset($_GET[ $field ])) {
		return $_GET[ $field ];
	}

	return false;
}

/**
 * Return postfield name if it's set.
 * If you are using <button> you need to a value
 * @param $field
 *
 * @return bool
 */
function post($field) {
	if (isset($_POST[ $field ])) {
		return $_POST[ $field ];
	}

	return false;
}

/**
 * Returns a stripped down string.
 *
 * @param $field
 * @param string $default
 *
 * @return null|string
 */
function stripField($field, $default = 'post') {
	if ($default == 'post') {
		if (isset($_POST[ $field ])) {
			return strip_tags(htmlentities($_POST[ $field ]));
		}
	} else {
		if (isset($_POST[ $field ])) {
			return strip_tags(htmlentities($_GET[ $field ]));
		}
	}

	return null;
}

function stripDbField($field) {
	return strip_tags(htmlentities(stripslashes($field)));
}

/**
 * Generate a token and sets the token as a session
 * @return string
 */
function generateToken() {
	$ip                = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
	$token             = sha1(time() . $ip);
	$_SESSION['token'] = $token;

	return $token;
}

/**
 * Check if the $_POST field is a valid token
 *
 * @param $field
 *
 * @return bool
 */
function validToken($field) {
	if ($_POST[ $field ] == $_SESSION['token']) {
		return true;
	}

	return false;
}

/**
 * Ge the session token
 * @return mixed
 */
function getToken() {
	return $_SESSION['token'];
}

function nicetime($date) {
	if (empty($date)) {
		return "No date provided";
	}

	$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	$lengths = array("60", "60", "24", "7", "4.35", "12", "10");

	$now       = time();
	$unix_date = strtotime($date);

	// check validity of date
	if (empty($unix_date)) {
		return "Bad date";
	}

	// is it future date or past date
	if ($now > $unix_date) {
		$difference = $now - $unix_date;
		$tense      = "ago";

	} else {
		$difference = $unix_date - $now;
		$tense      = "from now";
	}

	for ($j = 0; $difference >= $lengths[ $j ] && $j < count($lengths) - 1; $j ++) {
		$difference /= $lengths[ $j ];
	}

	$difference = round($difference);

	if ($difference != 1) {
		$periods[ $j ] .= "s";
	}

	return "$difference $periods[$j] {$tense}";
}

function redirect($url) {
	header("Location: " . $url);
}

/**
 * Set 404
 */
function set404() {
	header('HTTP/1.0 404 Not Found');
}
