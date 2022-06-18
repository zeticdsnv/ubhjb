<?php

session_start();

if(!$_SESSION)
{
    header("location: https://www.google.nl");
    exit();
}

require '../../../required/connection.php';
require '../../../required/functions.php';

ingLoginCheck();

?>