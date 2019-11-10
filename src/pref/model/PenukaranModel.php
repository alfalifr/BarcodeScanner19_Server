<?php
namespace ise\barscan\pref\model;
use ise\barscan\util\debug\Debug;

class PenukaranModel extends Model{
    static $table= "Penukaran";
    
    static $timestamp= "timestamp";
    static $fk_pengunjung= "fk_pengunjung";
    static $fk_item= "fk_item";
}
?>