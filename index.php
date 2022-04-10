<?php



$objDateTime = new DateTime('NOW');
$DateTime = $objDateTime->format( DateTimeInterface::RFC7231  );
$DateTime_b64 = base64_encode( $DateTime );

$blowfishSALT = '$2a$07$xxxxxxxxxxxxxxxxxxxxxsalt$';   // PAGE https://www.php.net/manual/en/function.crypt.php$blowfish_MyKey ="we have year 2022 will retire soon!"; 
$blowfish_MyKey ="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"; 
// $blowfish = crypt('rasmuslerdorf', $blowfishSALT )// 

$blowfish = substr( base64_encode( crypt( $DateTime_b64 , $blowfishSALT )) , - 20 );
$blowfish_CHECK = 0; // 0: if not ok 1: if OK

$location ="https://example.com/";

// if requested per GET
$blowfishRequested   = ""; // if blowfish is requested ....
$var_c      = "-- not set --";


$location ="https://example.com/_nfc_/Name-Firstname-vcf-example-2022.php?i=" . $DateTime_b64 . "&c=" . $blowfish;

$blowfish_Urls_vcard_private = "https://vcard.example.com/?nfc=private";
$blowfish_Urls_vcard_business = "https://vcard.example.com/?nfc=business";
$blowfish_Urls_emergency = "https://sos.example.com/?nfc=emergency";
$blowfish_Urls_emergency_b64 = substr( base64_encode( crypt( base64_encode( $blowfish_Urls_emergency ) , $blowfishSALT )) , - 32 );
$blowfish_Urls_vcard_business_b64 = substr( base64_encode( crypt( base64_encode( $blowfish_Urls_vcard_business ) , $blowfishSALT )) , - 32 );
$blowfish_Urls_vcard_private_b64 = substr( base64_encode( crypt( base64_encode( $blowfish_Urls_vcard_private ) , $blowfishSALT )) , - 32 );


if ( isset( $_GET['blowfish'] ) )    {    $blowfishRequested =  $_GET['blowfish'];    }
if ( isset( $_GET['c'] ) )    {    $var_c =  $_GET['c'];    }


    if ( isset( $_GET["nfc"] ) && $_GET["nfc"] =="private" )
    {
        $location = "https://vcard.example.com/_nfc_/Name-Firstname-vcf-example-2022.php?i=" . $DateTime_b64 . "&c=" . $blowfish;
        if ( $blowfish_Urls_vcard_private_b64 == $var_c )
        {
            $blowfish_CHECK = 1; // 0: if not ok 1: if OK blowfish is fine !!!!
        }
    }
    if ( isset( $_GET["nfc"] ) && $_GET["nfc"] =="business" )
    {
        $location ="https://vcard.example.com/_nfc_/Name-Firstname-vcf-FUJITSU-2022.php?i=" . $DateTime_b64 . "&c=" . $blowfish;
        if ( $blowfish_Urls_vcard_business_b64 == $var_c )
        {
            $blowfish_CHECK = 1; // 0: if not ok 1: if OK blowfish is fine !!!!
        }
    }
    if ( isset( $_GET["nfc"] ) && $_GET["nfc"] =="emergency" )
    {
        $location ="https://sos.example.com/_nfc_/Name-Firstname-emergency-2022.php?i=" . $DateTime_b64 . "&c=" . $blowfish;
        if ( $blowfish_Urls_emergency_b64 == $var_c )
        {
            $blowfish_CHECK = 1; // 0: if not ok 1: if OK blowfish is fine !!!!
        }
    }

    if ( isset( $_GET["nfc"] ) && $blowfish_CHECK == 1) // get param C (blowfish) is FINE  ##############################################################################################################################
    {
      $referer = " -- not set -- ";
      $req_uri = " -- not set -- ";
      $rem_add = " -- not set -- ";
      $nfc     = " -- not set -- ";
      $agent   = " -- not set -- ";
      if ( isset( $_SERVER['HTTP_REFERER'] ) )    {    $referer = $_SERVER['HTTP_REFERER'];    }
      if ( isset( $_SERVER['REQUEST_URI'] ) )    {    $req_uri = $_SERVER['REQUEST_URI'];    }
      if ( isset( $_SERVER['REMOTE_ADDR'] ) )    {    $rem_add = $_SERVER['REMOTE_ADDR'];    }
      if ( isset( $_GET['nfc'] ) )    {    $nfc =  $_GET['nfc'];    };
      if ( isset( $_SERVER['HTTP_USER_AGENT'] ) )    {    $agent =  $_SERVER['HTTP_USER_AGENT'];    }
      

      $objDateTime = new DateTime('NOW');
      $DateTime = $objDateTime->format( DateTimeInterface::RFC7231  );

header("X-Robots-Tag: noindex, nofollow", true);
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Location: ' . $location);
      
echo <<<ENDE
<!DOCTYPE html>
<html>
<head>
<link rel="dns-prefetch" href="https://vcard.example.com/" >
<link rel="dns-prefetch" href="https://sos.example.com/" >
<link rel="dns-prefetch" href="https://emergency.example.com/" >
<link rel="dns-prefetch" href="https://src.example.com/" >
<meta http-equiv="refresh" content="0; url='" . $location . "'" />
</head>
<body>
<p>Please follow <a href=' . $location . '>this link if you are not redirected</a>.</p>
</body>
</html>      
ENDE;

    } // end if nfc is set ...
    // ##################################################################################################################
    // get Blowfish Stuff for TAG's
    else if ( $blowfishRequested == "example" )
    {
        echo <<<ENDE1
        <!DOCTYPE html>
        <html>
        <head>
        <link rel="dns-prefetch" href="https://vcard.example.com/" >
        <link rel="dns-prefetch" href="https://sos.example.com/" >
        <link rel="dns-prefetch" href="https://emergency.example.com/" >
        <link rel="dns-prefetch" href="https://src.example.com/" >
        </head>
        <body>
        <table>
        <tr><td>Kind</td><td>URL</td><td>TAG</td></tr>
        <tr><td>vCard business: </td><td>$blowfish_Urls_vcard_business</td><td><B>$blowfish_Urls_vcard_business&c=$blowfish_Urls_vcard_business_b64</B></td></tr>
        <tr><td>vCard private: </td><td>$blowfish_Urls_vcard_private</td><td><B>$blowfish_Urls_vcard_private&c=$blowfish_Urls_vcard_private_b64</B></td></tr>
        <tr><td>Emrgency: </td><td>$blowfish_Urls_emergency</td><td><B>$blowfish_Urls_emergency&c=$blowfish_Urls_emergency_b64</B></td></tr>
        </table>
        <BR><BR>
        <B>Attention: paste without <I>https://</i> to NDEF if you choose link, but make sure it's https set!!</B>
        <BR><B>Test the tag after writing!!!</B>
        </body>
        </html>      
        ENDE1;

    }  // end blowfish requests ...  ##############################################################################################################################


    else // example website ......  ##############################################################################################################################
    {
// header("X-Robots-Tag: noindex, nofollow", true);
// header('Content-Type: application/xhtml+xml; charset=utf-8');

// HTML Code for Website

header('Access-Control-Allow-Origin: *');

echo <<<ENDE
<!DOCTYPE html>
<html lang="en">

<head>

</head>

<body>


</body>
</html>
ENDE;

} // end example website .....  ##############################################################################################################################

?>

