<?php

require_once '../Database.php';
require_once '../Output.php';

$BarID = filter_input(INPUT_POST, "Bar_ID");
$discountName = filter_input(INPUT_POST, "Discount_Name");
$discountAmount = filter_input(INPUT_POST, "Discount_Amount");
$discountDescription = filter_input(INPUT_POST, "Discount_Description");

Database::BeginConnection();

//$BarID = "1";
//$discountName = "test1";
//$discountAmount = "10%";
//$discountDescription = "test discount";

if($discountName == "" || $discountAmount == "" || $discountDescription == "" || $BarID == "")
{
    Output::Fail("Incomplete input");
}

//check if discount already exists
$exists = Database::StatementCountWhere("discounts", ["discount_name","discount_amount","discount_description","Bar_ID"], [$discountName,$discountAmount,$discountDescription,$BarID], "ssss");
$count = $exists['COUNT(*)'];

if($count != 0)
{
    Output::Fail("Discount already exists");
}

$success = Database::StatementInsert("discounts", ["discount_name","discount_amount","discount_description","Bar_ID"], [$discountName,$discountAmount,$discountDescription,$BarID], "ssss");

if($success)
{    
    $discounts = Database::SelectWhereColumn("*", "discounts", "Bar_ID", $BarID);
    
    Output::SuccessWithArray($discounts);
}
else 
{
    Output::Fail("Could create new discount");   
}
 

Database::EndConnection();