<?php
namespace ise\barscan\util;
use ise\barscan\util\debug\Debug;

use ise\barscan\pref\_DB as _DB;
use ise\barscan\pref\_NamaTabel;
use ise\barscan\pref\model\Login;
use ise\barscan\pref\model\LoginModel as LoginModel;
use ise\barscan\pref\model\Peran;
use ise\barscan\pref\model\PeranModel;
use ise\barscan\pref\model\Peserta;
use ise\barscan\pref\model\PesertaModel;
use ise\barscan\pref\model\Model;

//--BELUM ujicoba
class KepenggunaanHelper{
    static $batasLogin= 3;
    var $dbHelperLogin;
    var $dbHelperPeserta;

    function __construct(){
        $this->dbHelperLogin= new DbHelper(_DB::$server, _DB::$uname,
                _DB::$pass, _DB::$db, _NamaTabel::$login);
        $this->dbHelperPeserta= new DbHelper(_DB::$server, _DB::$uname,
                _DB::$pass, _DB::$db, _NamaTabel::$peserta);
    }
    
/*
===================
Bagian Tabel Login
===================
*/

    /**
     * return true jika tidak melebihi batas
     */
    function cekJmlLogin(string $idUser): bool{
        $sql= new QueryBuilder();
        $sql->select("COUNT(*) as jml")
            ->from(_NamaTabel::$login)
            ->where(LoginModel::$fk_user ." = $", [$idUser]);
        $sql= $sql->stringQuery();
        $sqlConn= $this->dbHelperLogin->openConnection();
        $sqlHasil= $sqlConn->query($sql);
        $sqlHasil= mysqli_fetch_assoc($sqlHasil);

        return $sqlHasil["jml"] < self::$batasLogin;
    }

    function cariLogin(string $token){
        $sql= new QueryBuilder();
        $sql->select("*")
            ->from(_NamaTabel::$login)
            ->where(LoginModel::$token ." = $", [$token]);
        $sql= $sql->stringQuery();
        $sqlConn= $this->dbHelperLogin->openConnection();
        return $sqlConn->query($sql);
    }

    function tokenAda($token): bool{
        if($token == null)
            return false;
        $sqlHasil= $this->cariLogin($token);
        return mysqli_num_rows($sqlHasil) > 0;
    }

    function tambahLogin(string $token, string $idUser){
        if(!$this->cekJmlLogin($idUser))
            return null;
        $login_pas= Waktu::skrg();
        $akt_trahir= Waktu::skrg();

        $sql= new QueryBuilder();
        $sql->insertInto(_NamaTabel::$login)
            ->value(["fk_user", "token", "login_pas", "akt_trahir"],
                [$idUser, $token, $login_pas, $akt_trahir]);
        $sql= $sql->stringQuery();
        $sqlConn= $this->dbHelperLogin->openConnection();
        $sqlHasil= $sqlConn->query($sql);
        
        return $sqlHasil;
    }

    function ambilSemuaLogin(){
        $sql= new QueryBuilder();
        $sql->select("*")
            ->from(_NamaTabel::$login);
        $sql= $sql->stringQuery();
        $sqlConn= $this->dbHelperLogin->openConnection();
        return $sqlConn->query($sql);
    }
    
    static function jadikanLoginModel($hasilQuery) {
        return Model::jadikanModel(
            $hasilQuery,
            function($row){
                return new Login(
                    $row[LoginModel::$fk_user],
                    $row[LoginModel::$token],
                    $row[LoginModel::$login_pas],
                    $row[LoginModel::$akt_trahir]
                );
            }
        );
    }

/*
===================
Bagian Tabel Peserta
===================
*/
    function cariPeserta(string $uname, string $pass){
//        $pass= sha1($pass);
        $sql= new QueryBuilder();
        $sql->select("*")
            ->from(_NamaTabel::$peserta)
            ->where(PesertaModel::$uname ." = $ AND " .PesertaModel::$pass ." = $",
                [$uname, $pass]);
        $sql= $sql->stringQuery();
        $sqlConn= $this->dbHelperPeserta->openConnection();
        return $sqlConn->query($sql);
    }

