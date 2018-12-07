<?php
require_once __DIR__ . '/function.php';
  $errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $login = $_POST['login'];
  	if(!empty($_POST['login'])) {
       $password = $_POST['password'];
        login($login, $password);
         header('location: list.php');
	    exit;

     } else {
       $errors[] = "Не верный логин или пароль";
	}
}


?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
		content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Авторизация</title>
</head>
<body>
<form action="" method="POST">
    	<h2>Авторизация</h2>


    <p><label>Логин: <input type="text" name="login">  введите только Логин чтобы войти как Гость</label></p>
    <p><label>Пароль: <input type="password" name="password"></label></p>
    <ul>
      <?php foreach ($errors as $error) : ?>
		<li><?= $error ?></li>

      <?php endforeach; ?>
    </ul>
	<p><input type="submit"></p>
</form>
</body>
</html>

