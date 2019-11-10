<?php
namespace ise\barscan\util;
use ise\barscan\util\debug\Debug;

use ise\barscan\pref\_DB as _DB;
use ise\barscan\pref\_NamaTabel;
use ise\barscan\pref\model\Item;
use ise\barscan\pref\model\ItemModel;
use ise\barscan\pref\model\Model;

class ItemHelper{
    var $dbHelper;

    function __construct(){
        $this->dbHelper= new DbHelper(_DB::$server, _DB::$uname,
                _DB::$pass, _DB::$db, _NamaTabel::$item);
    }

    function cariItem(string $idItem){
        $sql= new QueryBuilder();
        $sql->select("*")
            ->from(_NamaTabel::$item)
            ->where(ItemModel::$id ." = $", [$idItem]);
        $sql= $sql->stringQuery();
        $sqlConn= $this->dbHelper->openConnection();
        return $sqlConn->query($sql);
    }

    function cariHargaItem(string $idItem): int{
        $hasil= $this->cariItem($idItem);
        $hasil= mysqli_fetch_assoc($hasil);
        return (int) $hasil[ItemModel::$harga];
    }

    function ambilSemuaItem(){
        $sql= new QueryBuilder();
        $sql->select("*")
            ->from(_NamaTabel::$item);
        if(!Debug::$dummy)
            $sql->where(ItemModel::$id ." NOT LIKE $", [Debug::$dummyId]);
        $sql= $sql->stringQuery();
        $sqlConn= $this->dbHelper->openConnection();
        return $sqlConn->query($sql);
    }

    static function jadikanModel($hasilQuery) {
        return Model::jadikanModel(
            $hasilQuery,
            function($row){
                return new Item(
                    $row[ItemModel::$id],
                    $row[ItemModel::$nama],
                    (int) $row[ItemModel::$harga]
                );
            }
        );
    }
}
?>