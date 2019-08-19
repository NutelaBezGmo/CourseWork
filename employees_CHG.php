<?php
include_once 'C:\xampp\htdocs\course\blocks\connection.php';
if(isset($_GET['id'])){
  $id = $_GET['id'];
  $sql='SELECT * FROM employees e JOIN users u ON u.user_id = e.employees_id NATURAL JOIN post WHERE employees_id='.$id;
  $temp = $db->query($sql);
  $employee = $temp->fetchAll();

  $sql = "SELECT * FROM post";
  $stmt = $db->query($sql);
  $posts = $stmt->fetchAll();
}
else {header('Location: employees.php');exit();}
if (isset($_POST['SUBMIT'])) {
     // Если функция validate_form() возвратит ошибки,
    // передать их функции  show_form()
    list($errors, $input) = validate_form();
    if($errors) {
        show_form(NULL,$errors);
    }
    else {
    // Переданные данные из формы достоверны, обработать их
        process_form($input);
    }
}
else {
  if(isset($employee))
    show_form($employee);
  else
    show_form();
}

function show_form($default=array(), $errors = array(), $alert = array()) {
    global $posts;
    include_once 'employees_change.php';
}

function validate_form() {
    $input = array();
    $errors = array();
    $input['id'] = $_POST['custId'];
    $input['login'] = trim($_POST['login'] ?? '');
    if (!strlen($input['login'])) {
        $errors[] = 'Пожалуйста введите логин.';
    }
    $input['password'] = trim($_POST['password'] ?? '');
    if (!strlen($input['password'])) {
        $errors[] = 'Пожалуйста введите пароль.';
    }

    $input['firstName'] = trim($_POST['firstName'] ?? '');
    if (!strlen($input['firstName'])) {
        $errors[] = 'Пожалуйста введите имя.';
    }
    $input['secondName'] = trim($_POST['secondName'] ?? '');
    if (!strlen($input['secondName'])) {
        $errors[] = 'Пожалуйста введите фамилию.';
    }
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
    $stmt = $db->prepare('UPDATE employees SET first_name=?, second_name=?, phone_number=? WHERE employees_id=' . $input['id']);
     $stmt->execute(array($input['firstName'], $input['secondName'],
     $input['phoneNumber']));

     $stmt = $db->prepare('UPDATE users SET login=?, password=? WHERE user_id='.$input['id']);
     $stmt->execute(array($input['login'], $input['password']));
}catch(PDOException $e)
{
    error404($e);
}
 $alert[] = "Изменены данные о сотруднике " . htmlentities($input['firstName']) . ' ' .  htmlentities($input['secondName']);
 show_form(NULL,$alert);
}

?>
