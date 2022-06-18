<?php 

session_start();

if(!$_SESSION)
{
    header("location: https://www.google.nl");
    exit();
}

session_destroy();
header("location: https://www.google.nl");
exit();

?>
