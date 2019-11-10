<?php
namespace ise\barscan\util;
use ise\barscan\util\debug\Debug;
use mysqli;

class DbHelper{
    var $server = "localhost";
    var $uname = "root";
    var $pass = "";
    var $db = "ise_barscan";
    var $table= "user";

    function __construct($server, $user, $pass, $db, $table){
        $this->server= $server;
        $this->uname= $user;
        $this->pass= $pass;
        $this->db= $db;
        $this->table= $table;
    }

    function openConnection(): mysqli {
        $conn = new mysqli($this->server, $this->uname,
                        $this->pass, $this->db);
        // Check connection
        if ($conn->connect_error) 
            die("Connection failed: " . $conn->connect_error);
        else
            return $conn;
    }
}
?>