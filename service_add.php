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
          <li class="breadcrumb-item active">Услуги</li>
        </ol>
        <!-- Page Content -->
        <h1>Новая услуга</h1>
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
                <tr><td>Название:</td>
                <td><input type="text" name="service_title" value="<?=autoBLUE("service_title")?>" required="required" maxlength="30">
                </td></tr>

                <tr><td>Цена за услугу:</td>
                <td><input type="number" name="cost" value="<?=autoBLUE("cost")?>" required="required" maxlength="10">
                </td></tr>

                <tr><td>Описание:</td>
                <td><textarea rows="10" cols="45" value="<?=autoBLUE("describe")?>" name="describe"></textarea>
                </td></tr>

                <tr><td colspan="2" align="center">
                <input type="submit" name="SUBMIT" value="Подтвердить" required="required">
                </td></tr>

              </table>

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
