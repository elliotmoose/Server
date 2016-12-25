<?php

require_once(__DIR__ . '/Database.php');




$con = Database :: BeginConnection();

$request = "Bar_Name,Bar_ID,Bar_Rating_Price,Bar_Rating_Ambience,Bar_Rating_Price,Bar_Rating_Food,Bar_Rating_Service,Bar_Rating_Avg";

$table = "bar_info";

$output = Database :: Select($request, $table);

$outputString = json_encode($output);

echo $outputString;

Database :: EndConnection();
