<?php

require_once(__DIR__ . '/Database.php');

$con = Database::BeginConnection();

$output = Database::Select("*", "discounts");

echo json_encode($output);

Database::EndConnection();
