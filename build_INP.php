<?php
include_once 'C:\xampp\htdocs\course\blocks\connection.php';
$sql = "SELECT type_id, name FROM build_type";
$temp = $db->query($sql);
$builds = $temp->fetchAll();
error_reporting(0);
if($_GET['action']=="delete"){
  $sql = 'DELETE FROM build WHERE build_id='.$_GET['id'];
  try{
    $temp = $db->query($sql);
    header("Location: build.php");
    exit();
  }catch(PDOException $e)
    {
        error404($e);
    }
}
if(isset($_GET['id'])){
  $id = $_GET['id'];
  $sql='SELECT * FROM build NATURAL JOIN build_type WHERE build_id='.$id;
  $temp = $db->query($sql);
  $build = $temp->fetchAll();
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
  if($build)
    show_form($build);
  else
    show_form();
}

function show_form($default=array(), $errors = array()) {
    global $builds;
    include_once 'build_add.php';
}

function validate_form() {
    global $db;
    $input = array();
    $errors = array();
    $input['id'] = $_POST['buildId'];
    $input['type_id'] = $_POST['type_id'];
    $input['sector'] = trim($_POST['sector']) ?? '';
    if(strlen($input['sector'])){
      $sql = 'SELECT sector_number FROM build WHERE sector_number='.$input['sector'];
      $temp = $db->query($sql);
      $sectors = $temp->fetchAll();
      if($sectors) $errors[]="Этот сектор занят другим домом";
    }else $errors[] = "Введите номер сектора";
    $input['distance'] = chek_the_distance($input['sector']);
    return array($errors, $input);
}

function process_form($input) {
    global $db;
    if($_GET['action']=="change"){
      $stmt = $db->prepare('UPDATE build SET sector_number=?, sector_distance=? WHERE build_id='.$input['id']);
      $stmt->execute(array($input['sector'], $input['distance']));
      header("Location: build.php");
    }
  else
    try{
        $stmt = $db->prepare('INSERT INTO build VALUE(?, ?, ?, ?)');
         $stmt->execute(array(NULL, $input['type_id'], $input['sector'],
         $input['distance']));
         header("Location: build.php");
    }catch(PDOException $e)
      {
        error404($e);
      }


}

?>
