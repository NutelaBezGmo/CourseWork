<?php
include_once 'C:\xampp\htdocs\course\blocks\connection.php';
error_reporting(0);
if(isset($_GET['id'])){
  $id = $_GET['id'];
  if($_GET['action']=='delete'){
    $sql = "DELETE FROM service WHERE service_id=" .$_GET['id'];
    $temp = $db->query($sql);
    header("Location: service.php");
    exit();
  }
  $sql='SELECT * FROM service WHERE service_id='.$id;
  $temp = $db->query($sql);
  $service = $temp->fetchAll();
}
if (isset($_POST['SUBMIT'])) {
    list($errors, $input) = validate_form();
    if($errors) {
        show_form(NULL, $errors);
    }
    else {
        process_form($input);
    }
}
else {
  if(isset($service))
    show_form($service);
  else
    show_form();
}

function show_form($default=array(), $errors = array()) {
    if($default)
    {
      include_once 'service_change.php';
    }
    else
    {
      include_once 'service_add.php';
    }
}

function validate_form() {
    $input = array();
    $errors = array();
    $input['id'] = $_POST['servId'];
    $input['service_title'] = trim($_POST['service_title'] ?? '');
    if (!strlen($input['service_title'])) {
        $errors[] = 'Пожалуйста введите название услуги.';
    }
    $input['cost'] = $_POST['cost'];
    $input['describe'] = $_POST['describe'];
    if(!is_numeric($input['cost']))
    {
      $errors[] = "Цена должна быть действительой.";
    }
    return array($errors, $input);
}

function process_form($input) {
    global $db;
    if($_GET['action']=="change"){
      $stmt = $db->prepare('UPDATE service SET service_name=?, cost=?, service_describe=? WHERE service_id='.$input['id']);
       $stmt->execute(array($input['service_title'], $input['cost'],
       $input['describe']));
      header("Location: service.php");
      exit();
    }
else
try{
    $stmt = $db->prepare('INSERT INTO service VALUE(?, ?, ?, ?)');
     $stmt->execute(array(NULL, $input['service_title'], $input['cost'],
     $input['describe']));
     header("Location: service.php");
}catch(PDOException $e)
  {
    error404($e);
  }

}

?>
