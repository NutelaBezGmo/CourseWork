<?php
include_once 'C:\xampp\htdocs\course\blocks\connection.php';
if(isset($_GET['id'])){
  $sql = 'SELECT * FROM book b NATURAL JOIN employees JOIN customers c ON c.customer_id = b.customer_id
  NATURAL JOIN build NATURAL JOIN build_type WHERE b.order_id = "'.$_GET['id'] .'"';
  $temp = $db->query($sql);
  $book = $temp ->fetchAll();
  $sql = 'SELECT * FROM service_book NATURAL JOIN service WHERE order_id="' . $_GET['id'] . '"';
  $temp = $db->query($sql);
  $book_serv = $temp ->fetchAll();
}
else {
  header('Location: order.php');
  exit();
}

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
    global $book;
    if(strlen($input['out_date'])){
      $sql = 'SELECT bl.build_id, bt.name, bl.sector_number FROM build bl NATURAL JOIN build_type bt
        WHERE bl.build_id NOT IN'.'(
        SELECT b.build_id FROM book b WHERE "'.$input['in_date'].'" BETWEEN b.in_date AND b.out_date OR
        b.in_date BETWEEN "'.$input['in_date'].'" AND "'.$input['out_date'].'")';
      $temp = $db->query($sql);
      $build = $temp ->fetchAll();
    }
    else{
      $sql = 'SELECT * FROM build bl NATURAL JOIN build_type WHERE bl.build_id IN'.'
      (SELECT b.build_id FROM book b WHERE "'.$input['in_date'].'" NOT BETWEEN b.in_date AND b.out_date)
      AND bl.build_id NOT IN(SELECT b.build_id FROM book b WHERE "'.$input['in_date'].'" BETWEEN b.in_date AND b.out_date)';
      $temp = $db->query($sql);
      $build = $temp ->fetchAll();
    }
  }
}
if (isset($_POST['SUBMIT'])) {
  if($_GET['action']=='remove'){
    global $db;
    $input = trim($_POST['reason']) ?? '';

    $chekDate = new DateTime();
    $current = new DateTime();
    $in_date = new DateTime($book[0]->in_date);
    if($chekDate<$in_date)$chekDate = $in_date;
    $tmp = new DateTime($book[0]->out_date);
    $is_done = 1;
    if($current<$chekDate){
      $is_done = 0;
    }
    if($is_done)
      $out_date = $current;
    else
      $out_date = $tmp;

    $sql = 'SELECT SUM(sb.service_number*s.cost) as sum FROM service_book sb NATURAL JOIN service s WHERE order_id='.$book[0]->order_id;
    $temp = $db->query($sql);
    $cost = $temp->fetchAll();
    if(!$is_done)$cost[0]->sum = 0;
    $stmt = $db->prepare('INSERT INTO book_arch VALUES(?,?,?,?,?,?,?,?,?,?)');
    $stmt->execute(array(NULL, $book[0]->employees_id,$book[0]->customer_id,$book[0]->build_id,$cost[0]->sum,
    $book[0]->order_date, $book[0]->in_date, $out_date->format('Y-m-d'), $input, $is_done));

    $sql = 'SELECT SUM(sb.service_number*s.cost) as sum FROM service_book sb NATURAL JOIN service s WHERE order_id='.$book[0]->order_id;
    $temp = $db->query($sql);
    $cost = $temp->fetchAll();
    $sql = 'DELETE FROM service_book WHERE order_id='.$book[0]->order_id;
    $temp = $db->query($sql);
    $sql = 'DELETE FROM book WHERE order_id='.$book[0]->order_id;
    $temp = $db->query($sql);
    header('Location: order.php');exit();
    }
  else{
    list($errors, $input) = validate_form();
    if($errors) {
        show_form($errors);
    }
    else {
        process_form($input);
    }
  }
}
else {
  if($_GET['action']=="delete"){
    global $book;
    include_once 'order_free.php';
  }
  else
    show_form();
}

function show_form($errors = array()) {
    global $build;
    global $services;
    global $book;
    global $book_serv;
    include_once 'order_change.php';
}

function validate_form() {
    session_start();
    $input = array();
    $errors = array();
    global $db;
    global $book;
    $input['id'] = $_POST['bookId'] ?? '';
    $_POST['da'] = trim($_POST['da']) ?? '';
    if(strlen($_POST['da'])){
        $input['services'] = explode(" ", $_POST['da']);
        $input['services'] = array_count_values ($input['services']);
    }
    $input['build_id'] = $_POST['build'] ?? '';
    if(!strlen($input['build_id'])){
        $errors[] = 'Пожалуйста выберите дом.';
    }
    $input['in_date'] = $_POST['in_date'] ?? '';
    if(!strlen($input['in_date'])){
        $errors[] = 'Пожалуйста выберите дату приезда.';
    }
    $input['out_date'] = $_POST['out_date'] ?? '';
    if(!strlen($input['out_date'])){
        $errors[] = 'Пожалуйста выберите дату отъезда.';
    }
    if(!($input['in_date']==$book[0]->in_date&&$input['out_date']==$book[0]->out_date)){
      $chekDate = new DateTime();
      $tmp = new DateTime($input['in_date']);
      $interval = $chekDate->diff($tmp);
      if($interval->format('%R%a')<0){
        $errors[] = 'Нельзя изменить заказ на прошлый день';
      }else if($interval->format('%R%a')==0 && $interval->format('%R%h')<-12){
        $errors[] = 'Время въезда сегодня завершилось в 12:00';
      }
      $chekDate = new DateTime($input['out_date']);
      $interval = $tmp->diff($chekDate);

      if($interval->format('%R%a')<0){
        $errors[] = 'Введите корректную дату выезда';
      }
      if($interval->format('%R%a')>7){
        $errors[] = 'Бронирование домика в одном заказе максимум на 7 дней';
      }
    }
    if($input['build_id']==$book[0]->build_id){
      $sql = 'SELECT * FROM book b WHERE '.'("'.$input['in_date'].'" BETWEEN b.in_date AND b.out_date
      OR b.in_date BETWEEN "'.$input['in_date'].'" AND "'.$input['out_date'].'") AND b.build_id ='.$input['build_id'];
      $temp = $db->query($sql);
      $isFree = $temp->fetchAll();
      if(!(count($isFree)==1&&$isFree[0]->order_id==$book[0]->order_id))
        $errors[] = 'Выбранный дом уже занят.';
    }
    else{
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
    try{
        $stmt = $db->prepare("UPDATE book SET build_id=?, in_date=?, out_date=? WHERE order_id=".$input['id']);
        $stmt->execute(array($input['build_id'], $input['in_date'], $input['out_date']));
    }catch(PDOException $e)
      {
          error404($e);
          exit();
      }
      try{
        $sql = "DELETE FROM service_book WHERE order_id=".$input['id'];
        $temp = $db->query($sql);
        foreach($input['services'] as $key => $val){
          $stmt = $db->prepare('INSERT INTO service_book VALUE(?, ?, ?)');
          $stmt->execute(array($input['id'], $key, $val));
         }
      }catch(PDOException $e)
        {
            error404($e);
            exit();
        }
        header('Location: order.php');
        exit();
    }

?>
