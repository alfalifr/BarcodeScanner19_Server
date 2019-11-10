<?php
namespace ise\barscan\util;
use ise\barscan\util\debug\Debug;

class Waktu{
    public function __contruct(){
        atur_time_zone('Asia/Jakarta');
    }

    public static function timeZone(){
        $timezone = date_default_timezone_get();
        return 'The current server timezone is: ' .$timezone;
    }

    public static function timeZoneTersedia(){
        $timezone_identifiers = DateTimeZone::listIdentifiers();

        foreach($timezone_identifiers as $key => $list)
            Debug::echoe($list . '<br/>');
    }

    public static function aturTimeZone($timezone){
        //'America/Los_Angeles'
        date_default_timezone_set($timezone);
    }

    static function skrg(){
        return date('Y-m-d H:i:s', time());
    }
    
    static function skrgJam(){
        return date('H', time());
    }

    static function udahJam4(){
        return self::skrg() >= 16;
    }
}
?>