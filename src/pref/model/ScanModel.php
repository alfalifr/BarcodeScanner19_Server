<?php
namespace ise\barscan\pref\model;
use ise\barscan\util\debug\Debug;

class ScanModel extends Model{
    static $table= "Scan";

    static $timestamp= "timestamp";
    static $fk_peserta_dari= "fk_peserta_dari";
    static $fk_peserta_ke= "fk_peserta_ke";
}
?>