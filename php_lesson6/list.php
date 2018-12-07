<?php


$list=scandir('tests/');
for ($i = 2; $i < count($list); $i++) : ?>

    <a href="test.php?name=<?php echo $list[$i]; ?>">
	   <?php echo $i - 1, " $list[$i]";?></a> <br><br>


<?php endfor ?>

