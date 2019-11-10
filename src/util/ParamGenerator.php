<?php
namespace ise\barscan\util;
use ise\barscan\pref\_Alias;

class ParamGenerator{
/*    
    static function ambilTokenLokal(): String?{
        return FileTool.bacaLnDariFile(_Alias.loginDir, 0)
    }

    static function cekTokenLokal(): Boolean{
        return ambilTokenLokal() != null
    }
*/
    static function keyPointer(string $token){
        return substr($token, TokenHelper::$keyPointerIndMin, TokenHelper::$keyPointerIndMax);
    }


    static function userTujuanEn(string $token, string $idUser){
        $keyPointerStr= self::keyPointer($token);
//        $token= ambilTokenLokal() ?: return null

        $hambaInd= $keyPointerStr[1];
        $hambaK= $token[array_search($hambaInd, _Alias::$tabela)];

        $hambaNama= _Alias::$lain[2];
        $hambaNamaEn= TokenHelper::enkrip($hambaNama, $hambaK);
        $hambaNilaiEn= TokenHelper::enkrip($idUser, $hambaK);

        return "$hambaNamaEn=$hambaNilaiEn";
    }

    static function itemEn(string $token, string $idItem){
        $keyPointerStr= self::keyPointer($token);

        $indeksInd= $keyPointerStr[2];
        $indeksK= $token[array_search($indeksInd, _Alias::$tabela)];

        $indeksNama= _Alias::$lain[3];
        $indeksNamaEn= TokenHelper::enkrip($indeksNama, $indeksK);
        $indeksNilaiEn= TokenHelper::enkrip($idItem, $indeksK);

        return "$indeksNamaEn=$indeksNilaiEn";
    }


    static function liatEn(string $token, string $idLiat){
        $keyPointerStr= self::keyPointer($token);

        $slulupInd= $keyPointerStr[3];
        $slulupK= $token[array_search($slulupInd, _Alias::$tabela)];

        $slulupNama= _Alias::$lain[4];
        $slulupNamaEn= TokenHelper::enkrip($slulupNama, $slulupK);
        $slulupNilaiEn= TokenHelper::enkrip($idLiat, $slulupK);

        return "$slulupNamaEn=$slulupNilaiEn";
    }

    static function unameEn(string $uname){
//        $keyPointerStr= self::keyPointer($token);

//            $mwawmInd= keyPointerStr[0].toString()
        $mwawmK= _Alias::$memberlakuK; //token[_Alias.tabela.indexOf(mwawmInd)].toString()

        $mwawmNama= _Alias::$lain[5];
        $mwawmNamaEn= TokenHelper::enkrip($mwawmNama, $mwawmK);
        $mwawmNilaiEn= TokenHelper::enkrip($uname, $mwawmK);

        return "$mwawmNamaEn=$mwawmNilaiEn";
    }
    static function passEn(string $pass){
//        $keyPointerStr= self::keyPointer($token);

//            $dakseidInd= keyPointerStr[0].toString()
        $dakseidK= _Alias::$memberlakuK; //token[_Alias.tabela.indexOf(dakseidInd)].toString()

        $dakseidNama= _Alias::$lain[6];
        $dakseidNamaEn= TokenHelper::enkrip($dakseidNama, $dakseidK);
        $dakseidNilaiEn= TokenHelper::enkrip($pass, $dakseidK);

        return "$dakseidNamaEn=$dakseidNilaiEn";
    }


    static function scanUrl(string $token, string $idUserTujuan){
//        $token= ambilTokenLokal() ?: return null
        $idUserTujuanEn= self::userTujuanEn($token, $idUserTujuan);

        return _Alias::$URL_DOMAIN ."/scan/?" ._Alias::$lain[0] ."=$token&$idUserTujuanEn";
    }
    static function tukarUrl(string $token, string $idUserTujuan, string $idItem){
//        $token= ambilTokenLokal() ?: return null
        $idUserTujuanEn= self::userTujuanEn($token, $idUserTujuan);
        $idItemEn= self::itemEn($token, $idItem);

        return _Alias::$URL_DOMAIN ."/tukar/?" ._Alias::$lain[0] ."=$token&$idUserTujuanEn&$idItemEn";
    }
    static function cekUrl(string $token, string $idUserTujuan){
//        $token= ambilTokenLokal() ?: return null
        $idUserTujuanEn= self::userTujuanEn($token, $idUserTujuan);

        return _Alias::$URL_DOMAIN ."/cek/?" ._Alias::$lain[0] ."=$token&$idUserTujuanEn";
    }
    static function liatUrl(string $token, string $jenisDaftar){
//        $token= ambilTokenLokal() ?: return null
        $jenisDaftarEn= self::liatEn($token, $jenisDaftar);

        return _Alias::$URL_DOMAIN ."/liat/?" ._Alias::$lain[0] ."=$token&$jenisDaftarEn";
    }
    static function masukUrl(string $uname, string $pass) {
//        $token= ambilTokenLokal() ?: return null
        $uname= self::unameEn($uname);
        $pass= self::passEn($pass);

        return _Alias::$URL_DOMAIN ."/tukar/?$uname&$pass";
    }
    static function keluar(string $token) {
//        $token= ambilTokenLokal() ?: return null

        return _Alias::$URL_DOMAIN ."/keluar/?" ._Alias::$lain[0] ."=$token";
    }
}
?>