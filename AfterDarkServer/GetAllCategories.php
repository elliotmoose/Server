<?php
require_once(__DIR__ . '/Database.php');
require_once(__DIR__ . '/Output.php');
$con = Database::BeginConnection();

$categories = [];

//end in mind : array of dictionaries 'Category_Name' = *name* 'Bar_IDs' = json_encode[Bar_IDs]

//step 1: ask database for all category names
$output = Database::Select('*', 'categories');//outputs array of dictionaries, each element = 1 category

Output::SuccessWithArray($output);

Database::EndConnection();	