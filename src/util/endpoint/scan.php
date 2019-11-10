<?php
namespace ise\barscan\endpoint;
use ise\barscan\util\debug\Debug;

if(!isset($autoload))
    require '../../../vendor/autoload.php';
require "cekTokenHarus.php";

use ise\barscan\pref\_Alias;
use ise\barscan\pref\_Peran;
use ise\barscan\pref\_Skor;
use ise\barscan\util\KepenggunaanHelper;
use ise\barscan\util\ScanHelper;
use ise\barscan\util\ParamHelper;

try{
    //#1. Ambil param
    $paramHelper= ParamHelper::ambilParam($_GET, [_Alias::$lain[2]]);
//    Debug::var_dumpe($paramHelper);
//    $token= $paramHelper[_Alias::$lain[0]];
    $tujuan= $paramHelper[_Alias::$lain[2]];
    
    //#2. Cari peserta dg token yg ada
    $loginHelper= new KepenggunaanHelper();
    $penscan= $loginHelper->cariPesertaDgToken($token); //new Peserta("ID3", "abcd", 0, "ID2", "Startup");
    $penscan= $loginHelper->jadikanPesertaModel($penscan);
    //$penscan1= new Peserta("ID4", "abcd", 0, "ID1", "Game");
/*    
    Debug::echoe("penscan = <br>");
    Debug::var_dumpe($penscan);
    Debug::echoe("penscan ====== <br>");
*/    
    //#3. Cari peran peserta
    $peran= $loginHelper->cariPeran($penscan->fk_peran);
    $peran= $loginHelper->jadikanPeranModel($peran);
    
    //#3. Mulai operasi scanTambah
    $scanHelper= new ScanHelper();
    $hasil= $scanHelper->scanTambah($penscan, $peran, $tujuan);
    
    //#4. Update AktTrahir
    $scanHelper->updateAktTrahir($token);

    Debug::echoe("hasil= $hasil");
    //#5. Kirim respon simpel
    if($hasil !== _Skor::$UDAH_ADA && $hasil !== _Skor::$BATAS_MAKS
        && $hasil !== _Peran::$GAK_ADA)
        Debug::echoa(_Alias::$respon["ya"]);
    else
        Debug::echoa($hasil);

} catch(exception $e){
    Debug::echoa(_Alias::$respon["gak"]);
}
?>