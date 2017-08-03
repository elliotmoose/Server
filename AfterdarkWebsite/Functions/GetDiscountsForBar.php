<?php

require_once('../../AfterDarkServer/Database.php');

Database::BeginConnection();

$barID = filter_input(INPUT_GET,"Bar_ID");
$output = Database::StatementSelectWhere("*", "discounts",["Bar_ID"],[$barID],"s");

echo json_encode($output);

Database::EndConnection();
