<?php
namespace ise\barscan\pref\model;
use ise\barscan\util\debug\Debug;

class Scan{
    var $timestamp;
    var $fk_peserta_dari;
    var $fk_peserta_ke;

    function __construct($timestamp, string $fk_peserta_dari, string $fk_peserta_ke){
        $this->timestamp= $timestamp;
        $this->fk_peserta_dari= $fk_peserta_dari;
        $this->fk_peserta_ke= $fk_peserta_ke;
    }
}
?>