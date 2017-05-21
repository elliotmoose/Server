<?php

$parameters = filter_input(INPUT_POST, "parameters");
$url = 'https://maps.googleapis.com/maps/api/distancematrix/json?' . $parameters;
$f = file_get_contents($url);
echo $f;