    function cariPesertaDgId(string $id){
        $sql= new QueryBuilder();
        $sql->select("*")
            ->from(_NamaTabel::$peserta)
            ->where(PesertaModel::$id ." = $", [$id]);
        $sql= $sql->stringQuery();
        $sqlConn= $this->dbHelperPeserta->openConnection();
        return $sqlConn->query($sql);
    }
    function cariPesertaDgToken(string $token){
        $login= $this->cariLogin($token);
        $login= mysqli_fetch_assoc($login);
        return $this->cariPesertaDgId($login[LoginModel::$fk_user]);
    }

    /**
     * Sebanding dg cariPeserta(), namun terdapat pengecekan cekJmlLogin()
     * dan mengembalikan dalam bentuk model.
     */
    function login(string $uname, string $pass){
        $hasil= $this->cariPeserta($uname, $pass);
        $hasil= $this->jadikanPesertaModel($hasil);
        if(!$this->cekJmlLogin($hasil->id))
            return false;
        return $hasil;
    }

    function logout(string $token){
        $sql= new QueryBuilder();
        $sql->deleteFrom(_NamaTabel::$login)
            ->where(LoginModel::$token ." = $", [$token]);
        $sql= $sql->stringQuery();
        $sqlConn= $this->dbHelperPeserta->openConnection();
        return $sqlConn->query($sql);
    }
    
    function ambilSemuaPeserta(){
        $sql= new QueryBuilder();
        $sql->select("*")
            ->from(_NamaTabel::$peserta);
        if(!Debug::$dummy)
            $sql->where(PesertaModel::$id ." NOT LIKE $", [Debug::$dummyId]);
        $sql= $sql->stringQuery();
        $sqlConn= $this->dbHelperPeserta->openConnection();
        return $sqlConn->query($sql);
    }
/*    
    function login(string $uname, string $pass): bool{
        $hasil= $this->cariPeserta($uname, $pass);
        return mysqli_num_rows($hasil) > 0;
    }
*/    
    static function jadikanPesertaModel($hasilQuery) {
        return Model::jadikanModel(
            $hasilQuery,
            function($row){
                return new Peserta(
                    $row[PesertaModel::$id],
                    $row[PesertaModel::$uname],
                    $row[PesertaModel::$pass],
                    (int) $row[PesertaModel::$skor],
                    $row[PesertaModel::$fk_peran]
//                    $row[PesertaModel::$nama_peran]
                );
            }
        );
    }
    
/*
===================
Bagian Tabel Peran
===================
*/
    function cariPeran(string $id){
        $sql= new QueryBuilder();
        $sql->select("*")
            ->from(_NamaTabel::$peran)
            ->where(PeranModel::$id ." = $", [$id]);
        $sql= $sql->stringQuery();
        $sqlConn= $this->dbHelperPeserta->openConnection();
        return $sqlConn->query($sql);
    }

    function cariSkorBeriPeran(string $id): int{
        $hasil= $this->cariPeran($id);
        $hasil= mysqli_fetch_assoc($hasil);
        return (int) $hasil[PeranModel::$skor_beri];
    }

    function ambilSemuaPeran(){
        $sql= new QueryBuilder();
        $sql->select("*")
            ->from(_NamaTabel::$peran);
        if(Debug::$dummy)
            $sql->where(PeranModel::$id ." NOT LIKE $", [Debug::$dummyId]);
        $sql= $sql->stringQuery();
        $sqlConn= $this->dbHelperPeserta->openConnection();
        return $sqlConn->query($sql);
    }

    static function jadikanPeranModel($hasilQuery) {
        return Model::jadikanModel(
            $hasilQuery,
            function($row){
                return new Peran(
                    $row[PeranModel::$id],
                    $row[PeranModel::$nama],
                    (int) $row[PeranModel::$skor_beri]
                );
            }
        );
    }
}
?>