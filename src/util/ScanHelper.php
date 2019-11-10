<?php
namespace ise\barscan\util;
use ise\barscan\util\debug\Debug;

use ise\barscan\pref\_DB as _DB;
use ise\barscan\pref\_NamaTabel as _NamaTabel;
use ise\barscan\pref\_Peran as _Peran;
use ise\barscan\pref\_Skor;
use ise\barscan\pref\model\PenukaranModel;
use ise\barscan\pref\model\Peserta as Peserta;
use ise\barscan\pref\model\Peran;
use ise\barscan\pref\model\ScanModel as ScanModel;
use ise\barscan\util\DbHelper as DbHelper;
use ise\barscan\util\SkorHelper as SkorHelper;
use ise\barscan\util\QueryBuilder as Query;
use ise\barscan\pref\model\Item;
use ise\barscan\pref\model\LoginModel;
use ise\barscan\pref\model\PesertaModel;

/**
 * Sayangnya yg hanya bisa tercata
 */
class ScanHelper{
    var $dbHelperScan;
    var $dbHelperPenukaran;
    var $dbHelperLogin;
    var $dbHelperPeserta;
    var $skorHelper;

    static $batasMaksStartup= 1;
    static $batasMaksGame= 5;

    function __construct(){
        $this->dbHelperScan= new DbHelper(_DB::$server, _DB::$uname,
                _DB::$pass, _DB::$db, _NamaTabel::$scan);
        $this->dbHelperPenukaran= new DbHelper(_DB::$server, _DB::$uname,
                _DB::$pass, _DB::$db, _NamaTabel::$penukaran);
        $this->dbHelperLogin= new DbHelper(_DB::$server, _DB::$uname,
                _DB::$pass, _DB::$db, _NamaTabel::$login);
        $this->dbHelperPeserta= new DbHelper(_DB::$server, _DB::$uname,
                _DB::$pass, _DB::$db, _NamaTabel::$peserta);
        $this->skorHelper= new SkorHelper();
    }

    /**
     * Saat pengunjung di-scan barcodenya untuk menukarkan skor dg item
     */
    function scanKurang(Item $item, string $idUserTujuan){
        if(!$this->cekIdUserTujuanAda($idUserTujuan))
            return _Peran::$GAK_ADA;
        //#1. Kurangi skor pengunjung
        $skorKurang= $item->harga;
        $hasilSkor= $this->skorHelper->kurangi($idUserTujuan, $skorKurang);

        if($hasilSkor === _Skor::$SKOR_KURANG)
            return $hasilSkor;

        //#2. Catat pada tabel Penukaran
        $this->tambahPenukaran($item->id, $idUserTujuan);
        return $hasilSkor;
    }
    function tambahPenukaran(string $idItem, string $idUserTujuan){
        $timestamp= Waktu::skrg();

        $sql= new QueryBuilder();
        $sql->insertInto(_NamaTabel::$penukaran)
            ->value([PenukaranModel::$timestamp, PenukaranModel::$fk_pengunjung, PenukaranModel::$fk_item],
                [$timestamp, $idUserTujuan, $idItem]
            );
        $sql= $sql->stringQuery();
        $sqlConn= $this->dbHelperPenukaran->openConnection();
        return $sqlConn->query($sql);
    }

