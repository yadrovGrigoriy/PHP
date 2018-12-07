<?php
  require_once  'function.php';


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Список тестов</title>
</head>
<body>

    <p>Добро пожаловать!</p> <?= $_SESSION['user']['login'];?>
    <p>Вы вошли как <?= enteredUser()['username']?> <br>


<?php $list=scandir('tests/');
$link = NULL;
$isAuthorized = isAuthorized();
	for ($i = 2; $i < count($list); $i++)  : ?>
     	<?php $link = $list[$i];?>
          <?php if ($isAuthorized) : ?>
			<a href="test.php?name=<?php echo $link ?>"><?php echo $i - 1, " $link"?></a>
			<a href="list.php?del&name=<?= $link?>">Удалить</a>  <br><br>
		<?php else : ?>
		   <a href="test.php?name=<?php echo $link ?>"><?php echo $i - 1, " $link"?></a> <br><br>
     	<?php endif  ?>
    <?php endfor; ?>


<?php if ($isAuthorized) : ?>
	<a href="admin.php">Загрузить тест</a>
<?php endif;?>


<?php
	if (isset($_GET['del']) and isset($_GET['name'])){
		$filename = $_GET['name'];
		unlink('tests/'.$filename);
	 header('location: list.php');
		}
?>



</body>
</html>
