<?php
//$dir= "../imglul/you-know-qrzpfr.jpg";
$dir= "../../imglul";
$allImg= scandir($dir);
$src= "../imglul/you-know-qrzpfr.jpg";
$srcTmp= "";
while(!endsWith($srcTmp= $allImg[mt_rand(0, count($allImg)-1)],
    ".jpg"));
$src= $dir ."/" .$srcTmp;

//echo $src;
echo "<img src=$src>";


function endsWith(string $str, string $substr, $casesntv= false): bool{
    if(!$casesntv){
        $str= strtoupper($str);
        $substr= strtoupper($substr);
    }
    $pjgSub= strlen($substr);
    $indMulai= strlen($str) -$pjgSub;
    return substr($str, $indMulai) === $substr;
}
?>