<?php
namespace ise\barscan\util\debug;

class Debug{
    static $debug= true;
    static $respon= true;
    static $dummy= true;
    static $dummyId= "ID%";
    static function echoe($pesan){
        if(Debug::$debug)
            echo $pesan;
    }
    
    static function echoa($pesan){
        if(Debug::$respon)
            echo $pesan;
    }

    static function var_dumpe($mixed){
        if(Debug::$debug)
            var_dump($mixed);
    }
}
?>