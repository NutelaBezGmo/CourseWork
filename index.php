
<?php include_once 'C:\xampp\htdocs\course\blocks\head.php';?>

<body id="page-top">

<?php include_once 'C:\xampp\htdocs\course\blocks\header.php'?>
<div id="wrapper">
  <?php include_once 'C:\xampp\htdocs\course\blocks\right.php'?>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Главная</a>
          </li>
          <li class="breadcrumb-item active">Просмотр</li>
        </ol>
        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Главная</div>
          <div class="card-body">
            <div class="row">
            <div class="table-responsive">
              <a href="customers.php" class="btn btn-outline-info btn-lg mr-3" role="button" aria-pressed="true">Клиенты</a>
              <a href="order.php" class="btn btn-outline-info btn-lg mr-3" role="button" aria-pressed="true">Заказы</a>
              <a href="service.php" class="btn btn-outline-info btn-lg mr-3" role="button" aria-pressed="true">Услуги</a>
              <a href="build.php" class="btn btn-outline-info btn-lg mr-3" role="button" aria-pressed="true">Дома</a>
              <a href="build_type.php" class="btn btn-outline-info btn-lg mr-3" role="button" aria-pressed="true">Типы домов</a>
              <a href="employees.php" class="btn btn-outline-info btn-lg mr-3" role="button" aria-pressed="true">Сотрудники</a>
            </div>
            </div>
        <div class="d-flex flex-row m-5">
          <span style="text-align: left;" class="btn btn-warning" role="button" >Архив :</span>
          <div class="p-2"><a href="arch_order.php" class="btn btn-outline-info btn-lg " role="button" aria-pressed="true">
            Заказы</a></div>
          <div class="p-2"><a href="arch_customers.php" class="btn btn-outline-info btn-lg" role="button" aria-pressed="true">
            Клиенты</a></div>
          <div class="p-2"><a href="arch_employees.php" class="btn btn-outline-info btn-lg" role="button" aria-pressed="true">
            Сотрудники</a></div>
        </div>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>

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

  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>

</body>

</html>
