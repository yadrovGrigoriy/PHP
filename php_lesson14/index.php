
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
		content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>SQL</title>
</head>
<body>
<form method="post" name="insertDO">
    <input type="text"  name="desc" placeholder="Описание задания" value="">
    <input type="submit" name="add"  value="Добавить">
</form>

<form action="" name="sort">
    <label>Сортировать по:
	   <select name="sortBy">
		  <option value="status"
              <?php if (isset($_GET['sortBy'])){ if ($_GET['sortBy'] == "status"){ echo "selected";}}?> >По Статусу</option>
		  <option value="date"
              <?php if (isset($_GET['sortBy'])){ if ($_GET['sortBy'] == "date"){ echo "selected";}}?> >По Дате</option>
		  <option value="description"
              <?php if (isset($_GET['sortBy'])){ if ($_GET['sortBy'] == "description"){ echo "selected";}}?> >По Описанию</option>
	   </select></label>
    <input type="submit"  value="Отсортировать">

</form>
<table>
    <thead>
    <tr>
	   <td>Описание задачи</td>
	   <td>Дата добавления</td>
	   <td>Статус</td>
	   <td>Действия</td>
    </tr>
    </thead>
  <?php
    require_once 'config.php';
    //Добавление строки  через Input
    if (!empty($_POST['desc']) and $_POST['add'] ){
      $newDesc = strip_tags($_POST['desc']);
      $date = date("Y-m-d H:i:s");
      $stmt = $pdo->prepare("INSERT INTO `tasks` VALUES ('', ?,'',?)");
      $stmt->execute([$newDesc, $date]);
      $error_arr = $pdo->errorInfo();
      if ($pdo->errorCode() != 0000)
        echo 'SQL Ошибка';
    }
    //Удаляем строку по ссылке
    if (isset($_GET['del']) and isset($_GET['id'])){
      $delRow = $_GET['id'];
      $stmt = $pdo->prepare("DELETE FROM tasks WHERE id  = ?");
      $stmt->execute([$delRow]);
    }
    //меняем статус  по ссылке
    if (!empty($_GET['done']) == 1 and (isset($_GET['id']))){
      $upd = $_GET['id'];
      $stmt = $pdo->prepare("UPDATE tasks SET is_done = 1 WHERE id = ?");
      $stmt->execute([$upd]);
    }
    //редактирование текста задания
    if (isset($_GET['editInput']) and $_GET['id']){
      $editInput = $_GET['editInput'];
      $idEdit = $_GET['id'];
      $stmt = $pdo->prepare("UPDATE `tasks` SET `description`= ? WHERE id = ?");
      $stmt->execute([$editInput, $idEdit]);
    }
    //сортировка
    if (isset($_GET['sortBy'])) {
      switch ($_GET['sortBy']) {
        case "status":
          $sql = "SELECT * FROM tasks ORDER BY is_done";
          break;
        case "date":
          $sql = "SELECT * FROM tasks ORDER BY date_added";
          break;
        case "description":
          $sql = "SELECT * FROM tasks ORDER BY description";
          break;
        default:
          $sql = "SELECT * FROM tasks";
      }
    } else {
      $sql = "SELECT * FROM tasks";
    }
    //выводим табличку
    $res = $pdo->query($sql);
    while ($row = $res->fetch()) :?>
	   <tbody>
	   <tr>
		  <td><?php //редактирование текста задания
                if (isset($_GET['edit']) and isset($_GET['id'])) {
                  if ($_GET['id'] != $row['id']) {
                    echo $row['description'];
                  } else { ?>
				  <form action="">
					 <label><input name="editInput" value=""></label>
					 <input type="hidden" name="id" value="<?=$_GET['id']?>">
					 <input type="submit" value="Сохранить">
				  </form>
                  <?php }} else {
                  echo $row['description'];}?>
		  </td>
		  <td><?= $row['date_added']?></td>
		  <td><?php echo ($row['is_done'] == 0) ? "Не Выполнено" : "Выполнено";?></td>
		  <td><button><a href="index.php?edit&id=<?= $row['id']?>">Изменить</a></button>
			 <button><a href="index.php?done=1&id=<?= $row['id']?>">Выполнить</a></button>
			 <button><a href="index.php?del&id=<?= $row['id']?>">Удалить</a></button></td>
	   </tr>
	   </tbody>
    <?php endwhile;

  ?>
</table>

</body>
</html>


