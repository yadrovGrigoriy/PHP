<?php
  $connect = mysqli_connect('localhost', 'root', '', 'netology');
  mysqli_set_charset($connect, 'utf8');

	$name = '';
	$author = '';
	$isbn = '';

  $sql = "select * from books";
  if (!empty($_POST)) {
    $name = $_POST['name'];
    $author = $_POST['author'];
    $isbn = $_POST['ISBN'];
    if (!empty($name)) {
      $sql = 'select * from books where name like "%' . $name . '%"';
    }

    if (!empty($author)) {
      if (!empty($name)) {
        $sql = $sql . ' and author like "%' . $author . '%"';
      } else {
        $sql = 'select * from books where author like "%' . $author . '%"';
      }
    }

    if (!empty($isbn)) {
      if (!empty($name) or !empty($author)) {
        $sql = $sql . ' and isbn like "%' . $isbn . '%"';
      } else {
        $sql = 'select * from books where isbn like "%' . $isbn . '%"';
      }
    }
  }
  $res = mysqli_query($connect, $sql);
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

<form action="" method="post">
    <label><input type="text" name="name" placeholder="Название  Книги" value="<?php if(!empty($_POST['name'])){echo $name;}?>"></label>
    <label><input type="text" name="author" placeholder="Автор Книги" value="<?php if(!empty($_POST['author'])){echo $author;}?>"></label>
    <label><input type="text" name="ISBN" placeholder="ISBN" value="<?php if(!empty($_POST['ISBN'])){echo $isbn;}?>" ></label>
    <input type="submit">

</form>

<table>
    <thead>
    <tr>
	   <td>Номер</td>
	   <td class="title">Название</td>
	   <td class="author">Автор</td>
	   <td>Год</td>
	   <td class="isbn">ISBN</td>
	   <td class="genre">Жанр</td>
    </tr>
    </thead>

  <?php
  while ($data = mysqli_fetch_assoc($res)) { ?>
      <tbody>
      <tr>
        <td><?= $data['id']?></td>
        <td><?= $data['name']?></td>
        <td><?= $data['author']?></td>
        <td><?= $data['year']?></td>
        <td><?= $data['isbn']?></td>
        <td><?= $data['genre']?></td>
      </tr>
      </tbody>
  <?php } ?>
</table>

</body>
</html>




