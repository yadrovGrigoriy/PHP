<?php
  require_once 'vendor/autoload.php';


?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="stylesheet" href="style.css">
</head>

<body>
	<form>
	   <label> <input  placeholder="Адрес" type="text" name="address" value="<?= (!empty($_GET['address']) ) ? $_GET['address'] : ''; ?>">
	   </label> <input style="" type="submit" value="Найти">
	</form>
    <div  id="map" ></div>
	<div class="res-links">

<?php
  $api = new \Yandex\Geo\Api();
  $cordsArr = [];
  $cords = "";
  if (isset ($_GET['address'])) {
    $address = $_GET['address'];
    $api->setQuery($address);
    $api
      ->setLang(\Yandex\Geo\Api::LANG_RU)// локаль ответа
      ->load();

// Список найденных точек
    $response = $api->getResponse();
    $collection = $response->getList();
    foreach ($collection as $item) {
      $address = $item->getAddress();	  // адрес
      $latitude = $item->getLatitude();   // широта
      $longitude = $item->getLongitude(); // долгота
      $cordsArr[]  = $item->getLatitude().", ".$item->getLongitude();// широта + Долгота
      ?>
	   <a href="index.php?latitude=<?= $latitude?>&longitude=<?= $longitude?>">
          <?=$address?> (<?= $latitude?>, <?= $longitude?>)</a><br>
      <?php
      $item->getData(); // необработанные данные
    }
    $cords = $cordsArr[0];
  }
?>
	</div>

	<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript">
	</script>

    <script type="text/javascript">
	   ymaps.ready(init);
	   var myMap,
		  myPlacemark;

	   function init(){
		  myMap = new ymaps.Map("map", {
			 center: [
			   <?php
			   if (isset($_GET['address'])){
				echo $cords;
			   } elseif (isset($_GET['latitude']) && isset($_GET['longitude'])) {
				echo $_GET['latitude'] .",". $_GET['longitude'];
			   } else {
				echo '55.030199, 82.92043';
			   }
			   ?>
			 ],
			 zoom: 7
		  });
		  myPlacemark = new ymaps.Placemark([
		    <?php
		    if (isset($_GET['address'])){
			 echo $cords;
		    } elseif (isset($_GET['latitude']) && isset($_GET['longitude'])) {
			 echo $_GET['latitude'] .",". $_GET['longitude'];
		    } else {
			 echo '';
		    }
		    ?>
		  ], {
		  });
		  myMap.geoObjects.add(myPlacemark);
	   }
	</script>
  </body>

</html>

