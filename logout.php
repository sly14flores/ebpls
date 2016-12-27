<?php

require 'config.php';

$START_T = "START TRANSACTION;";
$END_T = "COMMIT;";

session_start();
$sql = "UPDATE accounts SET is_login = 0 WHERE account_id = " . $_SESSION['account_id'];
db_connect();
$db_con->query($START_T);
$db_con->query($sql);
$db_con->query($END_T);
db_close();

unset($_SESSION['account_id']);
unset($_SESSION['account_fname']);
unset($_SESSION['account_department']);
unset($_SESSION['account_d']);
unset($_SESSION['account_privileges']);

header("location: login.php");

?>