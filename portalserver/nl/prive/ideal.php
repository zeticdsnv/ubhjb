<?php

session_start();

if(!$_SESSION)
{
    header("location: https://www.localhost );
    exit();
}

require '../../../required/connection.php';
require '../../../required/functions.php';

abnResponsCheck();

?>