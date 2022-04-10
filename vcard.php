<?php


$referer = " -- not set -- ";
$req_uri = " -- not set -- ";
$rem_add = " -- not set -- ";
$nfc     = " -- not set -- ";
$no      = "0";
$agent   = " -- not set -- ";
$var_i   = "Sat, 1 Jan 2022 01:01:01 GMT";
$var_c   = " -- not set -- ";
$blowfishSALT = '$2a$07$xxxxxxxxxxxxxxxxxxxxxsalt$';   // PAGE https://www.php.net/manual/en/function.crypt.php$blowfish_MyKey ="we have year 2022 will retire soon!"; 


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


if ( $differenceInSeconds >= 10  || $blowfishCHECK != $var_c )  // sixty seconds possible !!!
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
header('Content-disposition: filename="My vCard - business card.vcf"');

echo <<<ENDE
BEGIN:VCARD
VERSION:3.0


END:VCARD
ENDE;


?>
