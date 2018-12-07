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
 <h2>Создать новую таблицу</h2>
 <form action="">
  <label>Название <input type="text" name="tabName"></label>
   <a href="new_table.php?newInput"></a>


  <input type="submit">
</form>

</body>
</html><?php
  require_once 'config.php';
  //создание новой таблицы
  if  (isset($_GET['newDBname'])) {
    $newDB = $_GET['newDBname'];

  }
 ?>
