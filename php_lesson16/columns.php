<?php
  require_once 'config.php';
  session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
		content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<div class="tablesItems">
  <h3>Название таблицы: <?= $_SESSION['table']?></h3>
  <table>
    <thead>
    <tr>
      <td>Назваине поля </td>
      <td>Тип поля </td>
      <td></td>
    </tr>
    </thead>
    <tbody>

<?php
  //Удаление поля
  if  (isset($_GET['del']) && isset($_GET['col']) ){
    $delCol = $_GET['col'];
    $table = $_SESSION['table'];
    $sql = "ALTER TABLE `$table` DROP COLUMN `$delCol` ";
    $del = $pdo->exec($sql);
  }

  //изменение названия поля
  if (isset($_POST['newName']) && isset($_POST['oldName']) && isset($_POST['type'])){
    $newName = $_POST['newName'];
    $oldName = $_POST['oldName'];
    $type = $_POST['type'];
    $table = $_SESSION['table'];
    $query = "ALTER TABLE $table CHANGE `$oldName` $newName $type";
    $pdo->exec($query);
  }

  if (isset($_GET['table'])) {
    $_SESSION['table'] = $_GET['table'];
  }
  //Список полей и типов данных в них
  $table = $_SESSION['table'];
  $sql = "SHOW COLUMNS FROM `$table`";
    $res = $pdo->query($sql);
      while ($tableCol = $res->fetch()) { ?>
        <tr>
          <td>
            <?php
              if (isset($_GET['name']) || isset($_GET['type'])) {
                if ($_GET['name'] != $tableCol['Field']) {
                  echo $tableCol['Field'];
                } else { ?>
                  <form action="" method="post">
                    <input type="text" name="newName" placeholder="<?= $_GET['name']?>">
                    <input type="hidden" name="oldName" value="<?= $_GET['name']?>">
                    <input type="hidden" name="type" value="<?= $tableCol['Type']?>">
                    <input type="submit" value="Изменить">
                  </form>
                <?php }} else {
                echo $tableCol['Field'];
              }
              ?>

          </td>
          <td>
            <?php echo $tableCol['Type'] ?>
          </td>
          <td>
            <button><a href="columns.php?del&col=<?= $tableCol['Field'] ?>">Удалить</a></button>
            <button><a href="columns.php?name=<?= $tableCol['Field']?>&type=<?= $tableCol['Type']?>">Изменить</a></button>
          </td>
        </tr>
      <?php }
?>
    </tbody>
  </table>
  <a href="index.php">Список таблиц</a>

</body>
</html>