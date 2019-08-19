<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/styleee.css">
    <title>Веб сайт</title>
</head>
  <body>
      <table align = "center">
      <?php if($errors) { ?>
      <tr><td><?= htmlentities($errors)?></td></tr>
      <?php } ?>
      </table>
      <form class="form-signin" method="POST" action="auth.php">
        <div class="text-center mb-4">
          <img class="mb-4" src="img/1.jpg" alt="" width="72" height="72">
          <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>
          <p>Авторизуйтесь с помощью предоставленных вам админом логином и паролем</p>
        </div>

      <div class="form-label-group">
        <input type="text" name="login" class="form-control" placeholder="Логин" required="" autofocus="">
        <br>
      </div>

      <div class="form-label-group">
        <input type="password" name="password" class="form-control" placeholder="Пароль" required="">
        <br>
      </div>
    <button class="btn btn-lg btn-primary btn-block" name="log_in" type="submit">Войти</button>
    <p class="mt-5 mb-3 text-muted text-center">©2019</p>

  </form>

  </body>
