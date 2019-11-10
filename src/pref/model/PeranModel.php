<?php
namespace ise\barscan\pref\model;
use ise\barscan\util\debug\Debug;

class PeranModel extends Model{
    static $table= "Peran";

    static $id= "id";
    static $nama= "nama";
    static $skor_beri= "skor_beri";

    static $prefix_id= "ROLE";

/*    
    static $dataType= [
        $attrib[$id] => "string",
        $attrib[$nama] => "string",
        $attrib[$nama] => "int"
    ];
*/    
}
?>