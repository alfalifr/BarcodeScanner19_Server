<!-- code by webdevtrick (https://webdevtrick.com) -->
<?php
$dsn = 'mysql:host=localhost;dbname=ise_barscan';
$username = 'root';
$password = '';
$options = [];
try {
$connection = new PDO($dsn, $username, $password, $options);
} catch(PDOException $e) {

}