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
          <li class="breadcrumb-item active">Тип дома</li>
        </ol>
        <!-- Page Content -->
        <h1><?php if($default)print"Изменить тип дома"; else print"Новый тип дома"?></h1>
        <hr>
        <form method="POST" action="<?php if($default) print"build_type_INP.php?action=change";
        else print htmlentities($_SERVER['PHP_SELF']); ?>" autocomplete = "on">
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
            <td><input type="text" name="title" <?php if($default) print 'value="'.$default[0]->name.'"';?> required="required" maxlength="30">
            </td></tr>

            <tr><td>Количество комнат:</td>
            <td><select name="rooms">
                <option <?php if($default[0]->rooms_number==1) print"selected";?> value="1">1</option>
                <option <?php if($default[0]->rooms_number==2) print"selected";?> value="2">2</option>
                <option <?php if($default[0]->rooms_number==3) print"selected";?> value="3">3</option>
              </select>
            </td></tr>

            <tr><td>Площадь:</td>
            <td><input type="text"<?php if($default) print "value=".$default[0]->area;?>
             name="area" required="required" maxlength="10">
            </td></tr>

            <tr><td>Количество кроватей:</td>
            <td> <select name="beds">
                <option <?php if($default[0]->bed_number==1) print"selected";?> value="1">1</option>
                <option <?php if($default[0]->bed_number==2) print"selected";?> value="2">2</option>
                <option <?php if($default[0]->bed_number==4) print"selected";?> value="4">4</option>
              </select>
            </td></tr>

            <tr><td>Стоймость:</td>
            <td><input <?php if($default) print htmlentities("value=".$default[0]->cost);?> type="number" name="cost" required="required" max="9999">
            </td></tr>

            <tr><td>Кухня:</td>
            <td><input <?php if($default[0]->kitchen==1) print"checked";?> type="radio" name="kitchen" value="1" required="required">Есть<br>
                <input <?php if($default[0]->kitchen==0) print"checked";?> type="radio" name="kitchen" value="0" required="required">Нет<br>
            </td></tr>

            <tr><td>Описание:</td>
            <td><textarea rows="10" cols="45" name="describe"><?php if($default) print $default[0]->type_describe;?></textarea>
            </td></tr>

            <tr><td colspan="2" align="center">
            <input type="submit" name="SUBMIT" value="Подтвердить" required="required">
            </td></tr>
            </table>
            <input type="hidden" name="typeId" value=<?= $default[0]->type_id?>>
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
