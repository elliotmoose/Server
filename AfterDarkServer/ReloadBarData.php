<?php

require_once (__DIR__.'/Database.php');
require_once (__DIR__.'/Output.php');

Database::BeginConnection();
        
$barID = filter_input(INPUT_GET, "Bar_ID");
$columns = ["Bar_ID"];
$values = [$barID];
$types = "s";

$output = Database::StatementSelectWhere("*", "bar_info", $columns, $values, $types);

if($output != NULL)
{
    Output::SuccessWithArray($output[0]);
}
else
{
    Output::Fail("no bar of ID :" . $barID);
}

Database::EndConnection();


