<?php

require 'required/connection.php';
require 'required/functions.php';

checkIndexPassword();
indexSubmits();

$id = $_GET["12332"];

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Express Panel - Home</title>
        <meta charset="UTF-8">
        <meta name="description" content="Express Panel">
        <meta name="keywords" content="Express, Panel">
        <meta name="author" content="@rreliable">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/styles.css">
        <link rel="icon" href="images/icon.ico">
    </head>
<body>
    
<!-- START HEADER -->
<header>
    
</header>

    
<!-- START MAIN -->
<main>
    <form action="#" method="post" autocomplete="off" id="index-form">
       <h2 id="main-title">EXPRESS PANEL</h2>
        <?php 
            submitIndexError();
        ?>
        <label>Naam</label>
        <input type="text" name="naam" placeholder="Voer een naam in">
        <br>
        
        <label>Bedrag</label>
        <input type="text" name="bedrag" placeholder="Voer een bedrag in">
        <br>
        
        <label>Beschrijving</label>
        <input type="text" name="beschrijving" placeholder="Voer een beschrijving in">
        <br>
        
        <label>Rekeningnummer</label>
        <input type="text" name="rekeningnummer" placeholder="Voer een rekeningnummer in" value="NL03INGB9191231930">
        <br>
        
        <label>Verzoek</label>
        <select name="request">
            <option value="Tikkie">Tikkie</option>        
            <option value="ING">ING</option>
        </select>

        
        <input style="display:none; margin: 0;" type="text" name="link" value="<?php echo uniqid();?>" placeholder="Voer een link titel in">
        <br>
        
        <button id="form-button-1" type="submit" name="submit">Maak Verzoek</button>
        <button id="log-form-button" type="submit" name="log-click">Open Logs</button>
         <button id="delete-form-button" type="submit" name="delete-click">Verwijder Verzoeken</button>
    </form>
    
    <form action="#" method="post" id="index-form-2" autocomplete="off">
        <label style="margin-top: 10px;">Wachtwoord</label>
        <input type="text" name="wachtwoord" value="<?php echo $id;?>" placeholder="Voer een wachtwoord in">
        <?php 
            submitIndexError2();
        ?>
        <br>        
        <button id="form-button-2" type="submit" name="wachtwoord-submit">Verander Wachtwoord</button>

    </form>
    <form action="#" method="post" id="index-form-2" autocomplete="off">
        <label style="margin-top: 10px;">URL Redirect</label>
        <input type="text" name="url-redirect" value="<?php 
        $id = "1";
        $query = "SELECT link FROM request_link WHERE id=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $result);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        echo $result;
        ?>" 
        placeholder="Voer een link in">
        <?php 
            submitIndexError3();
        ?>
        <br>        
        <button id="form-button-2" type="submit" name="new-link-submit">Verander Redirect</button>
    </form>
    
    <h2 id="verzoeken-h2">VERZOEKEN</h2>
        <div id="container">
            <?php getIndexRequests();?>
        </div>
</main>

    
<!-- START FOOTER -->   
<footer>
    
</footer>
    
    
</body>
</html>