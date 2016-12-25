<?php

require_once(__DIR__ . '/Database.php');

$con = Database::BeginConnection();
$bar_ID = filter_input(INPUT_GET, "Bar_ID");
$bar_image_index = filter_input(INPUT_GET, "Image_Index");

$sql = sprintf("SELECT image_value FROM images WHERE image_index = %d AND Bar_ID = %s",$bar_image_index, $bar_ID);

$output = Database::FirstResultFromQuery($sql);
 
echo $output;

Database::EndConnection();
	