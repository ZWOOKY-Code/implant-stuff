# implant-stuff
Have an uri with expiration

Basic work:
http://example.com/?nfc=company1&c=MUw5xxxxxxxxxxxxxxkxVWlx

without the correct code of param C you'll get the default website displayed
with example.com/?KeyWordToGetBlowFishHash=XXXXXXX your secret to get blowfish hashes ######
you'll get something like:

  Kind	          URL                                      TAG 
  vCard business: https://vcard.example.com/?nfc=business  https://vcard.example.com/?nfc=business&c=MUwXXXXXXxxXX0eGkxVWlx
  vCard private:  https://vcard.example.com/?nfc=private   https://vcard.example.com/?nfc=private&c=U2YyNxxxxxxxxxWbzRLVnh5 
  Emrgency:	      https://sos.example.com/?nfc=emergency   https://sos.example.com/?nfc=emergency&c=RzVPWmgxxxxxxx5ZnFHbERp

Writing the TAG to your implant gives somebody access to your vcard or emergency-page. The nfc=code is valide until you change the blowfish password.
Because you are redirected with an expiring link you can't access the page a second time.
Because it's redirected, it's not easy to access the first link used in this case.
I'm sending an email to me, if somebody access a link from the above ones. So I know I need to change the password....

Sorry for my formatting here, but maybe it give's someone an idea how to do the same


Put this in your "main"-code like index.php #################################################################

$objDateTime = new DateTime('NOW');
$DateTime = $objDateTime->format( DateTimeInterface::RFC7231  );
$DateTime_b64 = base64_encode( $DateTime );

$blowfishSALT = '$2a$07$XXXXXXxxxxxxxxxXXXXXXsalt$';   // PAGE https://www.php.net/manual/en/function.crypt.php
$blowfish_MyKey ="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"; 
// $blowfish = crypt('rasmuslerdorf', $blowfishSALT )// 

$blowfish = substr( base64_encode( crypt( $DateTime_b64 , $blowfishSALT )) , - 20 );
$blowfish_CHECK = 0; // 0: if not ok 1: if OK

$location ="https://example.com/";

// if requested per GET
$blowfishRequested   = ""; // if blowfish is requested ....
$var_c      = "-- not set --";


$location ="https://example.com/_nfc_/YourName-vcf-Company1-2022.php?i=" . $DateTime_b64 . "&c=" . $blowfish;

$blowfish_Urls_vcard_private = "https://vcard.example.com/?nfc=company1";
$blowfish_Urls_vcard_business = "https://vcard.example.com/?nfc=company2";
$blowfish_Urls_emergency = "https://sos.example.com/?nfc=emergency";
$blowfish_Urls_emergency_b64 = substr( base64_encode( crypt( base64_encode( $blowfish_Urls_emergency ) , $blowfishSALT )) , - 32 );
$blowfish_Urls_vcard_business_b64 = substr( base64_encode( crypt( base64_encode( $blowfish_Urls_vcard_business ) , $blowfishSALT )) , - 32 );
$blowfish_Urls_vcard_private_b64 = substr( base64_encode( crypt( base64_encode( $blowfish_Urls_vcard_private ) , $blowfishSALT )) , - 32 );


if ( isset( $_GET['KeyWordToGetBlowFishHash'] ) )    {    $blowfishRequested =  $_GET['KeyWordToGetBlowFishHash'];    }
if ( isset( $_GET['c'] ) )    {    $var_c =  $_GET['c'];    }


