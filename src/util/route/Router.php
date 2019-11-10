<?php
namespace ise\barscan\Router;
use ise\barscan\util\debug\Debug;

use ise\barscan\pref\_Route;

$request = $_SERVER['REQUEST_URI'];
$srcDir= "../..";
$endpointDir= "$srcDir/util/endpoint";
$endpoint= [
    "scan",
    "cek",
    "tukar",
    "liat",
    "masuk",
    "keluar"
];

Debug::echoe("ini route <br>");

Debug::echoe("request= $request <br>");

Debug::var_dumpe($_GET);
Debug::echoe("<br>");

$host = $_SERVER['HTTP_HOST'];
Debug::echoe("host= $host <br>");

$scheme= $_SERVER['REQUEST_SCHEME'];
Debug::echoe("scheme= $scheme <br>");


route($request);


/*
if(Util::startsWith($request, '/scan'))
    require __DIR__ . "$endpointDir/scan.php";
else if(Util::startsWith($request, '/tukar'))
    require __DIR__ . "$endpointDir/tukar.php";
else if(Util::startsWith($request, '/masuk'))
    require __DIR__ . "$endpointDir/masuk.php";
else if(Util::startsWith($request, '/keluar'))
    require __DIR__ . "$endpointDir/keluar.php"; 
else if(Util::startsWith($request, '/liat'))
    require __DIR__ . "$endpointDir/liat.php";
else
    require __DIR__ . "$endpointDir/404.php";
*/

function route(string $reqUri){
    $url= explode("?", $reqUri)[0];
    $url= str_replace("/", "", $url);
    $url= str_replace("Barcode_Scanner_19", "", $url);

    if(in_array($url, $GLOBALS["endpoint"])){
//        Debug::echoe(_Route::$OK);
        $autoload= '../vendor/autoload.php';
        require __DIR__ ."/" .$GLOBALS["endpointDir"] ."/$url.php";
    } else{
        Debug::echoe(_Route::$GAK_ADA);
        die();
    }
}

/*
switch ($request) {
    case '/scan' :
        require __DIR__ . "$endpointDir/scan.php";
        break;
    case '/tukar' :
        require __DIR__ . "$endpointDir/tukar.php";
        break;
    case '/masuk' :
        require __DIR__ . "$endpointDir/masuk.php";
        break;
    case '/keluar' :
        require __DIR__ . "$endpointDir/keluar.php";
        break;
    case '/liat' :
        require __DIR__ . "$endpointDir/liat.php";
        break;
    default:
        require __DIR__ . '/views/404.php';
        break;
}
/*
switch ($request) {
    case '/' :
        require __DIR__ . '/views/index.php';
        break;
    case '' :
        require __DIR__ . '/views/index.php';
        break;
    case '/about' :
        require __DIR__ . '/views/about.php';
        break;
    default:
        require __DIR__ . '/views/404.php';
        break;
}
*/
?>