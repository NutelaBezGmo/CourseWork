<?php
$month = array(1=>'Январь',2=>'Февраль',3=>'Март',
               4=>'Апрель',5=>'Май',    6=>'Июнь',
               7=>'Июль',  8=>'Август', 9=>'Сентябрь',
               10=>'Октябрь',11=>'Ноябрь',12=>'Декабрь');
function clear(){
  foreach($_POST as $temp => $val)
  {
    $_POST["$temp"] = "";
  }
}
function chek_the_distance($tmp)
{
  return $tmp*125;
}
function error404($error){

  include_once 'C:\xampp\htdocs\course\courseWork\404.php';
  exit();
}
function autoBLUE($name, $else = NULL){
  return isset($_POST[$name]) ? $_POST[$name] : $else;
}

 ?>
