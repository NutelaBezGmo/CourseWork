<?php
$errors="";
session_start();
if($_GET['action']=='out'){
  setcookie('firstName',"", time()-3600, '/');
  setcookie('secondName', "", time()-3600, '/');
}
if(isset($_COOKIE['firstName'])){
  header("Location: index.php");
}
if(isset($_POST['log_in'])){
  include_once 'D:\xampp\htdocs\course\blocks\connection.php';
  $login = $_POST['login'];
  $password = $_POST['password'];
  $sql = "SELECT user_id FROM users WHERE login=\"$login\" AND password=\"$password\"";
  $stmt = $db->query($sql);
  $employees = $stmt->fetchAll();
  if($employees){
    $_SESSION['id'] = $employees[0]->user_id;
    setcookie('id', $employees[0]->user_id, time()+60*60, '/');
    $errors = "";
    $sql = "SELECT first_name, second_name FROM employees WHERE employees_id=" . $employees[0]->user_id;
    $stmt = $db->query($sql);
    $employees = $stmt->fetchAll();
    setcookie('firstName', $employees[0]->first_name, time()+60*60, '/');
    setcookie('secondName', $employees[0]->second_name, time()+60*60, '/');

    header("Location: index.php");
  }
  else{
    $errors="Не удается войти. Пожалуйста, проверьте правильность написания логина и пароля.";
  }
}
include "headerr.php";
?>
