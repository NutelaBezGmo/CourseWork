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
        <h1>Изменить данные о сотруднике</h1>
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
            <td><input type="text" name="firstName" value="<?=htmlentities($default[0]->first_name)?>"required="required" maxlength="30">
            </td></tr>

            <tr><td>Фамилия:</td>
            <td><input type="text" name="secondName" value="<?=htmlentities($default[0]->second_name)?>" required="required" maxlength="30">
            </td></tr>

            <tr><td>Номер телефона:</td>
            <td><input type="text" name="phoneNumber" value="<?=htmlentities($default[0]->phone_number)?>" required="required"  maxlength="12">
            </td></tr>

            <tr><td>Должность:</td>
              <td><select name="post"><?php for($i=0; $i < count($posts) ; $i++) {
                if($default[0]->post_name==$posts[$i]->post_name)
                print '<option selected value="'.$posts[$i]->post_id.'">'.$posts[$i]->post_name."</option>";
                else
                print '<option value="'.$posts[$i]->post_id.'">'.$posts[$i]->post_name."</option>";
              }?></select></td>
            </tr>

            <tr><td>Дата приёма на работу:</td>
            <td><input type="date" name="dateOfEmploy" required="required" value="<?=htmlentities($default[0]->date_of_employment)?>" disabled>
            </td></tr>
            </table>
            <table>
              <br>
              <tr>
                <td>Логин:</td>
                <td><input type="text" name="login" required="required" value="<?=htmlentities($default[0]->login)?>" maxlength="32">
              </tr>
              <tr>
                <td>Пароль:</td>
                <td><input type="text" name="password" required="required" value="<?=htmlentities($default[0]->password)?>" maxlength="8">
              </tr>
            </table>
            <br>
            <input type="hidden" name="custId" value=<?= $default[0]->user_id?>>
          <input align="center" type="submit" name="SUBMIT" value="Подтвердить" required="required">
        </form>
      <button align="center" onclick="location.href = ''" type="submit" name="RESET">Сбросить</button>
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
