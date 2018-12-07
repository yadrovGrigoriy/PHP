<?php
if(!empty($_GET['name'])){
  $filename = $_GET['name'];
  $json = file_get_contents('tests/'.$filename);
  $data = json_decode($json, true);
}
?>

<form action="" method="POST">

    <label>Введите Ваше Имя :<input type="text" name="username"></label>
  <?php foreach ($data[0] as $q_key => $questions) : ?>

		<p>Вопрос: <?= $questions['question']?> </p>
	   <?php

	   foreach ($questions['options']  as $key => $value) : ?>

		  <input type="radio" name="<?=$q_key?>" id="<?= $q_key . $key?>" value="<?= $key?>">
		  <label for="<?= $q_key . $key?>"><?= $value?></label>


	   <?php endforeach ?>
	 <hr>
	 <?php endforeach ?>
    <p><input type="submit" ></p>
</form>

<?php

    if(!empty($_POST)) {
	 $test_result = $_POST;
	 $username = $_POST['username'];
	 array_shift($test_result);
//      echo "<pre>";
//      print_r($test_result);

	 $a = 0;
	 foreach ($test_result as $key => $result) {
	   $answer = $data[0][$key]["answer"];
	   if ($answer == $result) {
		$a++;
	   }
	 }

	 $b = count($data[0]);
	 if($a == $b){
	     echo "Поздравляем!","<br>",  $username, "<br>";
		echo "Тест пройден", "<br>";
	 } else {
		echo  "Тест не пройден", "<br>";
	 }
	 echo "правильных ответов:  $a из $b";
}
?>







