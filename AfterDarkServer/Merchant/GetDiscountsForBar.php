<?php

require_once '../Database.php';
require_once '../Output.php';

$bar_ID = filter_input(INPUT_GET, "Bar_ID");

Database::BeginConnection();
        
$output = Database::SelectWhereColumn("*", "discounts", "Bar_ID", $bar_ID);

Output::SuccessWithArray($output);

Database::EndConnection();
