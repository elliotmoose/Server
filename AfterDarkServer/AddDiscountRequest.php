<?php
require_once(__DIR__ . '/Database.php');

$con = Database::BeginConnection();


$user_ID = filter_input(INPUT_POST,"User_ID");
$user_name = filter_input(INPUT_POST,"User_Name");
$bar_ID = filter_input(INPUT_POST,"Bar_ID");
$amount = filter_input(INPUT_POST,"Amount");
$discount_ID = filter_input(INPUT_POST, "Discount_ID");
$date = filter_input(INPUT_POST, "Date");

$passCode = filter_input(INPUT_POST, "Passcode");
//
//$user_ID = "8";
//$user_name = "mooselliot";
//$bar_ID = "1";
//$amount = "100";
//$discount_ID = "0";
//$merchant_ID = "1";
//$date = "1";
//
//
//passcode -> merch ID, merch BarID -> compare merchBarID and inputBarID


//stage 1: use the passcode given to find merchant ID 
if ($passCode == "")
{
    Output::Fail("Please enter passcode");    
}

//stage 1a: get merchant ID
$merchantIDResult = Database::StatementSelectWhere("Merchant_ID,Bar_ID", "merchant_info", ["Passcode"], [$passCode], "s");

$merchant_ID = $merchantIDResult[0]["Merchant_ID"];

if($merchant_ID == null)
{
    Output::Fail("Passcode not recognized");    
}

//stage 2a: check bar ID from databse matches barID from post input        
$merchantBarID = $merchantIDResult[0]["Bar_ID"];

if($Bar_ID != $merchantBarID)
{    
   Output::Fail(" Passcode not recognized");
}
    


//check if inputs are complete
if($user_ID == null || $user_ID == "" || $user_name == null || $user_name == "" || 
        $bar_ID == null || $bar_ID == "" || $amount == null || $amount == "" || 
        $discount_ID == null || $discount_ID == "" || $merchant_ID == null || $merchant_ID == "" ||
        $date == null || $date == 0 || $date == "")
{
    Output::Fail("Incomplete Input");    
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
$columns = ["User_ID","User_Name","Bar_ID","Discount_Amount","Discount_Deal","CodeGeneratedDate","Discount_Description"];
$values = [$user_ID,$user_name,$bar_ID,$amount,$discountDeal,$date,$discountDescription];
$success = Database::StatementInsert("claim_log", $columns, $values, "sssssss");

//give points to user
//get users initial points 
$ptResultArray = Database::StatementSelectWhere("User_LoyaltyPts", "user_info", ["User_ID"], [$user_ID], "s");
$oldLoyaltyPts = $ptResultArray[0]["User_LoyaltyPts"];
$ptsColumns = ["User_LoyaltyPts"];
$newLoyaltyPtsAmount = $amount + $oldLoyaltyPts;
$ptsValues = [$newLoyaltyPtsAmount];
$ptsSuccess = Database::StatementUpdateWhere("user_info", $ptsColumns, $ptsValues, "s", ["User_ID"],[$user_ID], "s");
if($success && $ptsSuccess)
{
    Output::Success("Discount Authenticated!" . "$amount" ." points added!");    
}
else
{
    if($success && !$ptsSuccess)
    {
            Output::Fail("User ID and Name do not match");        
    }
    else
    {
        
            Output::Fail("Could not record this claim");
    }
}

Database::EndConnection();
