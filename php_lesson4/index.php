<?php

$data = file_get_contents('http://api.openweathermap.org/data/2.5/weather?id=1496747&APPID=eb3cb8ebe44afcb9f7d41d766b3ef524');
$nsk = json_decode($data, true);



$city = $nsk['name'];
$description = 'не найдены';
$temp = 'не найдено';
$icon = 'не найдена';
if (!empty($nsk['weather'])) {
	foreach ($nsk['weather'] as $items) {
		if (array_key_exists('description', $items)) {
     	$description = $items['description'];
    		}
    		if (array_key_exists('icon', $items)) {
      	$icon = $items['icon'];
    		}
  	}
}
if (isset($nsk['main']['temp'])) {
	$temp = round($nsk['main']['temp']) -273 ;
}
?>


<table>
    <tr>
	   <td>Город</td>
	   <td><?= $city?></td>
    </tr>
    <tr>
	   <td>Погодные условия </td>
	   <td><?= $description?></td>
	   <td><img src="http://openweathermap.org/img/w/<?= $icon?>.png" alt="weather"></td>
    </tr>
    <tr>
	   <td>Температура</td>
	   <td><?= $temp?>C</td>
    </tr>

</table>
