<?php 

session_start();

if(!$_SESSION)
{
    header("location: https://www.google.nl");
    exit();
}

require '../../required/functions.php'; 
require '../../required/connection.php';

raboResponsCheckTwo();

?>