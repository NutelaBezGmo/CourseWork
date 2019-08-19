<?php include_once 'C:\xampp\htdocs\course\blocks\head.php';?>

<body id="page-top">
  <?php
  include_once 'C:\xampp\htdocs\course\blocks\connection.php';
  if(isset($_GET['action'])){
    $sql = 'SELECT * FROM ((book_arch o NATURAL JOIN build b) NATURAL JOIN employees e)  JOIN customers c ON o.customer_id = c.customer_id NATURAL JOIN build_type bt
    WHERE o.order_id='.$_GET['id'];
    $stmt = $db->query($sql);
    $orders = $stmt->fetchAll();
    foreach($orders as $order)
    {
      $in = new DateTime($order->in_date);
      $out = new DateTime($order->out_date);
      $interval = $in->diff($out);
      if($interval->format('%a')==0) $interval = 0.5; else $interval = $interval->format('%a');
      $totalAmount = $order->cost * $interval;
      $servCost = $order->service_cost;
      $totalAmount +=$servCost;
    }
  }
  else{
    $sql = 'SELECT * FROM ((book o NATURAL JOIN build b) NATURAL JOIN employees e)  JOIN customers c ON o.customer_id = c.customer_id NATURAL JOIN build_type bt
    WHERE o.order_id='.$_GET['id'];
    $stmt = $db->query($sql);
    $orders = $stmt->fetchAll();
    foreach($orders as $order)
    {
      $in = new DateTime($order->in_date);
      $out = new DateTime($order->out_date);
      $interval = $in->diff($out);
      if($interval->format('%a')==0) $interval = 0.5; else $interval = $interval->format('%a');
      $totalAmount = $order->cost * $interval;
      $sql = "SELECT s.service_name, s.cost, sb.service_number FROM service_book sb JOIN service s ON
      s.service_id = sb.service_id WHERE sb.order_id = $order->order_id";
      $temp = $db->query($sql);
      $services = $temp->fetchAll();
      $serval = '<ul>';
      $servCost = 0;
      foreach($services as $service)
      {
        $serval .= "<li>$service->service_name : $service->service_number".' X '."$service->cost UAH</li>";
        $servCost += $service->cost * $service->service_number;
      }
      $serval .='</ul>';
    }
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
          <li class="breadcrumb-item active">Чек</li>
        </ol>

        <!-- Page Content -->
        <h1>Счёт</h1>
        <hr>
        <div class='content border p-2'>
        <div class='row'>
          <div class='col'>
              <p class="border border-top"> ООО "Зеленый Марш" <br>
                Hotel "Zeleniy Marsh"</p>
            </div>
            <div class='col'>
              <p><?= $orders[0]->full_name ?></p>
            </div>
            <div class='col'>
              <p class="float-left">Украина, Харьков, ул. Пушкина, д. Колотушкина 61168</p>
            </div>
        </div>
        <div class='row'>
          <div class='col'>
            <p>Бронь № 0000<?= $orders[0]->order_id*3?></p>
            <p>Дата прибытия <?= $orders[0]->in_date?></p>
            <p>Дата отбытия <?= $orders[0]->out_date?></p>
          </div>
          <div class='col'>
            <p>№ пасспорта <?= $orders[0]->pass ?> </p>
            <p>Мобильный телефон <?= $orders[0]->phone_number?></p>
          </div>
          <div class='col'>
            <p>Проживал(а) в доме <?= $orders[0]->name ?> на участке № <?=$orders[0]->sector_number?></p>
          </div>
        </div>
        <div class='row'>
          <div class='col'>
            <?php if (!isset($_GET['action'])){ ?><p>Дополнительные услуги: <?= $serval ?></p><?php };?>
          </div>
          <div class='col'>
            <p>Всего к оплате: </p>
            <p>Дополнительные услуги: <?=$servCost?>UAH</p>
            <p>Аренда дома: <?php print $order->cost ."UAH X ". $interval?></p>
            <hr>
            <p><?=$totalAmount+$servCost?>UAH</p>
          </div>
          <div class='col '>
            <img class="img-thumbnail" style=" width:200px" alt="Responsive image" src='img\1.jpg'>
          </div>
        </div>
         <button type="button" class="btn btn-info print center d-print-none" onClick="window.print();return false">Печать</button>
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

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

</body>

</html>
