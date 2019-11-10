<?php
    /**
     * Transaksi DB tidak diperlukan karena scr logis,
     * pengungjung tidak mungkin bermain dan menukarkan poin dg hadiah scr bersamaan.
     */
namespace ise\barscan\util;
use ise\barscan\util\debug\Debug;

use ise\barscan\pref\_DB as _DB;
use ise\barscan\pref\_NamaTabel as _NamaTabel;
use ise\barscan\pref\_Skor;
use ise\barscan\pref\model\PesertaModel as PesertaModel;
use ise\barscan\util\DbHelper as DbHelper;
use ise\barscan\util\QueryBuilder as Query;

foreach(glob('dir/*.php') as $file) {
    include_once $file;
}

class SkorHelper{
    var $dbHelper;

    function __construct(){
        $this->dbHelper= new DbHelper(_DB::$server, _DB::$uname,
                _DB::$pass, _DB::$db, _NamaTabel::$peserta);
    }

    function update(string $idUser, string $operator, int $skorBeda){
/*        
        $sql= new DQuery();
        $sql->table(PesertaModel::$table)
            ->where(PesertaModel::$id, "=", $idUser)
            ->field(PesertaModel::$skor); //$this->dbConn->query("SELECT skor FROM peserta WHERE $idUser");
*/        
        //#1. Ambil skor lama
        $sqlSelect= new Query();
        $sqlSelect->select(PesertaModel::$skor)
            ->from(PesertaModel::$table)
            ->where(PesertaModel::$id ." = $", [$idUser]);
        $sqlSelect= $sqlSelect->stringQuery();

        //#2. Tambah skor lama dg skor baru
        $sqlSelectConn= $this->dbHelper->openConnection();
        $skorAwal= $sqlSelectConn->query($sqlSelect);
        $skorAwal= mysqli_fetch_assoc($skorAwal);
        $skorAwal= $skorAwal["skor"];
        
        if($operator === "+")
            $skorAkhir= $skorAwal +$skorBeda;
        else if($operator === "-")
            $skorAkhir= $skorAwal -$skorBeda;
        else
            return null;

        if($skorAkhir < 0)
            return _Skor::$SKOR_KURANG;

        //#3. Update skor baru di DB
        $sqlUpdate= new Query();
        $sqlUpdate->update(PesertaModel::$table)
            ->set(PesertaModel::$skor ." = $", [$skorAkhir])
            ->where(PesertaModel::$id ." = $", [$idUser]);
        $sqlUpdate= $sqlUpdate->stringQuery();

        $sqlUpdateConn= $this->dbHelper->openConnection();
        $hasil= $sqlUpdateConn->query($sqlUpdate);

        return $hasil;
    }

    function tambah(string $idUser, int $skor){
        return $this->update($idUser, "+", $skor);
    }

    function kurangi(string $idUser, int $skor){
        return $this->update($idUser, "-", $skor);
    }
}
?>