<?php
$str = '[{"id": 1, "mark": 5}, {"id": 2, "mark": 3}, {"id": 3, "mark": 2}]';

$places = json_decode($str);

foreach ($places as $place) {
	echo 'id=>'.$place->id;
	echo 'mark=>'.$place->mark;
	echo "<br>";
 }
 ?>