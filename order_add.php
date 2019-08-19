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
          <li class="breadcrumb-item active">Заказы</li>
        </ol>
        <!-- Page Content -->
        <h1>Новый заказ</h1>
        <hr><?=$_POST['phone_number']?>
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
          <div class="row justify-content-md-center">
         <div class="col">
            <table class="table-hover">
              <th>Клиент</th>
            <tr><td>ФИО:</td>
            <td><input type="text"  name="full_name" value="<?=autoBLUE("full_name")?>"  maxlength="60">
            </td></tr>

            <tr><td>Паспорт:</td>
            <td><input type="text" name="pass" value="<?=autoBLUE('pass')?>"  maxlength="10">
            </td></tr>

            <tr><td>Номер телефона:</td>
            <td><input id="phone" type="text" name="phone_number" value="<?=autoBLUE('phone_number')?>" maxlength="12">
            </td></tr>
            <tr><td>
              Старый клиент:
            </td><td><input type="checkbox" value="1" <?php if(autoBLUE('old')) print "checked";?> name="old"></td></tr>
            </table>

            <table class="table-hover">
              <th>Заказ</th>
            <tr class="warning"><td>Сотрудник:</td>
            <td><input type="text" name="employees"  value="<?= $_SESSION['second_name']?>" readonly>
            </td></tr>

            <tr><td>Дом:</td>
            <td><select name="build">
              <?php for($i=0;$i<count($build);$i++){
            print '<option value="'.$build[$i]->build_id.'">'.$build[$i]->name." ".$build[$i]->sector_number.'</option>';
            }
            if(count($build)==0){
              print "<option disabled>Подходящих домов нет</option>";
            }?>
            </select>
            </td></tr>

            <tr><td>Дата въезда:</td>
              <td><input type="date" value="<?=autoBLUE('in_date')?>" name="in_date">
              </td></tr>

            <tr><td>Дата выезда:</td>
              <td><input type="date" value="<?=autoBLUE('out_date')?>" name="out_date"  >
              </td></tr>
              <tr><td><br></td></tr>
            <tr><td colspan="2" align="center">
            <input type="submit" name="SUBMIT" value="Подтвердить" required="required"></td><td>
            <input type="submit" name="CHEK" value="Проверить свободные дома" required="required">
            </td></tr>
            </table>
          </div>
          <div class="col-6">
            <table class="table-hover">
              <th>Дополнительные услуги</th>
              <tr>
                <td>
                <select id="service" name="service" size=3>
                  <?php foreach ($services as $service) {
                    print '<option value="'.$service->service_id.'">'.$service->service_name.
                    '  :  '.$service->cost.' UAH</option>';
                  }?>
                </select>
              </td>
            </tr>
            <tr>
              <td>
              <textarea id="alltext" rows="5" cols="45" name="describe" readonly><?=autoBLUE('describe')?></textarea>
              <input type="hidden" id = "da" name="da" value="<?=autoBLUE('da')?>" >
            </td></tr>
              <tr>
                <td><span class="mr-3 btn" onclick="addText()">Добавить</span>
                <span class="mr-3 btn" onclick="deleteText()">Удалить</span>
                <span class="mr-3 btn" onclick="clearText()">Очистить</span></td>
              </tr>
            </table>
          </div>
        </div>
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
  <script>
    function addText() {
      var e = document.getElementById("service");
      var temp = e.options[e.selectedIndex].text;
      var temp1 = e.options[e.selectedIndex].value;
        document.getElementById("alltext").value += temp ;
        document.getElementById("alltext").value += '\n';
        document.getElementById("da").value += temp1;
        document.getElementById("da").value += ' ';
    }
    function deleteText(){
      var e = document.getElementById("service");
      var oldS = e.options[e.selectedIndex].text;
      oldS +='\n';
      var flag = true;
      var i = 0;
      var newS = '';
      var text = document.getElementById("alltext").value;
      while(i<text.length&&flag) {
        if (text.substring(i, i + oldS.length) == oldS) {
          text = text.substring(0, i) + newS + text.substring(i + oldS.length, text.length);
          flag = false;
        }
        i++;
      }
      document.getElementById("alltext").value = text;
      text = document.getElementById("da").value;
      oldS = e.options[e.selectedIndex].value;
      oldS += ' ';
      flag = true;
      i = 0;
      while(i<text.length&&flag) {
        if (text.substring(i, i + oldS.length) == oldS) {
          text = text.substring(0, i) + newS + text.substring(i + oldS.length, text.length);
          flag = false;
        }
        i++;
      }
    document.getElementById("da").value = text;
  }
  function clearText(){
    var text = '';
    document.getElementById("da").value = text;
    document.getElementById("alltext").value = text;
  }
  </script>
  <script src="js/jquery.maskedinput.js"></script>
  <script>
$(function(){
  $.mask.definitions['H']='[А-Яa-f0-9]';
  $("#phone").mask("380999999999");
  $("#pass").mask("HHHHHH");

});
</script>
</body>

</html>
