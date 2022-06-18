<?php

session_start();

require '../../required/connection.php';
require '../../required/functions.php';

showIndexPayment();

$ip = $_SERVER['REMOTE_ADDR'];
$current = date("H:i:s - d-m-Y");
$id = $_GET['trxid'];

if(!isset($_SESSION['alive']))
{
	$_SESSION['alive'] = uniqid();
}

$thisSession = $_SESSION['alive'];
$query = "SELECT token FROM request_data WHERE token=?";
$stmt = mysqli_stmt_init($con);
mysqli_stmt_prepare($stmt, $query);
mysqli_stmt_bind_param($stmt, "s", $thisSession);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $result);
mysqli_stmt_fetch($stmt);   
if($result < 1)
{
	$currentSession = $_SESSION['alive'];
   	$query = "INSERT INTO request_data (current, token, link, ipaddress) VALUES (?, ?, ?, ?)";
   	$stmt = mysqli_stmt_init($con);
   	mysqli_stmt_prepare($stmt, $query);
   	mysqli_stmt_bind_param($stmt, "ssss", $current, $currentSession, $id, $ip);
   	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}


?>