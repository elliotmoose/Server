<?php

require_once (__DIR__ . "/Database.php");
require_once (__DIR__ . "/Output.php");

Database::BeginConnection();

$userID = filter_input(INPUT_GET, "User_ID");

if($userID == null)
{
    Output::Fail("no user ID provided");    
}

$userInfo = Database::SelectWhereColumn("User_ID,User_Name,User_Email,User_LoyaltyPts", "user_info", "User_ID", $userID);

Output::SuccessWithArray($userInfo[0]);

Database::EndConnection();
