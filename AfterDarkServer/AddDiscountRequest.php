<?php
require_once(__DIR__ . '/Database.php');

$con = Database::BeginConnection();


$user_ID = filter_input(INPUT_GET,"user_ID");
$discount_ID = filter_input(INPUT_GET, "discount_ID");


Database::EndConnection();
