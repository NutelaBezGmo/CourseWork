<?php include_once 'C:\xampp\htdocs\course\blocks\head.php';?>
<body id="page-top">

<?php include_once 'C:\xampp\htdocs\course\blocks\header.php'?>

  <div id="wrapper">

    <!-- Sidebar -->
<?php include_once 'C:\xampp\htdocs\course\blocks\right.php';?>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php">Главная</a>
          </li>
          <li class="breadcrumb-item active">
          <a href="order.php">Заказы</a></li>
        </ol>


        <!-- Page Content -->
        <h1>Удаление заказа</h1>
        <form method="POST" action="order_change_INP.php?action=remove&id=<?=$book[0]->order_id?>">
        <table>
        <tr><td>ФИО:</td>
        <td><input type="text" name="full_name" readonly value="<?=htmlentities($book[0]->full_name)?>" required="required" maxlength="30">
        </td></tr>

        <tr><td>Номер телефона:</td>
        <td><input type="text" name="phone_number" readonly value="<?=htmlentities($book[0]->phone_number)?>" required="required" maxlength="30">
        </td></tr>

        <tr><td>Дом:</td>
        <td><input type="text" name="name" readonly value="<?=htmlentities($book[0]->name)?>" required="required"  maxlength="12">
        </td></tr>

        <tr><td>Номер сектора:</td>
        <td><input readonly value="<?=htmlentities($book[0]->sector_number)?>"></td>
        </tr>

        <tr><td>Дата прибытия:</td>
        <td><input type="date" readonly name="in_date" required="required" value="<?=htmlentities($book[0]->in_date)?>" >
        </td></tr>

        <tr><td>Дата отъезда:</td>
        <td><input type="date" readonly name="dateOfDismiss" required="required" value="<?=$book[0]->out_date?>" >
        </td></tr>

        <tr><td>Дата заключения:</td>
        <td><input type="date" readonly name="dateOfDismiss" required="required" value="<?=$book[0]->order_date?>" >
        </td></tr>

        <tr><td></td>
        <td><input type="hidden" name="id" value="<?=$book[0]->order_id?>" required="required">
        </td></tr>

        <tr ><td>Причина отмены:</td>
          <td><textarea name="reason" required="required" rows="7" cols="50" placeholder="Введите текст.." name="describe"></textarea>
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

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

</body>

</html>
