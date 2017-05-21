<?php

require_once('./Reusable/Output.php');
require_once('./Reusable/Database.php');

Database::BeginConnection();

$userID = filter_input(INPUT_GET, "User_ID");

if($userID == null)
{
    Output::Fail("no user ID provided");    
}

$userInfo = Database::SelectWhereColumn("User_ID,User_Name,User_Email", "user_info", "User_ID", $userID);

if($userInfo != null)
{
    Output::SuccessWithArray($userInfo[0]);
}
else
{
    Output::Fail("no results");
}

Database::EndConnection();
