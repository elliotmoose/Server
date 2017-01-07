<?php 

require_once(__DIR__ . '/Database.php');

$con = Database::BeginConnection();

$BarName = filter_input(INPUT_GET, "Bar_Name");

$sql = sprintf("SELECT Bar_Description,Bar_Location_Latitude,Bar_Location_Longitude,OH_Monday,OH_Tuesday,OH_Wednesday,OH_Thursday,OH_Friday,OH_Saturday,OH_Sunday,Bar_Contact,Booking_Available,Bar_Website,Bar_Address,Bar_Tags,Bar_PriceDeterminant FROM bar_info WHERE Bar_Name = \"%s\"",$BarName);

$output = Database::QueryStringToArrayAssoc($sql);

echo json_encode($output);

Database::EndConnection();		