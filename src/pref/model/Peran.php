<?php
namespace ise\barscan\pref\model;
use ise\barscan\util\debug\Debug;

class Peran{
    var $id;
    var $nama;
    var $skor_beri;

    function __construct(string $id, string $nama, int $skor_beri){
        $this->id= $id;
        $this->nama= $nama;
        $this->skor_beri= $skor_beri;
    }
}
?>