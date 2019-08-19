<?php
include_once 'C:\xampp\htdocs\course\blocks\connection.php';
$glId = 0;
if(isset($_GET['id'])){
  $id = htmlentities($_GET['id']);
  $glId = $id;
  $sql='SELECT * FROM customers WHERE customer_id='.$id;
  $temp = $db->query($sql);
  $customer = $temp->fetchAll();
}
if (isset($_POST['SUBMIT'])) {
    list($errors, $input) = validate_form();
    if($errors) {
        show_form(NULL,$errors);
    }
    else {
        process_form($input);
    }
}
else {
  if(isset($customer))
    show_form($customer);
  else
    header("Location: 404.html");
}

function show_form($default=array(), $errors = array(), $alert = array()) {
    include_once 'customer_change.php';
}

function validate_form() {
    $input = array();
    $errors = array();
    $input['id'] = $_POST['custId'];
    $input['fullName'] = $_POST['full_name'];
    if(!strlen($input['fullName']))
      $errors[]='Пожалуйста введите ФИО';
    $input['pass'] = $_POST['pass'];
    $input['phoneNumber'] = $_POST['phoneNumber'] ?? '';
    if(strlen($input['phoneNumber'])<12){
        $errors[] = 'Пожалуйста введите правильный номер телефона.';
    }
    if(!($input['phoneNumber'][0]==3 && $input['phoneNumber'][1]==8 && $input['phoneNumber'][2]==0)){
        $errors[] = 'Работа только для граждан нашей страны';
    }
    return array($errors, $input);
}

function process_form($input) {
    global $db;
    $alert = array();
  try{
     $stmt = $db->prepare('UPDATE customers SET full_name=?, pass=?, phone_number=? WHERE customer_id=' . $input['id']);
     $stmt->execute(array($input['fullName'], $input['pass'],
     $input['phoneNumber']));
     header('Location: customers.php');
}catch(PDOException $e)
{
    error404($e);
}
}

?>
