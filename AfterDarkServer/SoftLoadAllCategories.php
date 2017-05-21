<?php


require_once(__DIR__ . '/Database.php');

Database::BeginConnection();

$request = "*";

$output = Database::Select($request, "categories");

echo json_encode($output);

Database::EndConnection();
        
        