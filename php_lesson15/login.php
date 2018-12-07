<?php
  require_once __DIR__. '/functions.php';
  require_once 'config.php';

  $errors = [];
  if (isset($_POST['login']) and isset($_POST['password'])) {
    $login = strip_tags($_POST['login']);
    $password = strip_tags(md5($_POST['password']));
    if (login($pdo, $login, $password)) {

      header('location: index.php');
    } else {
      $errors[] =  "не верный логин или пароль";
    }
  }
?>




<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
		content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Авторизация</title>
</head>
<body>

<section id="login">
    <div class="container">
	   <div class="row">
		  <div class="col-xs-12">
			 <div class="form-wrap">
				<h1>Авторизация</h1>
                  <?php foreach ($errors as $error): ?>
				  <ul>
					 <li><?= $error ?></li>
				  </ul>
                  <?php endforeach; ?>
				<form method="POST" id="login-form" action="">
				    <div class="form-group">
					   <label for="lg" class="sr-only">Логин</label>
					   <input type="text" placeholder="Логин" name="login" id="lg" class="form-control">
				    </div>
				    <div class="form-group">
					   <label for="key" class="sr-only">Пароль</label>
					   <input type="password"  placeholder="Пароль" name="password" id="key" class="form-control">
				    </div>
				    <input type="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Войти"> <br>
				    <p>Возможно вам потребуется <a href="registration.php"> Зарегистрироваться</a></p>
				</form>

				<hr>
			 </div>
		  </div> <!-- /.col-xs-12 -->
	   </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

</body>
</html>
