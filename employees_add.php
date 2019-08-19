<?php include_once 'C:\xampp\htdocs\course\blocks\head.php';?>
<body id="page-top">

<?php include_once 'C:\xampp\htdocs\course\blocks\header.php'?>

  <div id="wrapper">

    <!-- Sidebar -->
    <?php include_once 'C:\xampp\htdocs\course\blocks\right.php'?>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php">Главная</a>
          </li>
          <li class="breadcrumb-item active">Сотрудники</li>
        </ol>
        <!-- Page Content -->
        <h1>Новый сотрудник</h1>
        <hr>
      <form method="POST" action="<?= htmlentities($_SERVER['PHP_SELF']) ?>" autocomplete = "on">
            <table>
            <?php if ($errors) { ?>
            <tr><td>Вам нужно исправить следующие ошибки:</td>
                <td><ul>
                <?php foreach ($errors as $error) { ?>
                <li><?= htmlentities($error) ?></li>
            <?php } ?>
            </ul></td>
            <?php } ?>
            </table>
            <table>
            <tr><td>Имя:</td>
            <td><input type="text" name="firstName" value="<?=autoBLUE("firstName")?>" required="required" maxlength="30">
            </td></tr>

            <tr><td>Фамилия:</td>
            <td><input type="text" name="secondName" value="<?=autoBLUE("secondName")?>" required="required" maxlength="30">
            </td></tr>

            <tr><td>Пол:</td>
            <td><input type="radio" <?php if(autoBLUE("gender")=="Мужчина") print "checked"; ?> name="gender" value="Мужчина" required="required">
            Мужчина <br/>
            <input type="radio" <?php if(autoBLUE("gender")=="Женщина") print "checked"; ?> name="gender" value="Женщина" required="required">
            Женщина <br/>
            </td></tr>

            <tr><td>День Рождения:</td>
            <td><input type="date" name="birthday" value="<?=autoBLUE("birthday")?>" required="required">
            </td></tr>

            <tr><td>Номер телефона:</td>
            <td><input type="text" name="phoneNumber" value="<?=autoBLUE("phoneNumber")?>" required="required"  maxlength="12">
            </td></tr>

            <tr><td>Должность:</td>
            <td><select name="post"><?php for($i=0; $i < count($posts) ; $i++) {
              print '<option value="'.$posts[$i]->post_id.'">'.$posts[$i]->post_name."</option>";
            }?></select></td>
            </tr>

            <tr><td>Дата приёма на работу:</td>
            <td><input type="date" name="dateOfEmploy" required="required" value="<?= date('Y-m-d');?>" readonly>
            </td></tr>
            </table>
            <table>
              <br>
              <tr>
                <td>Логин:</td>
                <td><input type="text" name="login" value="<?=autoBLUE("login")?>" required="required" maxlength="32">
              </tr>
              <tr>
                <td>Пароль:</td>
                <td><input type="password" name="password" required="required" maxlength="8">
              </tr>
            </table>
            <br>
          <input align="center" type="submit" name="SUBMIT" value="Подтвердить" required="required">
        </form>

      </div>
      <!-- /.container-fluid -->

  <?php include_once 'C:\xampp\htdocs\course\blocks\footer.php'?>
    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
    <?php include_once 'C:\xampp\htdocs\course\blocks\logout.php'?>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

</body>

</html>
