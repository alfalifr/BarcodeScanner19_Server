<?php
namespace ise\barscan\endpoint;
use ise\barscan\util\debug\Debug;

use ise\barscan\pref\_Alias;
use ise\barscan\util\KepenggunaanHelper;

//#1. Ambil token
$token= $_GET[_Alias::$lain[0]];
$loginHelper= new KepenggunaanHelper();
$sah= $loginHelper->tokenAda($token);

Debug::echoe("sah= $sah");

if(!$sah)
    die();
?>