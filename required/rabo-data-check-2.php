<?php

require 'connection.php';

$currentSession = $_GET["session"];

$id = $_GET["trxid"];
$query = "SELECT raboresponschecktwo FROM request_data WHERE token=?";
$stmt = mysqli_stmt_init($con);
mysqli_stmt_prepare($stmt, $query);
mysqli_stmt_bind_param($stmt, "s", $currentSession);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $check);

while(mysqli_stmt_fetch($stmt))
{
    $check;
}
echo $check;
mysqli_stmt_close($stmt);

?>