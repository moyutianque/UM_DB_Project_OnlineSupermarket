<?php
//session_start();

DEFINE('DB_USER', $_SESSION['username']);
DEFINE('DB_PASSWORD', $_SESSION['password']);
DEFINE('DB_HOST','localhost');
DEFINE('DB_NAME','supermarket');

$db = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME)
        OR die('Could not connect to MySQL' . mysqli_connect_errno());

?>