<?php
include_once 'C:\xampp\htdocs\course\blocks\connection.php';
$sql = "SELECT * FROM post";
$stmt = $db->query($sql);
$posts = $stmt->fetchAll();

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
    global $posts;
    include_once 'employees_add.php';
}

function validate_form() {
    $input = array();
    $errors = array();

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
     // обязательный пол
    $input['gender'] = $_POST['gender'] ?? '';
    if (! in_array($input['gender'], ['Мужчина','Женщина'])) {
        $errors[] = 'Пожалуйста введите пол.';
    }
    $input['dateOfEmploy'] = $_POST['dateOfEmploy'];
    $input['post'] = $_POST['post'];
    $input['phoneNumber'] = $_POST['phoneNumber'] ?? '';
    if(strlen($input['phoneNumber'])<12){
        $errors[] = 'Пожалуйста введите правильный номер телефона.';
    }
    if(!($input['phoneNumber'][0]==3 && $input['phoneNumber'][1]==8 && $input['phoneNumber'][2]==0)){
        $errors[] = 'Работа только для граждан нашей страны';
    }
    $input['birthday'] = $_POST['birthday'];
    $chekDate = new DateTime('18 years ago');
    $tmp = new DateTime($input['birthday']);
    if($tmp>$chekDate)
        $errors[] = 'Сотрудник должен быть старше 18 лет';
    $chekDate = new DateTime('65 years ago');
    if($tmp<$chekDate)
        $errors[] = 'Сотрудник не должен быть старше 65 лет';

    return array($errors, $input);
}

function process_form($input) {
    global $db;
    $alert = array();
try{
    $stmt = $db->prepare('INSERT INTO employees VALUE(?, ?, ?, ?,
     ?, ?, ?, ?)');
     $stmt->execute(array(NULL, $input['firstName'], $input['secondName'],
     $input['gender'], $input['birthday'],$input['phoneNumber'], $input['post'], $input['dateOfEmploy']));
     $sql = 'SELECT employees_id FROM employees WHERE first_name="'.$input['firstName'].'" AND second_name="'.
     $input['secondName'].'" AND phone_number="'.$input['phoneNumber'].'"';
     $temp = $db->query($sql);
     $employeID = $temp->fetchAll();
     $stmt = $db->prepare('INSERT INTO users VALUE(?, ?, ?)');
     $stmt->execute(array($employeID[0]->employees_id, $input['login'], $input['password']));
     header('Location: employees.php');
}catch(PDOException $e)
{
    error404($e);
}
 $alert[] = "Добавлен новый сотрудник " . htmlentities($input['firstName']) . ' ' .  htmlentities($input['secondName']);
}

?>
