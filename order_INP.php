<?php
include_once 'C:\xampp\htdocs\course\blocks\connection.php';
$sql = "SELECT bt.name, b.build_id, b.sector_number FROM build b NATURAL JOIN build_type bt
LEFT JOIN book bk ON bk.build_id = b.build_id WHERE bk.order_id is NULL";
$temp = $db->query($sql);
$build = $temp ->fetchAll();

$sql = "SELECT * FROM service";
$temp = $db->query($sql);
$services = $temp->fetchAll();

if(isset($_POST['CHEK']))
{
  $input['in_date'] = $_POST['in_date'] ?? '';
  $input['out_date'] = $_POST['out_date'] ?? '';
  if(!strlen($input['in_date'])){
      $errors[] = 'Пожалуйста выберите дату приезда.';
      show_form($errors);
  }
  else{
    global $build;
    if(strlen($input['out_date'])){
      $sql = 'SELECT * FROM build bl NATURAL JOIN build_type WHERE bl.build_id NOT IN'.'(
        SELECT b.build_id FROM book b WHERE "'.$input['in_date'].'" BETWEEN b.in_date AND b.out_date OR
        b.in_date BETWEEN "'.$input['in_date'].'" AND "'.$input['out_date'].'")';
      $temp = $db->query($sql);
      $build = $temp ->fetchAll();
    }
    else{
      $currentDate = new DateTime();
      $sql = 'SELECT * FROM build bl NATURAL JOIN build_type WHERE bl.build_id NOT IN'.'(
        SELECT b.build_id FROM book b WHERE "'.$input['in_date'].'" BETWEEN b.in_date AND b.out_date OR
        b.in_date BETWEEN "'.$input['in_date'].'" AND "'.$input['in_date'].'")';
      $temp = $db->query($sql);
      $build = $temp ->fetchAll();
    }
  }
}
if (isset($_POST['SUBMIT'])) {
    list($errors, $input) = validate_form();
    if($errors) {
        show_form($errors);
    }
    else {
        process_form($input);
    }
}
else {
    show_form();
}

function show_form($errors = array()) {
    global $build;
    global $services;
    include_once 'order_add.php';
}

function validate_form() {
    session_start();
    $input = array();
    $errors = array();
    global $db;
    $_POST['da'] = trim($_POST['da']) ?? '';
    if(strlen($_POST['da'])){
        $input['services'] = explode(" ", $_POST['da']);
        $input['services'] = array_count_values ($input['services']);
    }
    $input['full_name'] = trim($_POST['full_name'] ?? '');
    if (!strlen($input['full_name'])) {
        $errors[] = 'Пожалуйста введите ФИО.';
    }
    $input['pass'] = $_POST['pass'] ?? '';
    if(!strlen($input['pass'])){
        $errors[] = 'Пожалуйста введите пасспорт.';
    }
    $input['phone_number'] = $_POST['phone_number'] ?? '';
    if(strlen($input['phone_number'])<12){
        $errors[] = 'Пожалуйста введите правильный номер телефона.';
    }
    if(!($input['phone_number'][0]==3 && $input['phone_number'][1]==8 && $input['phone_number'][2]==0)){
        $errors[] = 'Мобильный телефон должен начинаться с 380';
    }
    $input['old'] = $_POST['old'] ?? '';
    if($input['old']){
      try{
        $sql = 'SELECT * FROM customers WHERE pass="'.$input['pass'].'"';
        $temp = $db->query($sql);
        $input['old'] = $temp->fetchAll();
        if(count($input['old'])==0){
          $errors[] = "Клиент с таким паспортом отсутствует в базе данных.";
        }
      }catch(PDOException $e){
        error404($e);
      }
    }
    else{
      $sql = 'SELECT * FROM customers WHERE pass="'.$input['pass'].'"';
      $temp = $db->query($sql);
      $input['old'] = $temp->fetchAll();
      if(count($input['old'])){
        $errors[] = "Клиент с таким паспортом уже есть в базе данных поставьте галочку.";
      }
    }
    $input['build_id'] = $_POST['build'] ?? '';
    if(!strlen($input['build_id'])){
        $errors[] = 'Пожалуйста выберите дом.';
    }
    $input['id'] = $_SESSION['id'] ;
    $input['in_date'] = $_POST['in_date'] ?? '';
    if(!strlen($input['in_date'])){
        $errors[] = 'Пожалуйста выберите дату приезда.';
    }
    $chekDate = new DateTime();
    $tmp = new DateTime($input['in_date']);
    $interval = $chekDate->diff($tmp);
    if($interval->format('%R%a')<0){
      $errors[] = 'Нельзя оформить заказ на прошлый день';
    }else if($interval->format('%R%a')==0 && $interval->format('%R%h')<-12){
      $errors[] = 'Время въезда сегодня завершилось в 12:00';
    }
    $input['out_date'] = $_POST['out_date'] ?? '';
    if(!strlen($input['out_date'])){
        $errors[] = 'Пожалуйста выберите дату отъезда.';
    }
    $chekDate = new DateTime($input['out_date']);
    $interval = $tmp->diff($chekDate);

    if($interval->format('%R%a')<0){
      $errors[] = 'Введите корректную дату выезда';
    }

    if($interval->format('%R%a')>7){
      $errors[] = 'Бронирование домика в одном заказе максимум на 7 дней';
    }
    if($input['build_id']){
      $sql = 'SELECT bl.build_id, bt.name, bl.sector_number FROM build bl NATURAL JOIN build_type bt
      WHERE bl.build_id NOT IN'.'(
      SELECT b.build_id FROM book b WHERE "'.$input['in_date'].'" BETWEEN b.in_date AND b.out_date OR
      b.in_date BETWEEN "'.$input['in_date'].'" AND "'.$input['out_date'].'")';
      $temp = $db->query($sql);
      $builds = $temp ->fetchAll();
      $flag = false;
      for ($i=0; $i < count($builds) ; $i++) {
        if($builds[$i]->build_id==$input['build_id'])
            $flag = true;
      }
      if(!$flag){
        $errors[] = 'Выбранный дом уже занят.';
      }
    }
    return array($errors, $input);
}

function process_form($input) {
    global $db;
    $currentDate = new Datetime();
    if(!$input['old']){
      try{
          $stmt = $db->prepare('INSERT INTO customers VALUE(?, ?, ?, ?)');
          $stmt->execute(array(NULL, $input['full_name'], $input['pass'],
          $input['phone_number']));
          $custId = $db->lastInsertId();
          $input['customer_id'] = $custId;
        } catch(PDOException $e)
          {
            error404($e);
            exit();
          }
    }
      else{
        $input['customer_id'] = $input['old'][0]->customer_id;
      }
    try{
        $stmt = $db->prepare('INSERT INTO book VALUE(?, ?, ?, ?,
         ?, ?, ?)');
         $stmt->execute(array(NULL, $input['id'], $input['customer_id'],
         $input['build_id'], $currentDate->format('Y-m-d'), $input['in_date'], $input['out_date']));
    }catch(PDOException $e)
      {
          error404($e);
          exit();
      }
      $bookId = $db->lastInsertId();
      try{
        foreach($input['services'] as $key => $val){
          $stmt = $db->prepare('INSERT INTO service_book VALUE(?, ?, ?)');
          $stmt->execute(array($bookId, $key, $val));
         }
        header('Location: order.php');
      }catch(PDOException $e)
        {
            error404($e);
            exit();
        }
    }

?>
