<?php
namespace ise\barscan\endpoint;
use ise\barscan\util\debug\Debug;

if(!isset($autoload))
    require '../../../vendor/autoload.php';
require "cekTokenHarus.php";

use ise\barscan\pref\_Alias;
use ise\barscan\pref\_NamaTabel;
use ise\barscan\util\KepenggunaanHelper;
use ise\barscan\util\LiatHelper;
use ise\barscan\util\ScanHelper;
use ise\barscan\util\ParamHelper;

try{
    //#1. Ambil param
    $paramHelper= ParamHelper::ambilParam($_GET, [_Alias::$lain[4]]);
    Debug::var_dumpe($paramHelper);
//    $token= $paramHelper[_Alias::$lain[0]];
    $jenisDaftar= $paramHelper[_Alias::$lain[4]];

    //2#. Ambil semua daftar
    $liatHelper= new LiatHelper();
    $daftar= null;
    switch($jenisDaftar){
        case _NamaTabel::$item:
            $daftar= $liatHelper->liatDaftarItem();
            break;
        case _NamaTabel::$login:
            $daftar= $liatHelper->liatDaftarLogin();
            break;
        case _NamaTabel::$penukaran:
            $daftar= $liatHelper->liatDaftarPenukaran();
            break;
        case _NamaTabel::$peserta:
            $daftar= $liatHelper->liatDaftarPeserta();
            break;
        case _NamaTabel::$peran:
            $daftar= $liatHelper->liatDaftarPeran();
            break;
    }
    
    //#3. Update AktTrahir
    $scanHelper= new ScanHelper();
    $hasilUpdate= $scanHelper->updateAktTrahir($token);

    Debug::echoe("hasil update= $hasilUpdate <br>");
    //#4. Kirim daftar hasil query
Debug::echoa(/*json_encode(*/$daftar/*)*/);

} catch(exception $e){
    Debug::echoa(_Alias::$respon["gak"]);
}
?>