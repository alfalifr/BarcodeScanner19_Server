<?php
//$dir= "../imglul/you-know-qrzpfr.jpg";
$allImg= scandir(__DIR__);
$src= "you-know-qrzpfr.jpg";
$srcTmp= "";
while(!endsWith($srcTmp= $allImg[mt_rand(0, count($allImg)-1)],
    ".jpg"));
$src= $srcTmp;

////echo $src;
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