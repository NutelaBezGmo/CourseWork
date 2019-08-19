<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/1.css">
    <title>Веб сайт</title>
</head>
<body>
<?php require_once "blocks/header.php"?>
<div class="container">
  <h3 class="mb-5">Наши статьи</h3>
  <div class="d-flex flex-wrap">
    <?php
      for ($i=1; $i < 6; $i++):
    ?>
    <div class="card mb-4 shadow-sm">
        <div class="card-header">
          <h4 class="my-0 font-weight-normal">Просто текст</h4>
        </div>
        <div class="card-body">
          <img src="img/<?php echo $i ?>.jpg" class="img-thubnail">
          <ul class="list-unstyled mt-3 mb-4">
            <li>10 users included</li>
            <li>2 GB of storage</li>
            <li>Email support</li>
            <li>Help center access</li>
          </ul>
          <button type="button" class="btn btn-lg btn-block btn-outline-primary">Подробнее</button>
        </div>
      </div>
    <?php endfor;?>
  </div>
</div>
<?php require "blocks/footer.php"?>
</body>
</html>
