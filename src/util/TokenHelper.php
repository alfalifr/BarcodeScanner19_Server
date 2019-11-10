<?php
namespace ise\barscan\util;
use ise\barscan\util\debug\Debug;

use ise\barscan\pref\_Alias;

class TokenHelper{
    static $tokenLenMin= 37;
    static $tokenLenMax= 53;

    static $keyPointerIndMin= 7;
    static $keyPointerIndMax= 11;
    static $keyPointerIndCount= 4;

    static $charHuruf= "abcdefghijklmnopqrstuvwxyz"
                        ."ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    static $charAngka= "0123456789";
    
    static $charLengkap= "abcdefghijklmnopqrstuvwxyz"  //TokenHelper::$charHuruf .TokenHelper::$charAngka;
                        ."ABCDEFGHIJKLMNOPQRSTUVWXYZ"
                        ."0123456789";
                        
    static function generateToken(): string{
        $token = "";
        $charLen = count(_Alias::$tabela) - 1;
        $tokenLen= mt_rand(TokenHelper::$tokenLenMin, TokenHelper::$tokenLenMax);

        //#1. Generate Key Pointer
        $keyPointerArray= TokenHelper::generateKeyPointer($tokenLen);

        //#2. Susun array key pointer jadi array
        $keyPointerStr= "";
        foreach($keyPointerArray as $keyPointer)
            $keyPointerStr .= $keyPointer;

        //#3. Susun string token scr keseleruhan
        //#3.1. Susun string sblum Key Pointer
        for ($i = 0; $i < TokenHelper::$keyPointerIndMin; $i++)
            $token .= _Alias::$tabela[mt_rand(1, $charLen)];
        //#3.2. Susun string dg Key Pointer
        $token .= $keyPointerStr;
        //#3.3. Susun string stelah Key Pointer
        for ($i = TokenHelper::$keyPointerIndMax +1; $i < $tokenLen; $i++)
            $token .= _Alias::$tabela[mt_rand(1, $charLen)];
        
        Debug::var_dumpe($keyPointerArray);
        Debug::echoe("<br>");
/*        
        foreach($keyPointerArray as $ind){
            Debug::echoe("[$ind] => " .$token[$ind] ."<br>");
        }
*/
        return $token;
    }

    static function generateKeyPointer(int $tokenLen): array{
        $randInd= 7;
        $hasil= [];
        $tokenLen -= 1;
        
        $indMin= TokenHelper::$keyPointerIndMin;
        $indMax= TokenHelper::$keyPointerIndMax;

//        $tabela= _Alias::$tabela;
        $indAcak= 0;
        for($i= 0; $i < TokenHelper::$keyPointerIndCount; $i++){
            do{
                //$randInd= $tabela[mt_rand(0, $tokenLen)];
                $indAcak= mt_rand(1, $tokenLen);
            } while($indAcak >= $indMin && $indAcak <= $indMax);
            /*
                while(array_search($randInd, $tabela) >= 7
                && array_search($randInd, $tabela) <= 14);
            */  
            $randInd= _Alias::$tabela[$indAcak];
            array_push($hasil, $randInd);
        }
        return $hasil;
    }

    static function ambilKeyPointer(string $token): string{
        return substr($token,
            TokenHelper::$keyPointerIndMin,
            TokenHelper::$keyPointerIndMax);
    }
    static function ambilKey(string $token){
        $keyPointer= TokenHelper::ambilKeyPointer($token);
        $strKey= "";
        $tabela= _Alias::$tabela;
        $keyArray= [];
        for($i = 0; $i < strlen($keyPointer); $i++){
            $keyArray[$i]= array_search($keyPointer[$i], $tabela);
            //$keyArray[]
        }
        
        return $keyArray;
    }
    

    private static function geser($param, $k, $opr){
        if(!isset($param) || !isset($k))
            return null;
        $hasil= "";
        $batas= strlen($param);
        $ind= array_search($k, _Alias::$tabela);

        for($i= 0; $i < $batas; $i++){
            $indChar= array_search($param[$i], _Alias::$tabela);
            $indChar= $opr($indChar, $ind);
            //$indChar= ($indChar -$k) % $pjgTabela;
            $hasil .= _Alias::$tabela[$indChar];
        }
        return $hasil;
    }
    static function enkrip($param, $k){
        $pjgTabela= count(_Alias::$tabela);

        return TokenHelper::geser($param, $k, 
            function($indChar, $ind) use ($pjgTabela) {
                return ($indChar +$ind) % $pjgTabela;
            });
    }
    static function dekrip($param, $k){
        $pjgTabela= count(_Alias::$tabela);

        return TokenHelper::geser($param, $k, 
            function($indChar, $ind) use ($pjgTabela) {
                $hasil= ($indChar -$ind) % $pjgTabela;
                if($hasil < 0)
                    return $pjgTabela + $hasil;
                else
                    return $hasil;
            });
    }

/*    
    static $tokenLenMin= 37;
    static $tokenLenMax= 53;

    static $keyPointerIndMin= 7;
    static $keyPointerIndMax= 14;
    static $keyPointerIndCount= 4;

    static $charHuruf= "abcdefghijklmnopqrstuvwxyz"
                        ."ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    static $charAngka= "0123456789";
    
    static $charLengkap= "abcdefghijklmnopqrstuvwxyz"  //TokenHelper::$charHuruf .TokenHelper::$charAngka;
                        ."ABCDEFGHIJKLMNOPQRSTUVWXYZ"
                        ."0123456789";

    static function generateToken(string $keyPointerArray= ""): string{
        $token = "";
        $charLen = strlen(TokenHelper::$charLengkap) - 1;
        $tokenLen= mt_rand(TokenHelper::$tokenLenMin, TokenHelper::$tokenLenMax);

        //#1. Generate Key Pointer
        if(strlen($keyPointerArray) <= 0)
            $keyPointerArray= TokenHelper::generateKeyPointer($tokenLen-1);

        //#2. Susun array key pointer jadi array
        $keyPointerStr= "";
        foreach($keyPointerArray as $keyPointer){
            if(strlen($keyPointer) == 1)
                $keyPointer= TokenHelper::$charHuruf[mt_rand(0, 9)] .$keyPointer;
            $keyPointerStr .= $keyPointer;
        }

        //#3. Susun string token scr keseleruhan
        //#3.1. Susun string sblum Key Pointer
        for ($i = 0; $i < TokenHelper::$keyPointerIndMin; $i++) {
            if(!in_array($i, $keyPointerArray))
                $token .= TokenHelper::$charLengkap[mt_rand(0, $charLen)];
            else
                $token .= TokenHelper::$charAngka[mt_rand(0, 9)];
        }
        //#3.2. Susun string dg Key Pointer
        $token .= $keyPointerStr;
        //#3.3. Susun string stelah Key Pointer
        for ($i = TokenHelper::$keyPointerIndMax +1; $i < $tokenLen; $i++) {
            if(!in_array($i, $keyPointerArray))
                $token .= TokenHelper::$charLengkap[mt_rand(0, $charLen)];
            else
                $token .= TokenHelper::$charAngka[mt_rand(0, 9)];
        }

        return $token;
    }

    static function generateKeyPointer(int $tokenLen): array{
        $randInd= 7;
        $hasil= [];
        for($i= 0; $i < TokenHelper::$keyPointerIndCount; $i++){
            do{
                $randInd= random_int(0, $tokenLen);
            } while($randInd >= 7 && $randInd <= 14);
            array_push($hasil, $randInd);
        }
        return $hasil;
    }
*/    
}
?>