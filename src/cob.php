<?php
/*
spl_autoload_register(function ($class_name) {
    $name= $class_name . '.php';
    Debug::echoe($name);
    include $name;
});
include "lib/dsql/Query.php";
*/
require '../vendor/autoload.php';

use ise\barscan\pref\_Alias;
use ise\barscan\util\QueryBuilder as Query;
use ise\barscan\pref\_NamaTabel as _NamaTabel;
use ise\barscan\pref\model\PesertaModel as PesertaModel;
use ise\barscan\pref\model\Peserta as Peserta;
use ise\barscan\util\ParamHelper;
use ise\barscan\util\ScanHelper;
use ise\barscan\util\SkorHelper as SkorHelper;
use ise\barscan\util\TokenHelper as TokenHelper;
use ise\barscan\util\Filter as Filter;
use ise\barscan\util\debug\Debug;
use ise\barscan\util\ParamGenerator;


$urlMasuk= ParamGenerator::masukUrl("abidin3", "abcd");
Debug::echoe("urlMasuk = $urlMasuk <br>");


$token= "j!VJiqzv*k,vL!UkISNsoGrIApdx4GoXQY8F";

$scanUrl= ParamGenerator::scanUrl($token, "ID2");
Debug::echoe("urlScan = $scanUrl <br>");

$cekUrl= ParamGenerator::cekUrl($token, "ID2"); //::scanUrl($token, "ID2");
Debug::echoe("urlCek = $cekUrl <br>");

$tukarUrl= ParamGenerator::tukarUrl($token, "ID2", "ID2");
Debug::echoe("urlTukar = $tukarUrl <br>");

/*
$array= [];
$array["a"]= "aer";
$array[0]= "aeb";
//array_push($array, "a" => "aer");

Debug::echoe($array[0] ."<br>");
Debug::echoe($array["a"] ."<br>");

$a= "dsa";
$b= "asd";

if(isset($a)){
    Debug::echoe("a true <br>");
} else if(isset($b)){
    Debug::echoe("b true <br>");
}
Debug::echoe($b);

$array= [
    "a" => "ok",
    "c" => "ko"
];

$c= $array["b"];

if(isset($c)){
    Debug::echoe("c true <br>");
} else {
    Debug::echoe("c false <br>");
}

/*
====================================
Bagian ParamHelper
====================================
*/
//$keyPointerArray= TokenHelper::generateKeyPointer(TokenHelper::$tokenLenMax);
$token= TokenHelper::generateToken();

Debug::echoe($token ."<br>");
//Debug::var_dumpe($keyPointerArray);

Debug::echoe("<br>");

//$paramLain= _Alias::$lain["token"];
//Debug::echoe($paramLain ."<br>");


$strAw= "djgagak";
$strAkh= TokenHelper::enkrip($strAw, "A");
$strDe= TokenHelper::dekrip($strAkh, "A");
Debug::echoe($strAkh ."<br>");
Debug::echoe($strDe ."<br>");

$mod= (1-32) % 30;
Debug::echoe("mod = $mod <br>");

$arrayParam= [
    _Alias::$lain[1] => "scan",
    _Alias::$lain[2] => "ID2",
    _Alias::$lain[3] => "ID1",
    _Alias::$lain[4] => _NamaTabel::$item
];

$token= "dX-2QgWkTp'kYFUkEBiCFha9clJ_Xd9r!Lh-ZPPFZn"; //"5c1LveXlD5B*f_hwovqTH7GQd2TvKQv0Prp2r3";
$pjg= strlen($token);
Debug::echoe("token = $token <br>");
Debug::echoe("pjg = $pjg <br>");

$a= _Alias::$tabela[46];
Debug::echoe("tabela = $a <br>");
/*
$keyInd= TokenHelper::ambilKey($token);
Debug::echoe("<br> keyInd ==== <br>");
$jml= count($keyInd);
Debug::echoe("<br> jml = $jml <br>");
Debug::var_dumpe($keyInd);
Debug::echoe("<br> keyInd ==== akhir <br>");
*/
$arrayParamKeluar= ParamHelper::enkripParam($token, $arrayParam);
$arrayParamKeluar[_Alias::$lain[0]]= $token;

