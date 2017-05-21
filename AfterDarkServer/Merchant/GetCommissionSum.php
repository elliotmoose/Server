<?php

require_once '../Database.php';
require_once '../Output.php';

//step 0: inputs
$barID = filter_input(INPUT_GET, "Bar_ID");
//step 1: get all discounts for this bar
Database::BeginConnection();
        
$discountsArr = Database::StatementSelectWhere("claim_ID,User_ID,User_Name,Discount_Amount,Discount_Deal,CodeGeneratedDate", "claim_log", ["Bar_ID"], [$barID], "s");
$totalCommission = 0;


$nonPercentageDiscounts = array();


foreach($discountsArr as $discount)
{
    $discountDealString = $discount["Discount_Deal"];
    //for percentage type discounts
    if(strpos( $discountDealString, '%') !== false ) {        
        $dealMultiplier = str_replace('%', '', $discountDealString) / 100;
        $commission = $discount["Discount_Amount"] * $dealMultiplier;
        $totalCommission = $totalCommission + $commission;
    }
    else { //for other type discounts
        //set this discount aside
        array_push($nonPercentageDiscounts,$discount);
    }
           
}
    echo "total payable: $" . $totalCommission;
    echo json_encode($nonPercentageDiscounts);
    
Database::EndConnection();


