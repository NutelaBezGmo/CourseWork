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
          <li class="breadcrumb-item active">Дома</li>
        </ol>
        <!-- Page Content -->
        <h1><?php if($default)print "Изменить дом"; else print"Новый дом";?></h1>
        <hr>
        <form method="POST" action="<?php if($default) print"build_INP.php?action=change"; else
        print htmlentities($_SERVER['PHP_SELF']) ?>" autocomplete = "on">
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
            <tr><td>Тип дома:</td>
            <td><select name="type_id"><?php for($i=0;$i<count($builds);$i++){
            if($default[0]->type_id == $builds[$i]->type_id)
            print '<option selected value="'.$builds[$i]->type_id.'">'.$builds[$i]->name.'</option>';
            else
            print '<option value="'.$builds[$i]->type_id.'">'.$builds[$i]->name.'</option>';
            }?>
            </select>
            </td></tr>

            <tr><td>Номер сектора:</td>
            <td><input type="number" name="sector" <?php if($default) print htmlentities("value=".$default[0]->sector_number);
            else print 'value="'.autoBLUE('sector').'"';?> required="required" max="64">
            </td></tr>

            <tr><td colspan="2" align="center">
            <input type="submit" name="SUBMIT" value="Подтвердить" required="required">
            </td></tr>
            </table>
            <input type="hidden" name="buildId" value=<?= $default[0]->build_id?>>
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
