<?php

$serverName = "localhost";
$userName = "root";
$userPass = "";
$dbName = "shadowpanelv2";

$con = mysqli_connect($serverName, $userName, $userPass, $dbName);

if(!$con)
{
    die("Connection Error" . mysqli_connect_error());
}

?>