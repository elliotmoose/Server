<?php

require_once(__DIR__ . '/Database.php');
require_once(__DIR__ . '/Output.php');

Database::BeginConnection();

$output = Database::Select("Bar_ID,Bar_Name,lastUpdate", "bar_info");

echo json_encode($output);

Database::EndConnection();