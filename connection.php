<?php
include_once 'C:\xampp\htdocs\course\login.php';
include_once 'C:\xampp\htdocs\course\function.php';
error_reporting(0);
try{
    $db = new PDO("mysql:host=$host; dbname=$database".";charset=utf8",
    "$user","$password");
} catch(PDOException $e){
    print "Возникли проблемы при соединении с базой данных: <br>".
    $e->getMessage();
    exit();
}
$db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db ->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
?>
