<?php
namespace ise\barscan\util;
use ise\barscan\util\debug\Debug;

use ise\barscan\pref\model\Model;

class LiatHelper{
    var $itemHelper;
    var $kepenggunaanHelper;
    var $scanHelper;

    function __construct(){
        $this->itemHelper= new ItemHelper();
        $this->kepenggunaanHelper= new KepenggunaanHelper();
        $this->scanHelper= new ScanHelper();
    }

    function liatDaftarItem(){
        $hasilQuery= $this->itemHelper->ambilSemuaItem();
        $hasilJson= Model::jadikanJson($hasilQuery);
        return $hasilJson;
    }
    
    function liatDaftarLogin(){
        $hasilQuery= $this->kepenggunaanHelper->ambilSemuaLogin();
        $hasilJson= Model::jadikanJson($hasilQuery);
        return $hasilJson;
    }
    
    function liatDaftarPeserta(){
        $hasilQuery= $this->kepenggunaanHelper->ambilSemuaPeserta();
        $hasilJson= Model::jadikanJson($hasilQuery);
        return $hasilJson;
    }
    
    function liatDaftarPenukaran(){
        $hasilQuery= $this->scanHelper->ambilSemuaPenukaran();
        $hasilJson= Model::jadikanJson($hasilQuery);
        return $hasilJson;
    }
    
    function liatDaftarPeran(){
        $hasilQuery= $this->kepenggunaanHelper->ambilSemuaPeran();
        $hasilJson= Model::jadikanJson($hasilQuery);
        return $hasilJson;
    }
}
?>