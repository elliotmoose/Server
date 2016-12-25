<?php

require_once(__DIR__ . '/Database.php');

$con = Database::BeginConnection();
$bar_ID = filter_input(INPUT_GET, "Bar_ID");

$sql = sprintf("SELECT COUNT(*) FROM images WHERE Bar_ID = %s",$bar_ID);

$output = Database::FirstResultFromQuery($sql);
 
echo $output;


Database::EndConnection();
