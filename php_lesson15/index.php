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


<?php
  require_once 'config.php';
  require_once 'functions.php';
  //проверяем авторизацию
  if (!isAuthorized())  {?>
	<div class="authorized">
			<h2 class='notAuthorized'>Вы не Авторизованы!</h2>
	 		<p>Необходимо <a href='login.php'>Авторизоваться</a> или <a href="registration.php">Зарегистрироваться</a></p>
	 	</div>
	<?php 	
	http_response_code(403);
	die;
  }

  var_dump($_SESSION['user']);
  //Добавление строки
  if (!empty($_POST['desc']) and $_POST['add'] ){
    $newDesc = strip_tags($_POST['desc']);
    $date = date("Y-m-d H:i:s");
    $userId = $_SESSION['user']['id'];
    insertRow($pdo, $userId, $newDesc, $date);
  }
  //Удаляем строку по ссылке
  if (isset($_GET['del']) and isset($_GET['id'])){
    $delRow = $_GET['id'];
    delRow($pdo,$delRow);
  }
  //меняем статус  по ссылке
  if (!empty($_GET['done']) == 1 and (isset($_GET['id']))){
    $upd = $_GET['id'];
    updRow($pdo,$upd);
  }
  //редактирование текста задания
  if (isset($_GET['editInput']) and $_GET['id']){
    $editInput = $_GET['editInput'];
    $idEdit = $_GET['id'];
    editRow($pdo, $editInput, $idEdit);
  }

  //передача задания другому пользователю
  if (isset($_GET['assigned_user']) and isset($_GET['id_row'])) {
    $assignedUser = $_GET['assigned_user'];
    $idRow = $_GET['id_row'];
    transferRow($pdo, $assignedUser, $idRow);
  }

?>
<body>
<h2>Здравтсвуйте </h2>
<p> Вы вошли как : <?= authorizedUser()?> <button><a href="logout.php">Выход</a></button></p>
<h3>Вот список дел созданых вами:</h3>
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
<!--	   <td>Автор</td>-->
	   <td>Ответственный</td>
	   <td>Передать</td>
    </tr>
    </thead>
<?php
	//выводим табличку дел созданых вошедшим пользователем + сортировка
    if (isset($_GET['sortBy'])) {
      $sortBy = $_GET['sortBy'];
      $sql = sortBy($sortBy);
    } else {
      $sql = "SELECT task.id, task.user_id, task.assigned_user_id, task.description, task.is_done, task.date_added, user.login, user.password FROM `task` join `user` ON `user`.id = `task`.user_id WHERE `user_id` = ?";
    }
    $enteredUserID = $_SESSION['user']['id'];
    $myTask = getMyTask($pdo, $enteredUserID, $sql);
    while ($row = $myTask->fetch()) :?>
	   <tbody>
	   <tr>
		  <td><!--Задача-->
		    <?php //редактирование текста задания
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
		  <td><!--дата и время добавления-->
			 <?= $row['date_added']?>
		  </td>
		  <td><!--Статус-->
		    	 <?php echo ($row['is_done'] == 0) ? "Не Выполнено" : "Выполнено";?>
		  </td>
		  <td>
			 <button><a href="index.php?edit&id=<?= $row['id']?>">Изменить</a></button>
			 <button><a href="index.php?done=1&id=<?= $row['id']?>">Выполнить</a></button>
			 <button><a href="index.php?del&id=<?= $row['id']?>">Удалить</a></button></td>
<!--		  <td>--><?php
//			 	$author = getAuthor($pdo, $row);
//                	echo $author['login']?>
<!--		  </td>-->
		  <td>
		    <?php
				$user = getAssignedUser($pdo,$row);
                	echo $user['login'];
		    ?></td>
		  <td>
			 <form action="">
			 <label><select name="assigned_user">
				<?php // получение списка пользователей
				  $users = getUsers($pdo);
				  while ($user = $users->fetch()) :?>
		  			<option value="<?= $user['id']?>"><?= $user['login']?></option>
				<?php endwhile;?>
				</select></label>
				<input type="hidden" name="id_row" value="<?= $row['id']?>">
				<input type="submit">
			 </form>	
		  </td>
	   </tr>
	   </tbody>
    <?php endwhile;

  ?>
</table>
<br>
<!--выводим табличку переданых дел-->
<h3>Дела переданные вам от других пользователей:</h3>

<table>
    <thead>
    <tr>
	   <td>Описание задачи</td>
	   <td>Дата добавления</td>
	   <td>Статус</td>
	   <td>Действия</td>
	   <td>Автор</td>
<!--	   <td>Ответственный</td>-->
	   <td>Передать</td>
    </tr>
    </thead>
  <?php
//вывод таблички
    $enteredUserID = $_SESSION['user']['id'];
    $otherTask = getOthersTask($pdo, $enteredUserID);
    while ($row = $otherTask->fetch()) :?>
	   <tbody>
	   <tr>
		  <td><!--Тест дела-->
		    <?php //редактирование текста задания
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
		  <td><!--дата и время добавления -->
		    <?= $row['date_added']?>
		  </td>
		  <td><!--Статус-->
		    <?php echo ($row['is_done'] == 0) ? "Не Выполнено" : "Выполнено";?>
		  </td>
		  <td><!--ссылки -->
			 <button><a href="index.php?edit&id=<?= $row['id']?>">Изменить</a></button>
			 <button><a href="index.php?done=1&id=<?= $row['id']?>">Выполнить</a></button>
			 <button><a href="index.php?del&id=<?= $row['id']?>">Удалить</a></button></td>
		  <td><!--Автор-->
		    <?php  $author = getAuthor($pdo, $row);
 			 echo $author['login']?>
		  </td>
<!--		  <td>Ответсвенный-->
              <?php
//                $user = getAssignedUser($pdo,$row);
//                echo $user['login'];
//              ?><!--</td>-->
		  <td>
			 <form action="">
				<label><select name="assigned_user">
                        <?php // получение списка пользователей
                          $users = getUsers($pdo);
                          while ($user = $users->fetch()) :?>
						<option value="<?= $user['id']?>"><?= $user['login']?></option>
                          <?php endwhile;?>
				    </select></label>
				<input type="hidden" name="id_row" value="<?= $row['id']?>">
				<input type="submit">
			 </form>
		  </td>
	   </tr>
	   </tbody>
    <?php endwhile;

  ?>
</table>

</body>
</html>


