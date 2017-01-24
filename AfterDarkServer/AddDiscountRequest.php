<?php
require_once(__DIR__ . '/Database.php');

$con = Database::BeginConnection();


$user_ID = filter_input(INPUT_POST,"User_ID");
$user_name = filter_input(INPUT_POST,"User_Name");
$bar_ID = filter_input(INPUT_POSTINPUT_POST,"Bar_ID");
$amount = filter_input(INPUT_POST,"Amount");
$discount_ID = filter_input(INPUT_POST, "Discount_ID");
$merchant_ID = filter_input(INPUT_POST, "Merchant_ID");
$date = filter_input(INPUT_POST, "Date");

//check if inputs are complete
if($user_ID == null || $user_ID == "" || $user_name == null || $user_name == "" || 
        $bar_ID == null || $bar_ID == "" || $amount == null || $amount == "" || 
        $discount_ID == null || $discount_ID == "" || $merchant_ID == null || $merchant_ID == "" ||
        $date == null || $date == 0 || $date == "")
{
    Output::Fail("Incomplete Input");    
}

//check if merchant ID matches bar ID
$merchantInfoArr = Database::SelectWhereColumn("*", "merchant_info", "Bar_ID", $bar_ID);

if(count($merchantInfoArr) == 0)
{
    Output::Fail("Invalid Merchant Account; Please log in again");    
}

$merchantBarID = $merchantInfoArr[0]["Bar_ID"];

if($merchantBarID != $bar_ID)
{
    Output::Fail("Merchant account invalid");
}

//get info about this discount
$discountInfoArr = Database::SelectWhereColumn("*", "discounts", "discount_ID", $discount_ID);

if(count($discountInfoArr) == 0)
{
   Output::Fail("Discount does not exist");
}

$discountDeal = $discountInfoArr[0]["discount_amount"];
$discountDescription = $discountInfoArr[0]["discount_description"];
$discountBarID = $discountInfoArr[0]["Bar_ID"];

if($discountBarID != $bar_ID)
{
    Output::Fail("This discount is not available at this bar");        
}

//check if discount already claimed by this user this time
$pastClaims = Database::StatementSelectWhere("COUNT(*)", "claim_log", ["CodeGeneratedDate","User_ID","Bar_ID"], [$date,$user_ID,$bar_ID], "sss");

//counts claims with same bar,date and user
if($pastClaims[0]["COUNT(*)"] != 0)
{
    Output::Fail("You have already claimed this");
}
else
{
   // echo $pastClaims[0]["COUNT(*)"];    
}
    

//insert claim into claim_logs
$values = [$user_ID,$user_name,$bar_ID,$amount,$discountDeal,$date,$discountDescription];
$success = Database::Insert("claim_log", "User_ID,User_Name,Bar_ID,Discount_Amount,Discount_Deal,CodeGeneratedDate,Discount_Description", "sssssss", $values);

if($success)
{
    Output::Success("Discount Authentication Success");    
}

Database::EndConnection();
