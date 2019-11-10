<?php
namespace ise\barscan\pref\model;

require '../vendor/autoload.php';
use ise\barscan\util\debug\Debug;

class Model{
    static $_table;
    static $attrib= [];
    static $prefixValue= [];
    var $nilai= [];

    static function jadikanModel($hasilQuery, $opr) {
        Debug::echoe("JadikanModel = <br>");
        Debug::var_dumpe($hasilQuery);
        Debug::echoe("JadikanModel = akhir <br>");
        Debug::echoe("<br>");
        if(!$hasilQuery)
            return false;
        else if(mysqli_num_rows($hasilQuery) == 1){
            $array= mysqli_fetch_assoc($hasilQuery);
            return $opr($array);
        } else{
            $arrayHasil= [];
            while($row= $hasilQuery->fetch_assoc()){
                array_push(
                    $arrayHasil, 
                    $opr($row)
                );
            }
            return $arrayHasil;
        }
    }

    static function jadikanJson($hasilQuery){
        Debug::echoe("JadikanJson = <br>");
        Debug::var_dumpe($hasilQuery);
        Debug::echoe("JadikanJson = akhir <br>");
        Debug::echoe("<br>");
        if(!$hasilQuery)
            return false;
        else if(mysqli_num_rows($hasilQuery) == 1){
            $array= mysqli_fetch_assoc($hasilQuery);
            return json_encode($array);
        } else{
            $arrayHasil= [];
            while($row= $hasilQuery->fetch_assoc()){
                array_push(
                    $arrayHasil, 
                    $row
                );
            }
            return json_encode($arrayHasil);
        }
    }
}
?>