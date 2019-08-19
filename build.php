<?php include_once 'C:\xampp\htdocs\course\blocks\head.php';?>

<body id="page-top">
  <?php
  include_once 'C:\xampp\htdocs\course\blocks\connection.php';
  $sql = "SELECT b.build_id,bt.name,bt.rooms_number,bt.area,bt.bed_number,bt.cost,bt.kitchen, b.sector_number FROM
  build_type bt NATURAL JOIN build b";
  $temp = $db->query($sql);
  $builds = $temp->fetchAll();
  ?>
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
          <li class="breadcrumb-item active">Дом</li>
        </ol>

        <!-- Page Content -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Дома <button><a href="build_INP.php">Добавить</a></button>
            <button><a href="build_type.php">Типы дома</a></button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Название</th>
                    <th>Номер сектора</th>
                    <th>Количество комнат</th>
                    <th>Площадь</th>
                    <th>Количество кроватей</th>
                    <th>Стоимость</th>
                    <th>Кухня</th>
                    <th></th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Название</th>
                    <th>Номер сектора</th>
                    <th>Количество комнат</th>
                    <th>Площадь</th>
                    <th>Количество кроватей</th>
                    <th>Стоимость</th>
                    <th>Кухня</th>
                    <th></th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                    foreach($builds as $build)
                    {
                      if($build->kitchen)$kitch = "Есть"; else $kitch = "Нет";
                      printf('<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td>
                      <td>%s</td><td>%s</td><td>%s</td><td><a href="build_INP.php?id='
                      .$build->build_id .'" class="fa fa-cog fa-1x"></a><br><a href="build_INP.php?action=delete&id='
                      .$build->build_id.'"class="fa fa-window-close fa-1x"></a></td></tr>',
                      htmlentities($build->name),$build->sector_number, $build->rooms_number,
                      $build->area, $build->bed_number,$build->cost,$kitch);
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