## check if we got an NFC-TAG of private/business7emergency

    if ( isset( $_GET["nfc"] ) && $_GET["nfc"] =="private" )
    {
        $location = "https://vcard.example.com/_nfc_/YourName-vcf-Company1-2022.php?i=" . $DateTime_b64 . "&c=" . $blowfish;
        if ( $blowfish_Urls_vcard_private_b64 == $var_c )
        {
            $blowfish_CHECK = 1; // 0: if not ok 1: if OK blowfish is fine !!!!
        }
    }
    if ( isset( $_GET["nfc"] ) && $_GET["nfc"] =="business" )
    {
        $location ="https://vcard.example.com/_nfc_/YourName-vcf-Company2-2022.php?i=" . $DateTime_b64 . "&c=" . $blowfish;
        if ( $blowfish_Urls_vcard_business_b64 == $var_c )
        {
            $blowfish_CHECK = 1; // 0: if not ok 1: if OK blowfish is fine !!!!
        }
    }
    if ( isset( $_GET["nfc"] ) && $_GET["nfc"] =="emergency" )
    {
        $location ="https://sos.example.com/_nfc_/YourName-emergency-2022.php?i=" . $DateTime_b64 . "&c=" . $blowfish;
        if ( $blowfish_Urls_emergency_b64 == $var_c )
        {
            $blowfish_CHECK = 1; // 0: if not ok 1: if OK blowfish is fine !!!!
        }
    }


    if ( isset( $_GET["nfc"] ) && $blowfish_CHECK == 1) // get param C (blowfish) is FINE  ##############################################################################################################################
    {

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
    else if ( $blowfishRequested == "XXXXXXX your secret to get blowfish hashes ######" )
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

    else // serve your standard website ......  ##############################################################################################################################
    {
// header("X-Robots-Tag: noindex, nofollow", true);
// header('Content-Type: application/xhtml+xml; charset=utf-8');

// HTML Code for Website


echo <<<ENDE
<!DOCTYPE html>
<html lang="en">
  ....
  ....
  ....
</body>
</html>
ENDE;

} // end example website ..... #################################################################################################

?>



###############################################################################################################################
Example code for vcf:  ########################################################################################################
###############################################################################################################################

<?php


$referer = " -- not set -- ";
$req_uri = " -- not set -- ";
$rem_add = " -- not set -- ";
$nfc     = " -- not set -- ";
$no      = "0";
$agent   = " -- not set -- ";
$var_i   = "Sat, 1 Jan 2022 01:01:01 GMT";
$var_c   = " -- not set -- ";
$blowfishSALT = '$2a$07$XXXXXXxxxxxxxxxXXXXXXsalt$';   // PAGE https://www.php.net/manual/en/function.crypt.php


if ( isset( $_SERVER['HTTP_REFERER'] ) )    {    $referer = $_SERVER['HTTP_REFERER'];    }
if ( isset( $_SERVER['REQUEST_URI'] ) )    {    $req_uri = $_SERVER['REQUEST_URI'];    }
if ( isset( $_SERVER['REMOTE_ADDR'] ) )    {    $rem_add = $_SERVER['REMOTE_ADDR'];    }
if ( isset( $_GET['nfc'] ) )    {    $nfc =  $_GET['nfc'];    }
if ( isset( $_GET['no'] ) )    {    $no =  $_GET['no'];    }
if ( isset( $_GET['i'] ) )    {    $var_i =  $_GET['i'];    }
if ( isset( $_GET['c'] ) )    {    $var_c =  $_GET['c'];    }
if ( isset( $_SERVER['HTTP_USER_AGENT'] ) )    {    $agent =  $_SERVER['HTTP_USER_AGENT'];    }
// $no = 1;

$objDateTime = new DateTime('NOW');
$DateTime = $objDateTime->format( DateTimeInterface::RFC7231  );

$DateTimeCaller = $DateTime_b64 = base64_decode( $var_i );
$timeFirst  = strtotime( $DateTime );
$timeSecond = strtotime( $DateTimeCaller );
$differenceInSeconds = abs($timeSecond - $timeFirst);

$blowfishCHECK = substr( base64_encode( crypt( $var_i , $blowfishSALT )) , - 20 );

if ( $differenceInSeconds >= 10 || $blowfishCHECK != $var_c )  // sixty seconds possible !!!
{
  header("X-Robots-Tag: noindex, nofollow", true);
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
  header('Location: ' . "https://example.com" );  
  exit();
}


header("X-Robots-Tag: noindex, nofollow", true);
header('Content-Type: text/x-vcard; charset=utf-8');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-disposition: filename="Thomas Stoll - private card.vcf"');

echo <<<ENDE
BEGIN:VCARD
...
...
...
END:VCARD
ENDE;

