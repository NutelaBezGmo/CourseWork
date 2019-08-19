<?php
include_once 'C:\xampp\htdocs\course\blocks\connection.php';
error_reporting(0);
if($_GET['action']=="delete"){
  $sql = 'DELETE FROM build_type WHERE type_id='.$_GET['id'];
  try{
    $temp = $db->query($sql);
    header("Location: build_type.php");
  }catch(PDOException $e)
    {
        print"Произошла ошибка при удалении!";
        print '<a href="build_type.php">Вернуться назад</a>';
        exit();
    }
}
if(isset($_GET['id'])){
  $id = $_GET['id'];
  $sql='SELECT * FROM build_type WHERE type_id='.$id;
  $temp = $db->query($sql);
  $build_type = $temp->fetchAll();
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
  if($build_type)
    show_form($build_type);
  else
    show_form();
}

function show_form($default=array(), $errors = array()) {
    include_once 'build_type_add.php';
}

function validate_form() {
    $input = array();
    $errors = array();
    $input['id'] = $_POST['typeId'];
    $input['title'] = trim($_POST['title'] ?? '');
    if (!strlen($input['title'])) {
        $errors[] = 'Пожалуйста введите название.';
    }
    $input['rooms'] = $_POST['rooms'];
    $input['area'] = trim($_POST['area']);
    if(!is_numeric($input['area'])){
      $errors[] = 'Пожалуйста введите площадь как число.';
    }
    if(is_numeric($input['area'])&&$input['area']<0){
      $errors[] = 'Площадь должна быть больше 0.';
    }
    $input['beds'] = $_POST['beds'];

    $input['cost'] = trim($_POST['cost']);

    $input['kitchen'] = $_POST['kitchen'];
    $input['describe'] = trim($_POST['describe']);
    return array($errors, $input);
}

function process_form($input) {
    global $db;
    if($_GET['action']=="change"){
      try{
          $stmt = $db->prepare('UPDATE build_type SET name=?, rooms_number=?,
          area=?, bed_number=?, cost=?, kitchen=?, type_describe=? WHERE type_id='.$input['id']);
           $stmt->execute(array($input['title'], $input['rooms'],
           $input['area'], $input['beds'], $input['cost'], $input['kitchen'],
           $input['describe']));
           header("Location: build_type.php");
      }catch(PDOException $e)
        {
            error404($e);
        }
    }
    else
        try{
            $stmt = $db->prepare('INSERT INTO build_type VALUE(?, ?, ?, ?,
             ?, ?, ?, ?)');
             $stmt->execute(array(NULL, $input['title'], $input['rooms'],
             $input['area'], $input['beds'], $input['cost'], $input['kitchen'],
             $input['describe']));
             header("Location: build_type.php");
        }catch(PDOException $e)
          {
              error404($e);
          }
}

?>
