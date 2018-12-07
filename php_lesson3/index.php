<?php
/**
* Добавление книги
*/
function add()
{
$book = new Book();
$errors = [];
if (count($_POST) > 0) {
$data = [];
if (isset($_POST['name']) && preg_match('/[A-zА-я\s]+/', $_POST['name'])) {
$data['name'] = $_POST['name'];
} else {
$errors['name'] = 'Error name';
}
if (isset($_POST['author']) && preg_match('/[A-zА-я\s]+/', $_POST['author'])) {
$data['author'] = $_POST['author'];
} else {
$errors['author'] = 'Error author';
}
if (isset($_POST['year']) && is_numeric($_POST['year'])) {
$data['year'] = $_POST['year'];
} else {
$errors['year'] = 'Error year';
}
if (isset($_POST['genre']) && preg_match('/[A-zА-я\s]+/', $_POST['author'])) {
$data['genre'] = $_POST['genre'];
} else {
$errors['genre'] = 'Error genre';
}
if (count($errors) == 0) {
$idAdd = $book->add($data);
if ($idAdd) {
header('Location: /');
}
}
}
Di::get()->render('book/add.php');
}