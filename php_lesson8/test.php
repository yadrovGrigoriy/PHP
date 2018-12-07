<?php
  require_once __DIR__ . '/function.php';
  if(!empty($_GET['name'])){
    $filename = $_GET['name'];
    	if(file_get_contents('tests/'.$filename)) {
       $json = file_get_contents('tests/' . $filename);
       $data = json_decode($json, true);
     } else {
    	    http_response_code(404);
    	    echo "Тест не найден";
    	    exit;
	}
  }
?>
<form action="" method="POST">


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

    $a = 0;
    foreach ($test_result as $key => $result) {
      $answer = $data[0][$key]["answer"];
      if ($answer == $result) {
        $a++;
      }
    }
    $userName = $_SESSION['user']['login'];
    echo "<pre>";
    $b = count($data[0]);
    if($a == $b){
      echo "Поздравляем!","<br>";
      echo "Тест пройден", "<br>";
      echo "<img src=\"sertificate.php?username= $userName\">", "<br>";
    } else {
      echo  "Тест не пройден", "<br>";
    }
    echo "правильных ответов:  $a из $b";
  }
?>






