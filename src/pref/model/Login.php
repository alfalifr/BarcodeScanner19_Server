<?php
namespace ise\barscan\pref\model;
use ise\barscan\util\debug\Debug;

use ise\barscan\util\Waktu;

class Login{
//    var $id_login;
    var $fk_user;
    var $token;
    var $login_pas;
    var $akt_trahir;

    function __construct(string $fk_user, string $token,
            string $login_pas= null, string $akt_trahir= null){
        $this->fk_user= $fk_user;
        $this->token= $token;

        if($login_pas == null)
            $login_pas= Waktu::skrg();
        if($akt_trahir == null)
            $akt_trahir= Waktu::skrg();
    }
}
?>