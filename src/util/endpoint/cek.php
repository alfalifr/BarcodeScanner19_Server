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
    $idusertujuan= $paramHelper[_Alias::$lain[2]];
    
    //#2. Cari peserta dg id user $idusertujuan
    $loginHelper= new KepenggunaanHelper();
    $pengunjung= $loginHelper->cariPesertaDgId($idusertujuan); //->cariPesertaDgToken($token); //new Peserta("ID3", "abcd", 0, "ID2", "Startup");
    $pengunjung= $loginHelper->jadikanPesertaModel($pengunjung);
    //$penscan1= new Peserta("ID4", "abcd", 0, "ID1", "Game");
/*    
    Debug::echoe("penscan = <br>");
    Debug::var_dumpe($penscan);
    Debug::echoe("penscan ====== <br>");
*/    
    if(!$pengunjung)
        Debug::echoa(_Peran::$GAK_ADA);
    //#3. Ambil skornya peserta
    $skor= $pengunjung->skor;
    
    //#4. Update AktTrahir
    $scanHelper= new ScanHelper();
    $scanHelper->updateAktTrahir($token);

    //#5. Kirim skor
    Debug::echoa($skor);

} catch(exception $e){
    Debug::echoa(_Alias::$respon["gak"]);
}
?>