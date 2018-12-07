<?php
  session_start();

 // удалась ли авторизация
  function login($login, $password){
    $user = getUser($login);

    if($user && $user['password'] == $password){
      $_SESSION['user'] = $user;
      return true;
    }
    $_SESSION['user'] = ["login" => $login, 'username' =>  $login, "password" => null];
    return false;
  }


//получаем пользователей из фаила
  function getUsers() {
    $data = file_get_contents(__DIR__ . '/data/{login}.json');
    $users = json_decode($data, true);
    if(empty($users)){
      return [];
    }
    return $users;
  }

//получаем пользователя по логину
  function getUser($login){
    $users = getUsers();

    foreach ($users as $user) {
      if ($user['login'] == $login) {
        return $user;
      }
    }
    return null;
  }

  function enteredUser(){
    return $_SESSION['user'];
  }


  function isAuthorized(){
    return !empty($_SESSION['user']) && $_SESSION['user']['password'];
  }



?>