<?php
namespace ise\barscan\pref\model;
use ise\barscan\util\debug\Debug;

class LoginModel extends Model{
    static $table= "Penukaran";
    
//    static $id_login= "id_login";
    static $fk_user= "fk_user";
    static $token= "token";
    static $login_pas= "login_pas";
    static $akt_trahir= "akt_trahir";
}
?>