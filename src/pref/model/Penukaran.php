<?php
namespace ise\barscan\pref\model;
use ise\barscan\util\debug\Debug;

class Penukaran{
    var $timestamp;
    var $fk_pengunjung;
    var $fk_item;

    function __construct($timestamp, string $fk_pengunjung, string $fk_item){
        $this->timestamp= $timestamp;
        $this->fk_pengunjung= $fk_pengunjung;
        $this->$fk_item= $fk_item;
    }
}
?>