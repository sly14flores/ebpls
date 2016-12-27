<?php

session_start();

if (isset($_SESSION['account_id'])) {

} else {
	header("location: login.php");	
}

?>
