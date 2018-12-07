<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
<a href="index.php?createTable"></a>

</body>
</html>


<?php

  require_once 'config.php';
  if  ($_GET['createTable'])
// $pdo->exec("CREATE TABLE `netology`.`films`(
//      id INT AUTO_INCREMENT,
//      title VARCHAR(20),
//      date_release_ INT,
//      country VARCHAR,
//      director VARCHAR,
//      PRIMARY KEY(id)
//)ENGINE=InnoDB DEFAULT CHARSET = utf8");
 $pdo->exec("CREATE TABLE `netology`.`new table` (id INT AUTO_INCREMENT, new_task VARCHAR ) ENGINE = InnoDB;");