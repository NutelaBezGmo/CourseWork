<?php
include_once 'C:\xampp\htdocs\course\blocks\connection.php';

if($_GET['action']=='exit'){
  session_start();
  session_destroy();
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

function show_form($errors = array(), $alert = array()) {
    include_once 'login_INP.php';
}

function validate_form() {
    $input = array();
    $errors = array();
    global $db;
    $input['login'] = trim($_POST['login'] ?? '');
    if (!strlen($input['login'])) {
        $errors[] = 'Пожалуйста введите логин.';
    }
    $input['password'] = trim($_POST['password'] ?? '');
    if (!strlen($input['password'])) {
        $errors[] = 'Пожалуйста введите пароль.';
    }
    $sql = 'SELECT * FROM users u JOIN employees e ON e.employees_id = u.user_id NATURAL JOIN post
    WHERE u.login="'.$input['login'].'"AND u.password="'.$input['password'].'"';
    $temp = $db->query($sql);
    $user = $temp->fetchAll();
    if(!count($user)==1){
      if(count($user)==0){
        $errors[] = "Пожалуйста проверьте вводимые логин или пароль или обратитесь к администратору!";
      }
      else if(count($user)>1)
      {
        $errors[] = "Пожалуйста обратитесь к администратору code error J0p9";
      }
    }
    else
    {
      $input['name'] = $user[0]->first_name;
      $input['secondName'] = $user[0]->second_name;
      $input['id'] = $user[0]->user_id;
      $input['is_admin'] = $user[0]->is_admin;

    }
    return array($errors,$input);
  }

function process_form($input) {
    global $db;
    $alert = array();
    session_start();
    $_SESSION['login'] = 1;
    $_SESSION['id'] = $input['id'];
    $_SESSION['first_name'] = $input['name'];
    $_SESSION['second_name'] = $input['secondName'];
    $_SESSION['is_admin'] = $input['is_admin'];
    $_SESSION['errors'] = 1;
    header("Location: index.php");
  }
?>
