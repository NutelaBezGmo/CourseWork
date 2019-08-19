<?php include_once 'C:\xampp\htdocs\course\blocks\head.php';?>
<body id="page-top">
  <?php
  include_once 'C:\xampp\htdocs\course\blocks\connection.php';
  $sql = 'SELECT dismiss_id,first_name, second_name, phone_number, date_of_employment, date_of_dismissal, reason_for_dismiss
  FROM employees_arch ';
  $stmt = $db->query($sql);
  $employees = $stmt->fetchAll();
  ?>
  <?php include_once 'C:\xampp\htdocs\course\blocks\header.php'?>

  <div id="wrapper">

    <?php include_once 'C:\xampp\htdocs\course\blocks\right.php';?>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Главная</a>
          </li>
          <li class="breadcrumb-item active">Архив</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Сотрудники</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Номер телефона</th>
                    <th>Дата приема на работу</th>
                    <th>Дата увольнения</th>
                    <th>Причина увольнения</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Номер телефона</th>
                    <th>Дата приема на работу</th>
                    <th>Дата увольнения</th>
                    <th>Причина увольнения</th>
                    <th></th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                    foreach($employees as $employee)
                    {
                      printf('<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>
                      <td><a href="arch_list.php?id='
                      .$employee->dismiss_id.'"class="fa fa-cog fa-1x"></a></td></tr>',
                      htmlentities($employee->first_name), htmlentities($employee->second_name),
                      $employee->phone_number, htmlentities($employee->date_of_employment),
                      $employee->date_of_dismissal, $employee->reason_for_dismiss);
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>

        <p class="small text-center text-muted my-5">
          <em>More table examples coming soon...</em>
        </p>

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
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
