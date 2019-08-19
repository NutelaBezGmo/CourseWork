<?php include_once 'C:\xampp\htdocs\course\blocks\head.php';?>
<body id="page-top">
  <?php
  include_once 'C:\xampp\htdocs\course\blocks\connection.php';

  $sql = 'SELECT c.customer_id, c.full_name, c.pass, c.phone_number, b.in_date, b.out_date FROM customers c
  LEFT JOIN book b ON b.customer_id = c.customer_id WHERE 1';
  if(autoBLUE('is_active')!=NULL&&autoBLUE('is_active')!='all'){
    if($_POST['is_active']==1)
      $sql .= ' AND c.customer_id IN (SELECT b1.customer_id FROM book b1)';
    else {
      $sql .= ' AND c.customer_id NOT IN (SELECT b1.customer_id FROM book b1)';
    }
  }
  $stmt = $db->query($sql);
  $customers = $stmt->fetchAll();
  ?>
  <?php include_once 'C:\xampp\htdocs\course\blocks\header.php'?>

  <div id="wrapper">

    <?php include_once 'C:\xampp\htdocs\course\blocks\right.php';?>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb d-print-none">
          <li class="breadcrumb-item">
            <a href="index.php">Главная</a>
          </li>
          <li class="breadcrumb-item active">Архив</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header d-print-none">
            <i class="fas fa-table"></i>
            Клиенты</div>
          <div class="card-body">
            <div class="table-responsive">
              <form method="POST" action="arch_customers.php">
              <table>
                <tr>
                  <th>Контракт</th>
                  <th>Посмотреть результат</th>
                </tr>
              <tr>
                <td><select class="m-3" name="is_active">
                  <option <?php if(autoBLUE('is_active')=='all') print "selected";?> value="all">Все</option>
                  <option <?php if(autoBLUE('is_active')=='1') print "selected";?> value="1">Активный</option>
                  <option <?php if(autoBLUE('is_active')=='0') print "selected";?> value="0">Нет контракта</option>
                </select></td>
              <td><button type="submit">Показать</button></td></tr>
            </table>
             </form>
              <table class="table table-bordered d-print-table" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>ФИО</th>
                    <th>Паспорт</th>
                    <th>Номер телефона</th>
                    <th>Активный контракт</th>
                    <th></th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>ФИО</th>
                    <th>Паспорт</th>
                    <th>Номер телефона</th>
                    <th>Активный контракт</th>
                    <th></th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                    foreach($customers as $customer)
                    {
                      if($customer->in_date) $contract = "Да"; else $contract = "Нет";
                      printf('<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td><a href="customer_CHG.php?id='
                      .$customer->customer_id .'" class="fa fa-cog fa-1x"></a></td></tr>',
                      htmlentities($customer->full_name),htmlentities($customer->pass),
                      $customer->phone_number, $contract);
                    }
                  ?>
                </tbody>
              </table>
              <button type="button" class="btn btn-info print center d-print-none" onClick="window.print();return false">Печать</button>
            </div>
          </div>
          <div class="card-footer small text-muted d-print-none">Updated yesterday at 11:59 PM</div>
        </div>

        <p class="small text-center text-muted my-5 d-print-none">
          <em>Дада я</em>
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
