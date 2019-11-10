<?php
namespace ise\barscan\pref\model;
use ise\barscan\util\debug\Debug;

class PesertaModel extends Model{
    static $table= "Peserta";
    
    static $id= "id";
    static $uname= "uname";
    static $pass= "pass";
    static $skor= "skor";
    static $fk_peran= "fk_peran";
//    static $nama_peran= "nama_peran";
/*    
    static $attrib= [
        "id: string", "pass: string", "skor: int", "fk_peran"
    ];
    static $prefixValue= [

    ];
*/
}
?>