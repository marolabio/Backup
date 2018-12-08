<?php

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "reservation_system";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword,$dbName);
date_default_timezone_set('Asia/Manila');
?>