    function ambilSemuaPenukaran(){
        $sql= new QueryBuilder();
        $sql->select("*")
            ->from(_NamaTabel::$penukaran);
        $sql= $sql->stringQuery();
        $sqlConn= $this->dbHelper->openConnection();
        return $sqlConn->query($sql);
    }
    function scanTambah(Peserta $penscan, Peran $peran, string $idUserTujuan){
        $skorTambah= $peran->skor_beri;
        $namaPeran= $peran->nama;
        $idDari= $penscan->id;
        Debug::echoe("peran = $namaPeran <br>");
        if(!$this->cekIdUserTujuanAda($idUserTujuan))
            return _Peran::$GAK_ADA;
        if(strtoupper($namaPeran) === _Peran::$GAME){
            if(!$this->scanMshTersedia($idDari, $idUserTujuan, self::$batasMaksGame))
                return _Skor::$BATAS_MAKS;
        } else if(strtoupper($namaPeran) === _Peran::$STARTUP){
            if(Waktu::udahJam4())
                return _Peran::$GAK_ADA;
            if(!$this->scanMshTersedia($idDari, $idUserTujuan, self::$batasMaksStartup))
                return _Skor::$UDAH_ADA;
            else
                $this->skorHelper->tambah($idDari, $skorTambah);
        } else
            return _Peran::$GAK_ADA;

        $this->tambahScan($penscan, $idUserTujuan);
        return $this->skorHelper->tambah($idUserTujuan, $skorTambah);
    }
/*
    function scanTambah(Peserta $penscan, string $idUserTujuan){
        $skorTambah= 0;
        $peran= $penscan->nama_peran;
        Debug::echoe("peran = $peran <br>");
        if(strtoupper($peran) === _Peran::$GAME)
            $skorTambah= _Peran::$SKOR_BERI_GAME;
        else if(strtoupper($peran) === _Peran::$STARTUP){
            $idDari= $penscan->id;
            if($this->scanMshTersedia($idDari, $idUserTujuan))
                return _Skor::$UDAH_ADA;
            else{
                $skorTambah= _Peran::$SKOR_BERI_STARTUP;
                $this->skorHelper->tambah($idDari, $skorTambah);
            }
        } else 
            return _Peran::$GAK_ADA;

        $this->tambahScan($penscan, $idUserTujuan);
        return $this->skorHelper->tambah($idUserTujuan, $skorTambah);
    }
*/
    //--BELUM
    function tambahScan(Peserta $penscan, string $idUserTujuan){
        $timestamp= Waktu::skrg(); //date('Y-m-d H:i:s', time());
        $sqlInsert= new Query();
        $sqlInsert->insertInto(_NamaTabel::$scan)
            ->value([ScanModel::$timestamp, ScanModel::$fk_peserta_dari, ScanModel::$fk_peserta_ke],
                [$timestamp, $penscan->id, $idUserTujuan]);
        $sqlInsert= $sqlInsert->stringQuery();
        $sqlInsertConn= $this->dbHelperScan->openConnection();

        return $sqlInsertConn->query($sqlInsert);
    }

    function cekIdUserTujuanAda(string $idUserTujuan){
        $sqlPeserta= new Query();
        $sqlPeserta->select("*")
            ->from(_NamaTabel::$peserta)
            ->where(PesertaModel::$id ." = $", [$idUserTujuan]);
        $sqlPeserta= $sqlPeserta->stringQuery();
        $sqlScanConn= $this->dbHelperPeserta->openConnection();
        $hasil= $sqlScanConn->query($sqlPeserta);
        $ada= mysqli_num_rows($hasil) === 1;
        $peran= "";
        if($ada){
            $peranAssoc= $hasil->fetch_assoc();
            $peran= $peranAssoc["fk_peran"];
        }
        return $ada && in_array(strtoupper($peran), _Peran::$ID_PENGUNJUNG);
    }
    function scanMshTersedia(string $idDari, string $idKe, int $batas): bool{
        $sqlScan= new Query();
        $sqlScan->select("*")
            ->from(_NamaTabel::$scan)
            ->where(ScanModel::$fk_peserta_dari ." = $ AND " .ScanModel::$fk_peserta_ke ." = $",
                [$idDari, $idKe]);
        $sqlScan= $sqlScan->stringQuery();
        $sqlScanConn= $this->dbHelperScan->openConnection();
        $hasil= $sqlScanConn->query($sqlScan);
        return mysqli_num_rows($hasil) < $batas;
    }
    
    function updateAktTrahir(string $token, string $timestamp= null){
        if($timestamp == null)
            $timestamp= Waktu::skrg();

        $sqlLogin= new Query();
        $sqlLogin->update(_NamaTabel::$login)
            ->set(LoginModel::$akt_trahir ." = $", [$timestamp])
            ->where(LoginModel::$token ." = $", [$token]);
        $sqlLogin= $sqlLogin->stringQuery();
        $sqlLoginConn= $this->dbHelperLogin->openConnection();
        return $sqlLoginConn->query($sqlLogin);
    }
}
?>