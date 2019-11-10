<?php
namespace ise\barscan\util;
use ise\barscan\util\debug\Debug;
use ReflectionClass;

class Filter{
    public $file;
    public $objek;

//STATIC=================    
    public static function include_file(string $nama_file) {
        if (is_file($nama_file)) {
            ob_start();
            include $nama_file;
            return ob_get_clean();
        }
        return false;
    }

    public static function buat_obj(string $kelas, array $konstruktor= null){
        $obj= (new ReflectionClass($kelas));
        if($konstruktor !== null)
            return $obj->newInstanceArgs($konstruktor);
        return $obj->newInstanceArgs();
    }


//KONTRUKTOR=================
    public function __construct(string $str_kelas_mentah) {
        $this->sumber_file($str_kelas_mentah);
    }
    
    public function sumber_file(string $str_kelas_mentah){
        $str_kelas_mentah= str_replace(" ", "", $str_kelas_mentah);
        $pjg_str_kelas_mentah= strlen($str_kelas_mentah);
        $kelas= $str_kelas_mentah;
        $kons= array();
        if(stripos($str_kelas_mentah, ')')){
            $str_kelas_mentah_diproses= substr($str_kelas_mentah/*$kelas_mentah*/, 0, $pjg_str_kelas_mentah-1);

            $kelas_mentah_array= explode($str_kelas_mentah_diproses, '(');
            $kelas= $kelas_mentah_array[0];
            $kons_mentah= $kelas_mentah_array[1];
            $kons_array= explode($kons_mentah, ',');
            foreach($kons_array as $per_kons)
                array_push($kons, $per_kons);
        }
        $file= $kelas;
        if(!stripos($file, '.php'))
            $file .= '.php';
        else
            $kelas= str_replace('.php', '', $kelas);

        $this->file= self::include_file($file);
        $this->objek= self::buat_obj($kelas, $kons);
    }

    public function panggil_fungsi(string $nama, ...$args){
        //return call_user_func(array($this->objek, $nama), $args[0], $args[1]);
        return call_user_func_array(array($this->objek, $nama), $args);
    }
}
?>