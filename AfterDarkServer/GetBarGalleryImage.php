<?php

require_once(__DIR__ . '/Database.php');

$con = Database::BeginConnection();
$bar_ID = filter_input(INPUT_GET, "Bar_ID");
$bar_image_index = filter_input(INPUT_GET, "Image_Index");

$imageSource = "../AfterDarkServer/Bar_Images/$bar_ID/$bar_image_index.jpg";

//redirect to image source

header("Location: ".$imageSource);

Database::EndConnection();
	