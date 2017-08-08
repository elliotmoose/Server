<?php

require_once(__DIR__ . '/Database.php');
require_once(__DIR__ . '/Output.php');

$con = Database::BeginConnection();

$output = Database::Select("*", "banners");
$finalOutput = Array();
foreach($output as $banner)
{    
    $discountID = $banner["discountID"];
    
    //get respective bar ID
    $barID = Database::SelectWhereColumn("Bar_ID", "discounts", "discount_ID", $discountID);
            
    //set barID
    $banner["Bar_ID"] = $barID[0]["Bar_ID"];            
    
    array_push($finalOutput,$banner);    
}

Output::SuccessWithArray($finalOutput);

Database::EndConnection();
