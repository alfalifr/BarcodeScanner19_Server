<?php
namespace ise\barscan\util;
use ise\barscan\util\debug\Debug;

class Util{
    static function startsWith(string $str, string $substr, $casesntv= false): bool{
        if(!$casesntv){
            $str= strtoupper($str);
            $substr= strtoupper($substr);
        }
        return substr($str, 0, strlen($substr)) === $substr;
    }
}
?>