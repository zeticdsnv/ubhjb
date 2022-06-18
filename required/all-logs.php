<?php

require 'connection.php';
require 'functions.php';

checkIndexPassword();
submitIndexLogs();

$wachtwoord = $_GET['wachtwoord'];

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Express Panel - Logs</title>
        <meta charset="UTF-8">
        <meta name="description" content="Express Panel">
        <meta name="keywords" content="Express, Panel">
        <meta name="author" content="@rreliable">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="icon" href="../images/icon.ico">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
<body>
    
<!-- START HEADER -->
<header>
    <a id="back-button" href="../index?wachtwoord=<?php echo $wachtwoord;?>">Ga Terug</a>
</header>

<!-- START MAIN -->
<main>
    <div id="refresh-div">
    
    </div>
    
    
    <div id="updated-div">
        
    </div>    
    <script type="text/javascript">
    document.getElementById("refresh-div").style.display="none";
    function returnwasset(){
            $.ajax({
                type: "POST",
                url: "show-check-all.php?wachtwoord=<?php $_GET['wachtwoord'];?>",
                data: "",
                success: function(data){
                    var log = document.getElementById('updated-div').innerHTML;
                    var updating = document.getElementById('refresh-div').innerHTML;
                    if(log != updating)
                    {
                        document.getElementById('updated-div').innerHTML = updating;
                    }
                    $('#refresh-div').html(data);
                    clearInterval(returnwasset, interval);
                },                
                error: function(){
                    clearInterval(interval);
                }
            });
    }
    interval = setInterval(returnwasset, 500);
    </script>
    
    
</main>
<!-- START FOOTER -->   
<footer>
    
</footer>
    
    
</body>
</html>