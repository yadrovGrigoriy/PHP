<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style.css">
  <title>Document</title>
<?php
  require_once 'config.php';
  $sql = "CREATE TABLE newTable ( 
      `id` INT NOT NULL ,
      `description` VARCHAR,
       `kjdhfkjlhgdf` INT NOT NULL ) ENGINE = InnoDB DEFAULT CHARSET=utf8";
  $res = $pdo->exec($sql);
  ?>
</head>
<body>
    <h2 >Список таблиц</h2>
    <div class="tables">
        <ul>
<?php //Список таблиц
    $sql = "SHOW tables";
    $tables = $pdo->query($sql);
    while ($table = $tables->fetch()) :?>
        <li>
          <a href="columns.php?table=<?=$table['Tables_in_yadrov']?>"><?=$table['Tables_in_yadrov']?></a>
        </li>
<?php endwhile;?>
        </ul>
    </div>

</body>
</html>

