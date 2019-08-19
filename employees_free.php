<?php include_once 'C:\xampp\htdocs\course\blocks\head.php';?>
<body id="page-top">

<?php include_once 'C:\xampp\htdocs\course\blocks\header.php'?>

  <div id="wrapper">
    <?php
      include_once 'C:\xampp\htdocs\course\blocks\connection.php';
    if(isset($_GET['id'])){
        $sql = 'SELECT e.first_name,e.second_name,e.phone_number,p.post_name,e.date_of_employment,e.employees_id,
        COUNT(b.order_id) as orders FROM employees e NATURAL JOIN post p NATURAL JOIN book b WHERE e.employees_id='.$_GET['id'];
        $temp = $db->query($sql);
        $default = $temp->fetchAll();
        $sql = 'SELECT e.second_name, e.employees_id FROM employees e NATURAL JOIN post p WHERE p.post_id<3
        AND e.employees_id !='.$_GET['id'];
        $temp = $db->query($sql);
        $newEmpl = $temp->fetchAll();
      }
    ?>
    <!-- Sidebar -->
<?php include_once 'C:\xampp\htdocs\course\blocks\right.php';?>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php">Главная</a>
          </li>
          <li class="breadcrumb-item active">Сотрудник</li>
        </ol>


        <!-- Page Content -->
        <h1>Увольнение сотрудника</h1>
        <form method="POST" action="employees_free.php?id=<?=$default[0]->employees_id?>">
          <div class="row">
            <div class="col">
              <table>
              <tr><td>Имя:</td>
              <td><input type="text" name="firstName" readonly value="<?=htmlentities($default[0]->first_name)?>" required="required" maxlength="30">
              </td></tr>

              <tr><td>Фамилия:</td>
              <td><input type="text" name="secondName" readonly value="<?=htmlentities($default[0]->second_name)?>" required="required" maxlength="30">
              </td></tr>

              <tr><td>Номер телефона:</td>
              <td><input type="text" name="phoneNumber" readonly value="<?=htmlentities($default[0]->phone_number)?>" required="required"  maxlength="12">
              </td></tr>

              <tr><td>Должность:</td>
              <td><input readonly value="<?=htmlentities($default[0]->post_name)?>"></td>
              </tr>

              <tr><td>Дата приёма на работу:</td>
              <td><input type="date" readonly name="dateOfEmploy" required="required" value="<?=htmlentities($default[0]->date_of_employment)?>" >
              </td></tr>

              <tr><td>Дата увольнения:</td>
              <td><input type="date" readonly name="dateOfDismiss" required="required" value="<?=date("Y-m-d");?>" >
              </td></tr>

              <tr><td></td>
              <td><input type="hidden" name="id" value="<?=$default[0]->employees_id?>" required="required">
              </td></tr>

              <tr ><td>Причина увольнения:</td>
                <td><textarea name="reason" required="required" rows="7" cols="50" name="describe"></textarea>
              </td></tr>
              <tr><td colspan="2" align="center">
              <input type="submit" name="SUBMIT" value="Подтвердить" required="required">
              </td></tr>
              </table>
            </div>
            <div class="col">
              <table>
                <?php if($default[0]->orders){?>
                <tr><td>У данного сотрудника существует <?=$default[0]->orders ?> <?php
                    if($default[0]->orders==1) print "контракт";else if($default[0]->orders<5) print 'контракта';
                    else print 'контрактов';
                ?></td></tr>
                <tr><td>На какого сотрудника их повесить?</td></tr>
                <tr><td><select name="newEmpl">
                  <?php
                  if(count($newEmpl)==0) print '<option disabled >Подходящих сотрудников нет.</option>';
                  else
                  foreach ($newEmpl as $victim) {
                    print '<option value="'.$victim->employees_id.'">'.$victim->second_name.'</option>';
                  }?>
                </select></td>
              <input type="hidden" name="orderss" value="<?=$default[0]->orders?>"></tr>
              <?php }?>
              </table>
            </div>
          </div>
    </form>
      </div>
      <?php
      if (isset($_POST['SUBMIT'])){
        try{
          if($_POST['orderss']){
            try{
         $sql = 'UPDATE book b SET b.employees_id='.$_POST['newEmpl'].' WHERE b.employees_id='.$_POST['id'];
         $stmt = $db->query($sql);
        }catch(PDOException $e){
          error404("Вы не можете уволить сотрудника если некому ввыполнять его работу!");
          exit();
        }
          }
         $stmt = $db->prepare('INSERT INTO employees_arch VALUE(?, ?, ?, ?, ?, ?, ?)');
         $stmt->execute(array(NULL, $_POST['firstName'], $_POST['secondName'],
         $_POST['phoneNumber'], $_POST['dateOfEmploy'], $_POST['dateOfDismiss'], $_POST['reason']));
         $stmt = $db->query("DELETE FROM users WHERE user_id=".$_POST['id']);
         $stmt = $db->query("DELETE FROM employees WHERE employees_id=".$_POST['id']);
         header('Location: employees.php');
       }catch(PDOException $e){
         error404($e);
         exit();
       }
     }
      ?>
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
