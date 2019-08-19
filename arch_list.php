<?php include_once 'C:\xampp\htdocs\course\blocks\head.php';?>

<body id="page-top">
  <?php
  include_once 'C:\xampp\htdocs\course\blocks\connection.php';
  if(isset($_GET['id'])){
    $sql = 'SELECT * FROM employees_arch WHERE dismiss_id='.$_GET['id'];
    $temp = $db->query($sql);
    $empl = $temp->fetchAll();
  }
  ?>
<?php include_once 'C:\xampp\htdocs\course\blocks\header.php'?>

  <div id="wrapper">

    <!-- Sidebar -->
    <?php include_once 'C:\xampp\htdocs\course\blocks\right.php'?>


    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb d-print-none">
          <li class="breadcrumb-item">
            <a href="index.php">Главная</a>
          </li>
          <li class="breadcrumb-item active">Архив</li>
        </ol>

        <!-- Page Content -->
        <h1>Выписка</h1>
        <hr>
        <div class='content border p-2'>
        <p>Вот человек с фамилией <?=$empl[0]->second_name?> действительно работал у нас с <?=$empl[0]->date_of_employment?>
         по <?= $empl[0]->date_of_dismissal?></p>
      </div>
        <button type="button" class="btn btn-default print center d-print-none" onClick="window.print();return false">Печать</button>
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
