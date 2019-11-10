<?php
namespace ise\barscan\endpoint;
use ise\barscan\util\debug\Debug;

if(!isset($autoload))
    require '../../../vendor/autoload.php';
require "cekTokenHarus.php";

use ise\barscan\pref\_Alias;
use ise\barscan\pref\_Skor;
use ise\barscan\util\ItemHelper;
use ise\barscan\util\KepenggunaanHelper;
use ise\barscan\util\ScanHelper;
use ise\barscan\util\ParamHelper;

try{
    //#1. Ambil param
    $paramHelper= ParamHelper::ambilParam($_GET,
        [_Alias::$lain[2], _Alias::$lain[3]]);
    $tujuan= $paramHelper[_Alias::$lain[2]];
    $item= $paramHelper[_Alias::$lain[3]];
    
    //#2. Cari item
    $itemHelper= new ItemHelper();
    $item= $itemHelper->cariItem($item); //new Peserta("ID3", "abcd", 0, "ID2", "Startup");
    $item= $itemHelper->jadikanModel($item);
    //$penscan1= new Peserta("ID4", "abcd", 0, "ID1", "Game");
    
    if(!$item)
        Debug::echoa(_Alias::$GAK_ADA);
        
    //#3. Mulai operasi scanKurang
    $scanHelper= new ScanHelper();
    $hasil= $scanHelper->scanKurang($item, $tujuan);

    //#4. Update AktTrahir
    $scanHelper->updateAktTrahir($token);

    //#5. Kirim respon simpel
    if($hasil !== _Skor::$SKOR_KURANG && $hasil !== _Skor::$BATAS_MAKS
        && $hasil !== _Peran::$GAK_ADA)
        Debug::echoa(_Alias::$respon["ya"]);
    else
        Debug::echoa($hasil);
    
} catch(exception $e){
    Debug::echoa(_Alias::$respon["gak"]);
}
?>