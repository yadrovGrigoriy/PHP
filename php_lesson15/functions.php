<?php
  session_start();
  require_once 'config.php';


  //Регистрация пользователя
  function registration($pdo, $login, $password)
  {
        $sql = $pdo->prepare("INSERT INTO `user` (id, login, password) VALUES ('', ?, ?)");
        $sql->execute([$login, $password]);
        return true;
  }

  //Получение пользователя по логину  из базы
  function getUser($pdo, $login)
  {
    $stmt = $pdo->prepare("SELECT `id`, `login`, `password` FROM `user` WHERE login = ?");
    $stmt->execute([$login]);
    if ($stmt->execute([$login])) {
      $user = $stmt->fetch();
      if ($login == $user['login']) {
        return $user;
      } else {
        $errors[] = "Нет такого пользователя";
      }
    }
  }

  //получаем список пользователей
  function getUsers($pdo)
  {
    $userQuery = "SELECT `id`, `login` FROM `user`";
    $users = $pdo->query($userQuery);
    return $users;
  }

  //Авторизация
  function login($pdo, $login, $password)
  {
    $user = getUser($pdo, $login);
    if ($user and $user['password'] == $password){
      $_SESSION['user'] = $user;
      return true;
    }
  }

  //Авторизован ли
  function isAuthorized()
  {
    return !empty($_SESSION['user']['login']);
  }

  //имя авторизованого пользователя
  function authorizedUser()
  {
   return $_SESSION['user']['login'];
  }

  //имя ответсвтенного ползователя
  function getAssignedUser($pdo,$row)
  {
    $assignedUserID = $row['assigned_user_id'];
    $assignedUser = $pdo->prepare("SELECT `login` FROM `task` join `user` ON `user`.id = `task`.assigned_user_id Where assigned_user_id = ?");
    $assignedUser->execute([$assignedUserID]);
    $user = $assignedUser->fetch();
    return $user;
  }

  //имя Автора
  function getAuthor($pdo, $row)
  {
    $userId = $row['user_id'];
    $user = $pdo->prepare("SELECT `login` FROM `task` join `user` ON `user`.id = `task`.user_id Where user_id = ?");
    $user->execute([$userId]);
    $author =  $user->fetch();
    return $author;
  }

  //Добавление строки
  function insertRow($pdo, $userId, $newDesc, $date )
  {
    $stmt = $pdo->prepare("INSERT INTO `task` (`user_id`, `description`,`date_added`) VALUES (?, ?, ?)");
    $stmt->execute([$userId, $newDesc, $date] );
    $error_arr = $pdo->errorInfo();
    if ($pdo->errorCode() != 0000)
      echo 'SQL Ошибка';
  }

  //удаление строки
  function delRow($pdo,$delRow)
{
  $stmt = $pdo->prepare("DELETE  FROM task WHERE id  = ?");
  $stmt->execute([$delRow]);
}

  //меняем статус  по ссылке
  function updRow($pdo,$upd)
  {
    $stmt = $pdo->prepare("UPDATE task SET is_done = 1 WHERE id = ?");
    $stmt->execute([$upd]);
  }

  //редактирование текста задания
  function editRow($pdo, $editInput, $idEdit)
  {
    $stmt = $pdo->prepare("UPDATE `task` SET `description`= ? WHERE id = ?");
    $stmt->execute([$editInput, $idEdit]);
  }

  //сортировка
  function sortBy($sortBy)
  {
    switch ($sortBy) {
      case "status":
        $sql = "SELECT task.id, task.user_id, task.assigned_user_id, task.description, task.is_done, task.date_added, user.login, user.password
	FROM `task` join `user` ON `user`.id = `task`.user_id WHERE `user_id` = ? ORDER BY is_done";
        break;
      case "date":
        $sql = " SELECT task.id, task.user_id, task.assigned_user_id, task.description, task.is_done, task.date_added, user.login, user.password FROM `task` join `user` ON `user`.id = `task`.user_id WHERE `user_id` = ? ORDER BY date_added";
        break;
      case "description":
        $sql = "SELECT task.id, task.user_id, task.assigned_user_id, task.description, task.is_done, task.date_added, user.login, user.password FROM `task` join `user` ON `user`.id = `task`.user_id WHERE `user_id` = ? ORDER BY description ";
        break;
      default:
        $sql = "SELECT task.id, task.user_id, task.assigned_user_id, task.description, task.is_done, task.date_added, user.login, user.password FROM `task` join `user` ON `user`.id = `task`.user_id WHERE `user_id` = ?";
    }
    return $sql;
  }

  //передача задания другому пользователю
  function transferRow($pdo,$assignedUser, $idRow)
  {
    $stmt = $pdo->prepare("UPDATE `task` SET `assigned_user_id`= ? WHERE id = ?");
    $stmt->execute([$assignedUser, $idRow]);
  }

  //список дел созданых вошедшим пользователем
  function getMyTask($pdo, $enteredUserID, $sql)
  {

    $myTask = $pdo->prepare($sql);
    $myTask->execute([$enteredUserID]);
    return $myTask;
  }

  //список других дел
  function getOthersTask($pdo, $enteredUserID)
  {
    $otherTask = $pdo->prepare("SELECT task.id, task.user_id, task.assigned_user_id, task.description, task.is_done, task.date_added, user.login, user.password
 FROM `task`
 join `user` ON `user`.id = `task`.user_id WHERE assigned_user_id = ? ");
    $otherTask->execute([$enteredUserID]);
    return $otherTask;
  }


?>