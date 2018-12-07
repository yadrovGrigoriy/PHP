
<?php
	$continents =[
    'north_america' => [
        'Bison',
        'Canis latrans',
        'Gulo',
        'Mephitis'],

    'south_america' => [
  		 	'Dasyprocta',
	  	 	'Sapajus xanthosternos',
		   	'Sciurus ignitus',
		   	'Octodon degus',
		 ],
    'eurasia' => [
		  	'Elephas maximus',
		  	'Mustela erminea',
		    'Vulpes',
		 	  'Felis manul',
		 	],
     'africa' => [
		  	'Acinonyx jubatus',
		 	  'Suricata',
		 	  'Fossa fossana',
		  	'Galidiinae'
		 	],
     'australia' => [
		  	'Tachyglossidae',
		  	'Setonix brachyurus',
		  	'Macropus rufus',
			]
		];
//    echo '<pre>';
//    print_r ($continents);

foreach ($continents as $continent => $animals){
//     echo "<h3>$continent</h3>";
      foreach ($animals as $animal) {
//            echo $animal, '<br>';
          $position = strpos($animal, ' ');
          if ($position!== false) {
            $first_word[] = substr($animal, 0, $position);
            $second_word[] = substr($animal, $position);
            }
        }
    };

shuffle($first_word);
shuffle($second_word);

echo '<pre>';
print_r ($first_word);
print_r ($second_word);

for($i = 0; $i < count($first_word); $i++){
  echo $first_word[$i].$second_word[$i].'<br>';
}
?>