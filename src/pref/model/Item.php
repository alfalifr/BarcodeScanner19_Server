<?php
namespace ise\barscan\pref\model;
use ise\barscan\util\debug\Debug;

class Item{
    var $id;
    var $nama;
    var $harga;

    function __construct(string  $id, string $nama, int $harga){
        $this->id= $id;
        $this->nama= $nama;
        $this->harga= $harga;
    }
}
?>