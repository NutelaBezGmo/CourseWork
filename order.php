<?php include_once 'C:\xampp\htdocs\course\blocks\head.php';?>
<body id="page-top">
  <?php
  include_once 'C:\xampp\htdocs\course\blocks\connection.php';

  $sql = 'SELECT o.order_date,c.full_name, bt.name, bt.cost,
  b.sector_number, o.in_date, o.out_date, e.second_name, o.order_id
  FROM ((book o NATURAL JOIN build b) NATURAL JOIN employees e)  JOIN customers c ON o.customer_id = c.customer_id NATURAL JOIN build_type bt WHERE 1';
  if(autoBLUE('buildType')!=NULL&&autoBLUE('buildType')!='all'){
    $sql .=" AND bt.type_id=".$_POST['buildType'];
  }
  if(autoBLUE('month')!=NULL&&autoBLUE('month')!='all'){
    $sql .=" AND MONTH(o.in_date)=".$_POST['month'];
  }
  $stmt = $db->query($sql);
  $orders = $stmt->fetchAll();
  $sql = 'SELECT DISTINCT bt.name,bt.type_id FROM ((book b NATURAL JOIN build bl) JOIN build_type bt ON bt.type_id = bl.type_id)';
  $temp = $db->query($sql);
  $buildTypes = $temp->fetchAll();

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
          <li class="breadcrumb-item active">Таблица</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header d-print-none">
            <i class="fas fa-table"></i>
            Заказы <button><a href="order_INP.php">Добавить</a></button></div>
          <div class="card-body">
            <div class="table-responsive">
             <form method="POST" action="order.php">
               <table>
                 <tr>
                   <th>Тип дома</th>
                   <th>Месяц</th>
                   <th>Посмотреть результат</th>
                 </tr>
               <tr>
               <td>
              <select class="m-3" name="buildType">
                <?php if($buildTypes) print '<option value="all">Все дома</option>';
                else print '<option disabled value="all">Нет домов</option>';?>
                <?php foreach ($buildTypes as $type){
                  if(autoBLUE("buildType")==$type->type_id)
                    print '<option selected value="'.$type->type_id.'">'.$type->name.'</option>';
                  else
                    print '<option value="'.$type->type_id.'">'.$type->name.'</option>';
              } ?>
            </select></td><td>
              <select class="m-3" name="month">
                <?php if(autoBLUE("month")=='all')
                        print '<option selected value="all">Все</option>';
                      else
                          print '<option value="all">Все</option>';?>
                <?php foreach ($month as $num=>$mon){
                  if(autoBLUE("month")==$num)
                    print '<option selected value="'.$num.'">'.$mon.'</option>';
                  else
                    print '<option value="'.$num.'">'.$mon.'</option>';
              } ?>
            </select></td><td>
              <button type="submit">Показать</button></td></table>
            </form>
              </div>
              <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <tbody>
                  <?php
                  $allSum = 0;
                    foreach($orders as $order)
                    {
                      $in = new DateTime($order->in_date);
                      $out = new DateTime($order->out_date);
                      $interval = $in->diff($out);
                      if($interval->format('%a')==0) $interval = 0.5; else $interval = $interval->format('%a');
                      $totalAmount = $order->cost * $interval;
                      $allSum += $totalAmount;
                      $sql = "SELECT s.service_name, s.cost, sb.service_number FROM service_book sb JOIN service s ON
                      s.service_id = sb.service_id WHERE sb.order_id = $order->order_id";
                      $temp = $db->query($sql);
                      $services = $temp->fetchAll();
                      $serval = '<ul>';
                      foreach($services as $service)
                      {
                        $serval .= "<li>$service->service_name : $service->service_number</li>";
                        $totalAmount += $service->cost * $service->service_number;
                        $allSum += $service->cost * $service->service_number;
                      }
                      $serval .='</ul>';
                      printf('<tr class="danger"><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%0.2f UAN</td>
                      <td>%s</td><td><a href="order_change_INP.php?id='
                      .$order->order_id .'" class="fa fa-cog fa-1x"></a><br><a href="order_change_INP.php?action=delete&id='
                      .$order->order_id.'"class="fa fa-window-close fa-1x"></a><br><a href="list.php?id='
                      .$order->order_id.'"class="fa fa-credit-card fa-1x"></a></td></tr>',
                      htmlentities($order->full_name), htmlentities($order->name),
                      $order->sector_number, $serval ,$order->in_date,$order->out_date, $totalAmount,
                      htmlentities($order->order_date));
                    }
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>Клиент</th>
                    <th>Дом</th>
                    <th>Номер сектора</th>
                    <th>Дополнительные услуги</th>
                    <th>Дата въезда</th>
                    <th>Дата выезда</th>
                    <th>Общая сумма выплат</th>
                    <th>Дата оформления</th>
                    <th></th>
                  </tr>
                </tfoot>
                <thead >
                  <tr>
                    <th class="danger">Клиент</th>
                    <th>Дом</th>
                    <th>Номер сектора</th>
                    <th>Дополнительные услуги</th>
                    <th>Дата въезда</th>
                    <th>Дата выезда</th>
                    <th><?php print" $allSum UAH";?></th>
                    <th>Дата оформления</th>
                    <th></th>
                  </tr>
                </thead>
              </table>
             <button type="button" class="btn btn-info print center d-print-none" onClick="window.print();return false">Печать</button>
            </div>
          </div>
          <div class="card-footer small text-muted d-print-none">Updated yesterday at 11:59 PM</div>
        </div>

        <p class="small text-center text-muted my-5 d-print-none">
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
