<?php include_once 'C:\xampp\htdocs\course\blocks\head.php';?>

<body id="page-top">
<?php include_once 'C:\xampp\htdocs\course\blocks\header.php'?>
<?php include_once 'C:\xampp\htdocs\course\blocks\connection.php'?>
  <div id="wrapper">

    <!-- Sidebar -->
      <?php include_once 'C:\xampp\htdocs\course\blocks\right.php'?>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Главная</a>
          </li>
          <li class="breadcrumb-item active">Графики</li>
        </ol>

        <!-- Area Chart Example-->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-chart-area"></i>
            График заказов</div>
          <div class="card-body">
            <canvas id="myAreaChart" width="100%" height="30"></canvas>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-5">
            <div class="card mb-3">
              <div class="card-header">
                <i class="fas fa-chart-bar"></i>
                Заказы</div>
              <div class="card-body">
                <canvas id="myPieChart" width="100%" height="75"></canvas>

              </div>
            </div>
          </div>
        </div>


      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
  <?php include_once 'C:\xampp\htdocs\course\blocks\right.php'?>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <?php
  $days = array();
  for ($i=12; $i >=0; $i--) {
    $days[] = new DateTime("-$i day");
  }
  $val = array();
  foreach ($days as $day) {
    $sql = 'SELECT COUNT(order_id) as ord FROM book_arch WHERE order_date = "'.$day->format('Y-m-d').'"';
    $temp = $db->query($sql);
    $temp2 = $temp->fetchAll();
    $sql = 'SELECT COUNT(order_id) as ord FROM book WHERE order_date = "'.$day->format('Y-m-d').'"';
    $temp = $db->query($sql);
    $temp3 = $temp->fetchAll();
    $val[] = $temp2[0]->ord+$temp3[0]->ord;
   }
  echo<<<_END
  <script>// Set new default font family and font color to mimic Bootstrap's default styling
  Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#292b2c';

  // Area Chart Example
  var ctx = document.getElementById("myAreaChart");
  var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ["{$days[0]->format('M d')}","{$days[1]->format('M d')}","{$days[2]->format('M d')}","{$days[3]->format('M d')}","{$days[4]->format('M d')}",
    "{$days[5]->format('M d')}","{$days[6]->format('M d')}","{$days[7]->format('M d')}","{$days[8]->format('M d')}","{$days[9]->format('M d')}","{$days[10]->format('M d')}"
  ,"{$days[11]->format('M d')}","{$days[12]->format('M d')}"],
      datasets: [{
        label: "Количество заказов",
        lineTension: 0.3,
        backgroundColor: "rgba(2,117,216,0.2)",
        borderColor: "rgba(2,117,216,1)",
        pointRadius: 5,
        pointBackgroundColor: "rgba(2,117,216,1)",
        pointBorderColor: "rgba(255,255,255,0.8)",
        pointHoverRadius: 7,
        pointHoverBackgroundColor: "rgba(2,117,216,1)",
        pointHitRadius: 50,
        pointBorderWidth: 2,
        data: [$val[0],$val[1],$val[2],$val[3],$val[4],$val[5],$val[6],$val[7],$val[8],$val[9],$val[10],$val[11],$val[12]],
      }],
    },
    options: {
      scales: {
        xAxes: [{
          time: {
            unit: 'date'
          },
          gridLines: {
            display: false
          },
          ticks: {
            maxTicksLimit: 7
          }
        }],
        yAxes: [{
          ticks: {
            min: 0,
            max: 15,
            maxTicksLimit: 6
          },
          gridLines: {
            color: "rgba(0, 0, 0, .125)",
          }
        }],
      },
      legend: {
        display: false
      }
    }
  });
</script>
_END;
?>
<?php
$val = array();
$sql = 'SELECT COUNT(order_id) as ord FROM book_arch WHERE is_done = 1';
$temp = $db->query($sql);
$done = $temp->fetchAll();
$val[] = $done[0]->ord;
$sql = 'SELECT COUNT(order_id) as ord FROM book_arch WHERE is_done = 0';
$temp = $db->query($sql);
$done = $temp->fetchAll();
$val[] = $done[0]->ord;
$sql = 'SELECT COUNT(order_id) as ord FROM book';
$temp = $db->query($sql);
$done = $temp->fetchAll();
$val[] = $done[0]->ord;
echo<<<_HTML
  <script >// Set new default font family and font color to mimic Bootstrap's default styling
  Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#292b2c';

  // Pie Chart Example
  var ctx = document.getElementById("myPieChart");
  var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ["Совершены", "Отменены","В исполнении"],
      datasets: [{
        data: [{$val[0]},{$val[1]},{$val[2]}],
        backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745'],
      }],
    },
  });</script>
_HTML;
?>
</body>

</html>
