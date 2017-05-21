<?php

require_once ("../Database.php");
require_once ("../Output.php");

$merchant_ID = filter_input(INPUT_POST, "Merchant_ID");
$bar_ID = filter_input(INPUT_POST, "Bar_ID");
$discount_ID = filter_input(INPUT_POST, "Discount_ID");

//$merchant_ID = "1";
//$bar_ID = "1";
//$discount_ID = "18";

if($merchant_ID == null)
{
    Output::Fail("no merchant ID");    
}
if($bar_ID == null)
{
    Output::Fail("no Bar ID");    
}
if($discount_ID == null)
{
    Output::Fail("no discount ID");    
}

Database::BeginConnection();
$BarIDResults = Database::StatementSelectWhere("Bar_ID", "merchant_info", ["Merchant_ID"], [$merchant_ID], "s");
$dbBar_ID = $BarIDResults[0]["Bar_ID"];

//check if bar ID matches
if($bar_ID != $dbBar_ID)
{
    Output::Fail("Bar ID mismatch");    
}

$success = Database::DeleteRowsWhere("discounts", ["Discount_ID","Bar_ID"], [$discount_ID,$bar_ID], "ss");

if($success)
{    
    $output = Database::SelectWhereColumn("*", "discounts", "Bar_ID", $bar_ID);
    Output::SuccessWithArray($output);    
}
else
{
    Output::Fail("Failed to remove discount");    
}

Database::EndConnection();
