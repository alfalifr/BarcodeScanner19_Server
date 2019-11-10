<?php
namespace ise\barscan\pref\model;
use ise\barscan\util\debug\Debug;

class ItemModel extends Model{
    static $table= "Item";

    static $id= "id";
    static $nama= "nama";
    static $harga= "harga";

    static $prefix_id= "ITEM";
}
?>