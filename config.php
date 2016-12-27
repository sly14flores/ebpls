<?php

$q = "zX5t4m0kXMSrAtUJ4ubzoNVZrWCG9dBpJhxvAUa8bKU="; // l
$q = "L239u+bkOQTwZrqvL2jRCUCjKX5WqNqhPpZIwJABWFE="; // r
$k = 'qJB5rGtIn5UB1xG010efyCp';
$pw = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $k ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $k ) ) ), "\0");

/* Database Configuration */
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PWD	 = "$pw";
$DB_FILE = "ebpls";
$DB_PORT = 3306;

function db_connect() {
	global $db_con, $DB_HOST, $DB_USER, $DB_PWD, $DB_FILE, $DB_PORT;
	$db_con = new mysqli($DB_HOST, $DB_USER, $DB_PWD, $DB_FILE, $DB_PORT);
}

function db_close() {
	global $db_con;
	$db_con->close();
}

?>