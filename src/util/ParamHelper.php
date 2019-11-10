<?php
//Belum Fix
namespace ise\barscan\util;
use ise\barscan\util\debug\Debug;

use ise\barscan\pref\_Alias;

class ParamHelper{
    //--BELUM generalisasi dg enkripParam()
    /**
     * Tidak termasuk mengembalikan $token di dalam array.
     */
    static function ambilParam(array $param, array $diambil): array {
        $tabela= _Alias::$tabela;
        $token= $param[_Alias::$lain[0]];
        $keyPointerStr= substr($token,
            TokenHelper::$keyPointerIndMin, TokenHelper::$keyPointerIndMax);
        
        $mwawmNama= _Alias::$lain[5];
        $dakseidNama= _Alias::$lain[6];
//        $memberlakuNama= _Alias::$lain[1];
//        $memberlakuInd= $keyPointerStr[0];
        $memberlakuK= _Alias::$memberlakuK; //$token[array_search($memberlakuInd, $tabela)];

        $hambaNama= _Alias::$lain[2];
        $hambaInd= $keyPointerStr[1];
        $hambaK= $token[array_search($hambaInd, $tabela)];
//        echo "hambaK= $hambaK";

        $indeksNama= _Alias::$lain[3];
        $indeksInd= $keyPointerStr[2];
        $indeksK= $token[array_search($indeksInd, $tabela)];

        $slulupNama= _Alias::$lain[4];
        $slulupInd= $keyPointerStr[3];
        $slulupK= $token[array_search($slulupInd, $tabela)];
/*
        $memberlakuNama= $opr($memberlakuNama, $memberlakuK);
        $hambaNama= $opr($hambaNama, $hambaK);
        $indeksNama= $opr($indeksNama, $indeksK);
        $slulupNama= $opr($slulupNama, $slulupK);
*/

//        $memberlakuNamaEn= "";
        $mwawmNamaEn= "";
        $dakseidNamaEn= "";
        $hambaNamaEn= "";
        $indeksNamaEn= "";
        $slulupNamaEn= "";
/*
        if(in_array($memberlakuNama, $diambil))
            $memberlakuNamaEn= TokenHelper::enkrip($memberlakuNama, $memberlakuK);
*/            
        if(in_array($mwawmNama, $diambil))
            $mwawmNamaEn= TokenHelper::enkrip($mwawmNama, $memberlakuK);
        if(in_array($dakseidNama, $diambil))
            $dakseidNamaEn= TokenHelper::enkrip($dakseidNama, $memberlakuK);
        if(in_array($hambaNama, $diambil))
            $hambaNamaEn= TokenHelper::enkrip($hambaNama, $hambaK);
        if(in_array($indeksNama, $diambil))
            $indeksNamaEn= TokenHelper::enkrip($indeksNama, $indeksK);
        if(in_array($slulupNama, $diambil))
            $slulupNamaEn= TokenHelper::enkrip($slulupNama, $slulupK);
        
//        $memberlakuNilai= $param[$memberlakuNamaEn];
        $mwawmNilai= $param[$mwawmNamaEn];
        $dakseidNilai= $param[$dakseidNamaEn];
        $hambaNilai= $param[$hambaNamaEn];
        $indeksNilai= $param[$indeksNamaEn];
        $slulupNilai= $param[$slulupNamaEn];
        
//        $memberlakuNilai= TokenHelper::dekrip($memberlakuNilai, $memberlakuK);
        $mwawmNilai= TokenHelper::dekrip($mwawmNilai, $memberlakuK);
        $dakseidNilai= TokenHelper::dekrip($dakseidNilai, $memberlakuK);
        $hambaNilai= TokenHelper::dekrip($hambaNilai, $hambaK);
        $indeksNilai= TokenHelper::dekrip($indeksNilai, $indeksK);
        $slulupNilai= TokenHelper::dekrip($slulupNilai, $slulupK);

        $arrayKey= [
//            $memberlakuNama,
            $mwawmNama,
            $dakseidNama,
            $hambaNama,
            $indeksNama,
            $slulupNama
        ];
        $arrayNilai= [
//            $memberlakuNilai,
            $mwawmNilai,
            $dakseidNilai,
            $hambaNilai,
            $indeksNilai,
            $slulupNilai
        ];

        $array= ParamHelper::masukanKeArray($arrayKey, $arrayNilai);
        return $array;
    }

