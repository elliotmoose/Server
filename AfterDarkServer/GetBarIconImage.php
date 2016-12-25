<?php

require_once(__DIR__ . '/Database.php');

$con = Database::BeginConnection();
$bar_name = $_GET['Bar_Name'];



$sql = sprintf("SELECT Bar_Icon FROM bar_info WHERE Bar_Name = \"%s\"",$bar_name);

$output = Database::FirstResultFromQuery($sql);
 
echo $output;

Database::EndConnection();
	