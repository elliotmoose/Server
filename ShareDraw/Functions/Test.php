<?php


require_once('./Reusable/Output.php');
require_once('./Reusable/Database.php');
require_once('./Reusable/Files.php');


$dir = '../Groups/catalog.txt';
echo json_encode(Files::ReadJSONFile($dir));