    //--BELUM generalisasi dg ambilParam()
    static function enkripParam(string $token, array $nilai): array {
        $tabela= _Alias::$tabela;
        $keyPointerStr= substr($token,
            TokenHelper::$keyPointerIndMin, TokenHelper::$keyPointerIndMax);
        
//        $memberlakuNama= _Alias::$lain[1];
        $mwawmNama= _Alias::$lain[5];
        $dakseidNama= _Alias::$lain[6];
//        $memberlakuInd= $keyPointerStr[0];
        $memberlakuK= _Alias::$memberlakuK; //$token[array_search($memberlakuInd, $tabela)];
        
        $hambaNama= _Alias::$lain[2];
        $hambaInd= $keyPointerStr[1];
        $hambaK= $token[array_search($hambaInd, $tabela)];

        $indeksNama= _Alias::$lain[3];
        $indeksInd= $keyPointerStr[2];
        $indeksK= $token[array_search($indeksInd, $tabela)];

        $slulupNama= _Alias::$lain[4];
        $slulupInd= $keyPointerStr[3];
        $slulupK= $token[array_search($slulupInd, $tabela)];
        
//        $memberlakuNilai= $nilai[$memberlakuNama];
        $mwawmNilai= $nilai[$mwawmNama];
        $dakseidNilai= $nilai[$dakseidNama];
        $hambaNilai= $nilai[$hambaNama];
        $indeksNilai= $nilai[$indeksNama];
        $slulupNilai= $nilai[$slulupNama];
        
//        $memberlakuNamaEn= null;
        $mwawmNamaEn= null;
        $dakseidNamaEn= null;
        $hambaNamaEn= null;
        $indeksNamaEn= null;
        $slulupNamaEn= null;
/*
        if(isset($memberlakuNilai))
            $memberlakuNamaEn= TokenHelper::enkrip($memberlakuNama, $memberlakuK);
*/            
        if(isset($mwawmNilai))
            $mwawmNamaEn= TokenHelper::enkrip($mwawmNama, $memberlakuK);
        if(isset($dakseidNilai))
            $dakseidNamaEn= TokenHelper::enkrip($dakseidNama, $memberlakuK);
        if(isset($hambaNilai))
            $hambaNamaEn= TokenHelper::enkrip($hambaNama, $hambaK);
        if(isset($indeksNilai))
            $indeksNamaEn= TokenHelper::enkrip($indeksNama, $indeksK);
        if(isset($slulupNilai))
            $slulupNamaEn= TokenHelper::enkrip($slulupNama, $slulupK);

//        $memberlakuNilai= TokenHelper::enkrip($memberlakuNilai, $memberlakuK);
        $mwawmNilai= TokenHelper::enkrip($mwawmNilai, $memberlakuK);
        $dakseidNilai= TokenHelper::enkrip($dakseidNilai, $memberlakuK);
        $hambaNilai= TokenHelper::enkrip($hambaNilai, $hambaK);
        $indeksNilai= TokenHelper::enkrip($indeksNilai, $indeksK);
        $slulupNilai= TokenHelper::enkrip($slulupNilai, $slulupK);
        
        $arrayKey= [
//            $memberlakuNamaEn,
            $mwawmNamaEn,
            $dakseidNamaEn,
            $hambaNamaEn,
            $indeksNamaEn,
            $slulupNamaEn
        ];
        $arrayNilai= [
//            $memberlakuNilai,
            $mwawmNilai,
            $dakseidNilai,
            $hambaNilai,
            $indeksNilai,
            $slulupNilai
        ];

        $array= ParamHelper::masukanKeArray($arrayKey, $arrayNilai);
        return $array;
    }

    
    static function masukanKeArray(array $key, array $nilai): array {
        $array= [];
        $batas= count($key);
        for($i= 0; $i < $batas; $i++)
            if(isset($key[$i]) && isset($nilai[$i]))
                $array[$key[$i]] = $nilai[$i];
        return $array;
    }


/*
    static function generateToken(): string{
        $token = "";
        $charLen = count(_Alias::$tabela) - 1;
        $tokenLen= mt_rand(ParamHelper::$tokenLenMin, ParamHelper::$tokenLenMax);

        //#1. Generate Key Pointer
//        if(count($keyPointerArray) <= 0)
        $keyPointerArray= ParamHelper::generateKeyPointer($tokenLen);

        //#2. Susun array key pointer jadi array
        $keyPointerStr= "";
        foreach($keyPointerArray as $keyPointer){
            if(strlen($keyPointer) == 1)
                $keyPointer= ParamHelper::$charHuruf[mt_rand(0, 9)] .$keyPointer;
            $keyPointerStr .= $keyPointer;
        }

        //#3. Susun string token scr keseleruhan
        //#3.1. Susun string sblum Key Pointer
        for ($i = 0; $i < TokenHelper::$keyPointerIndMin; $i++) {
            if(!in_array($i, $keyPointerArray))
                $token .= _Alias::$tabela[mt_rand(0, $charLen)];
            else
                $token .= ParamHelper::$charAngka[mt_rand(1, 9)];
        }
        //#3.2. Susun string dg Key Pointer
        $token .= $keyPointerStr;
        //#3.3. Susun string stelah Key Pointer
        for ($i = TokenHelper::$keyPointerIndMax +1; $i < $tokenLen; $i++) {
            if(!in_array($i, $keyPointerArray))
                $token .= _Alias::$tabela[mt_rand(0, $charLen)];
            else
                $token .= ParamHelper::$charAngka[mt_rand(1, 9)];
        }
        
        Debug::var_dumpe($keyPointerArray);
        Debug::echoe("<br>");
        foreach($keyPointerArray as $ind){
            Debug::echoe("[$ind] => " .$token[$ind] ."<br>");
        }

        return $token;
    }

    static function generateKeyPointer(int $tokenLen): array{
        $randInd= 7;
        $hasil= [];
        $tokenLen -= 1;
        for($i= 0; $i < TokenHelper::$keyPointerIndCount; $i++){
            do{
                $randInd= random_int(0, $tokenLen);
            } while($randInd >= 7 && $randInd <= 14);
            array_push($hasil, $randInd);
        }
        return $hasil;
    }
* /
    static function param(array $param, $opr) {
        $token= $param[_Alias::$lain[0]];
        $keyPointerStr= substr($token,
            TokenHelper::$keyPointerIndMin, TokenHelper::$keyPointerIndMax);
        
        $memberlakuNama= _Alias::$lain[1];
        $memberlakuInd= substr($keyPointerStr, 0, 2);
        $memberlakuK= substr($keyPointerStr, 0, 2);
        $hambaNama= _Alias::$lain[2];
        $hambaK= substr($keyPointerStr, 2, 4);
        $indeksNama= _Alias::$lain[3];
        $indeksK= substr($keyPointerStr, 4, 6);
        $slulupNama= _Alias::$lain[4];
        $slulupK= substr($keyPointerStr, 6, 8);

        $memberlakuNama= $opr($memberlakuNama)
    }

    private static function geser(string $param, string $k, $opr): string{
        $hasil= "";
        $batas= strlen($param);

        if(!is_numeric($k))
            $k= $k[1];

        for($i= 0; $i < $batas; $i++){
            $indChar= array_search($param[$i], _Alias::$tabela);
            $indChar= $opr($indChar, $k);
            //$indChar= ($indChar -$k) % $pjgTabela;
            $hasil .= _Alias::$tabela[$indChar];
        }
        return $hasil;
    }
    static function enkrip(string $param, string $k): string{
        $pjgTabela= count(_Alias::$tabela);

        return ParamHelper::geser($param, $k, 
            function($indChar, $k) use ($pjgTabela) {
                return ($indChar +$k) % $pjgTabela;
            });
    }
    static function dekrip(string $param, string $k): string{
        $pjgTabela= count(_Alias::$tabela);

        Debug::echoe("pjgTabela = $pjgTabela <br>"); 

        return ParamHelper::geser($param, $k, 
            function($indChar, $k) use ($pjgTabela) {
                $hasil= ($indChar -$k) % $pjgTabela;
                if($hasil < 0)
                    return $pjgTabela + $hasil;
                else
                    return $hasil;
            });
    }
*/    
}
?>