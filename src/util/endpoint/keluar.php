<?php
namespace ise\barscan\endpoint;
use ise\barscan\util\debug\Debug;

if(!isset($autoload))
    require '../../../vendor/autoload.php';
require "cekTokenHarus.php";

use ise\barscan\pref\_Alias;
use ise\barscan\util\KepenggunaanHelper;

//#1. Ambil param
$token= $_GET[_Alias::$lain[0]];

//#2. Logout
$loginHelper= new KepenggunaanHelper();
$logout= $loginHelper->logout($token);

if($logout)
    Debug::echoa(_Alias::$respon["ya"]);
else
    Debug::echoa(_Alias::$respon["gak"]);
?>