<?php
 	$json = file_get_contents(__DIR__.'/ivanov.json');
echo "<pre>";
var_dump($json);

	$data = json_decode($json, true);

echo "<pre>";
var_dump($data);

?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<table>
		<thead>
		  <tr>
		    <td>Имя</td>
		    <td>Фамилиия</td>
		    <td>Адрес</td>
		    <td>Номер телефона</td>
		  </tr>
		</thead>
		<tbody>
		<?php
		echo "<pre>";
		print_r($data);
		?>

		<?php foreach ($data as $iem) { ?>
			<tr>
			    <td><?php echo $item['firstName'] ?></td>
			    <td><?php echo $item['lastName'] ?></td>
			    <td><?php echo $item['address'] ?></td>
			    <td><?php echo $item['phoneNumber'] ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	
</body>
</html>
