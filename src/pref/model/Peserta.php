<?php
namespace ise\barscan\pref\model;
use ise\barscan\util\debug\Debug;

class Peserta{
    var $id;
    var $uname;
    var $pass;
    var $skor;
    var $fk_peran;

    function __construct(string $id, string $uname, string $pass, int $skor,
            string $fk_peran){
        $this->id= $id;
        $this->uname= $uname;
        $this->pass= $pass;
        $this->skor= $skor;
        $this->fk_peran= $fk_peran;
//        $this->nama_peran= $nama_peran;
    }
}
?>