$arrayParamDekrip= ParamHelper::ambilParam($arrayParamKeluar, 
    [
        _Alias::$lain[1],
        _Alias::$lain[2],
        _Alias::$lain[3],
        _Alias::$lain[4]
    ]);

Debug::echoe("<br> PARAM ENKRIP <br>");
Debug::var_dumpe($arrayParamKeluar);

Debug::echoe("<br> PARAM DEKRIP <br>");
Debug::var_dumpe($arrayParamDekrip);
/*
$arrayParamMasuk= ParamHelper::ambilParam($_GET);
Debug::var_dumpe($arrayParamMasuk);
$request_fungsi= $arrayParamMasuk[_Alias::$lain[1]];
$reqTujuan= $arrayParamMasuk[_Alias::$lain[2]];

$a= $_GET["!.!1.0O4,7"];
$key= array_keys($_GET);
Debug::var_dumpe($key);
Debug::echoe("param1 => $a");
*/
/*
$penscan= new Peserta("ID3", "uname1", "abcd", 0, "ID2", "Startup");
$penscan1= new Peserta("ID4", "uname2", "abcd", 0, "ID1", "Game");
//$scanHelper= new ScanHelper();
//$scanHelper->scan($penscan1, "ID2");

$obj= new Filter("ise\barscan\util\ScanHelper");
Debug::echoe($obj->panggil_fungsi($request_fungsi, $penscan1, $reqTujuan));
*/
/*
============================
Bagian SkorHelper
============================
$idUser= 'ID1 " "--';
$sqlSelect= new Query();
$sqlSelect->select(PesertaModel::$skor)
    ->from(PesertaModel::$table)
    ->where(PesertaModel::$id ." = $", [$idUser]);
$sqlSelect= $sqlSelect->stringQuery();
Debug::echoe($sqlSelect);

$hasilla= strcasecmp("asda", "asdA");
Debug::echoe("hai = $hasilla");


$skorHelper= new SkorHelper();
//$hasil= $skorHelper->kurangi("ID2", 9);
//Debug::echoe($hasil);


$penscan= new Peserta("ID3", "abcd", 0, "ID2", "Startup");
$penscan1= new Peserta("ID4", "abcd", 0, "ID1", "Game");
$scanHelper= new ScanHelper();

$scanHelper->scan($penscan1, "ID2");
*/

/*
$q = (new Query());
$q= $q->table("userlevels")->where('1 = 1 --', "=", 1)->field('*');
 $s= $q->render();

 $indWhere= sub
// $q= new Query();
// $q->where('1 = 1 --', "=", 1)->field('*');
 $ss= $q->render();
 $p= $q->params;

 
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
); 

$server = "localhost";
$db = "coba";
$dsn = "mysql:host=$server;dbname=$db";
$username = "root";
$password = "";
Debug::echoe($dsn);

//$dbh = new PDO($dsn, $username, $password, $options);
/*
$con= Connection::connect($dsn, $username, $password);
$hasilQ= $con->dsql()->table("userlevels")->where("userlevelid", 0)->field("*");
$hasilQue= $hasilQ->getOne();
* /


$hasilP= Debug::var_dumpe($p);
$keys= array_keys($p);
$values= array_values($p);

$sGanti= str_ireplace($keys, $values, $s);

$conn = new mysqli($server, $username,
    $password, $db);
$res= $conn->query($sGanti);
Debug::echoe("res = $res");

if(mysqli_num_rows($res) > 0){
    while($row= $res->fetch_assoc()){
        Debug::echoe("userlevelid = " .$row['userlevelid']);
    }
}
//Debug::echoe($conn);


 Debug::echoe("s = $s \np = $hasilP \nhasil = $sGanti");
 Debug::echoe("ss = $ss");
 //Debug::echoe("h = $h");
 Debug::echoe("\nok");

/*
$q = (new Query())->table('user')->where('id', 1)->field('name');
$query = $q->render();
$params = $q->params;

Debug::echoe "query = $q"
*/
?>