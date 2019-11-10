<?php
namespace ise\barscan\endpoint;
use ise\barscan\util\debug\Debug;

if(!isset($autoload))
    require '../../../vendor/autoload.php';
require "cekToken.php";

use ise\barscan\pref\_Alias as _Alias;
use ise\barscan\util\KepenggunaanHelper;
use ise\barscan\util\ParamHelper;
use ise\barscan\util\TokenHelper;

if($sah){
    Debug::echoa(_Alias::$respon["ya"]);
    die();
}

//#1. Ambil param
$paramDe= ParamHelper::ambilParam($_GET,
    [_Alias::$lain[5], _Alias::$lain[6]]);
$uname= $paramDe[_Alias::$lain[5]];
$pass= $paramDe[_Alias::$lain[6]];

//#2. Cek Login
$loginHelper= new KepenggunaanHelper();
$login= $loginHelper->login($uname, $pass);

if(!$login){
    Debug::echoa(_Alias::$respon["gak"]);
    die();
}

//#3. Buat token
$tokenHelper= new TokenHelper();
$token= "";
do{
    $token= $tokenHelper::generateToken();
} while($loginHelper->tokenAda($token));

//#4. Ambil peran peserta
$loginHelper->tambahLogin($token, $login->id);
$peran= $loginHelper->cariPeran($login->fk_peran);
$peran= $loginHelper->jadikanPeranModel($peran);
/*
$tes= $peran == null;
Debug::echoe("peran==null >> " .$tes ."<br>");
Debug::echoe("fk_peran= " .$login->fk_peran ."<br>");
*/
//#5. Jadikan array
$arrayHasil= [];
$arrayHasil[_Alias::$lain[0]]= $token;
$arrayHasil[_Alias::$lain[8]]= $login->id;
$arrayHasil[_Alias::$lain[7]]= $peran->nama;


$jsonHasil= json_encode($arrayHasil, JSON_FORCE_OBJECT);

//#6. Kirim json
Debug::echoa($jsonHasil);
?>