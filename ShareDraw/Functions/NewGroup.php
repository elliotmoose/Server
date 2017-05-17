<?php

require_once('./Reusable/Database.php');
require_once('./Reusable/Output.php');
require_once('./Reusable/Files.php');


$owner_ID = filter_input(INPUT_POST, "owner_ID");
$group_name = filter_input(INPUT_POST, "group_name");
$description = filter_input(INPUT_POST, "description");


if($owner_ID == null){Output::Fail("empty ID");}
if($group_name == null){Output::Fail("empty name");}
if($description == null){Output::Fail("empty description");}

//step 1: generate random group ID
$groupID = GenerateRandomAlphanumericString(6);

//step 2: check for conflict
$dir = '../Groups/';
while(file_exists($dir . $groupID))
{
    $groupID = GenerateRandomAlphanumericString(6);
}

//step 3: mkdir
if(!mkdir($dir.$groupID))
{
    Output::Fail("server fault: failed to create group");
}

//step 4: mk info.txt
if(!$infoTxt = fopen($dir . $groupID . '/info.txt', 'w+'))
{
    //remove group
    RemoveGroup($dir.$groupID); 
    Output::Fail("failed to initialize group");
}

//step 4b: initialize info.txt text
Database::BeginConnection();
$databaseOutputArray = Database::SelectWhereColumn("User_Name", "user_info", "User_ID", $owner_ID);
$username = $databaseOutputArray[0]["User_Name"];

fwrite($infoTxt, '{"name":"'. addslashes($group_name) .'","owner_name": "'. addslashes($username).'","description": "'. addslashes($description).'","owner_ID" :"'. $owner_ID.'","group_ID":"' . $groupID . '"}');
fclose($infoTxt);

//step 5: mk userIDs (and add in ownerID)
if(!$userIDsTxt = fopen($dir . $groupID . '/userIDs.txt', 'w+'))
{
    //remove group
    RemoveGroup($dir.$groupID); 
    Output::Fail("failed to initialize group");
}

fwrite($userIDsTxt,'["'. $owner_ID .'"]');
fclose($userIDsTxt);

//step 6: add userID into owners subscribed database
//step 6a: get users subcribed array
$databaseSubscriptionOutput = Database::SelectWhereColumn("subscriptions", "user_info", "User_ID", $owner_ID);
$subscriptions = json_decode($databaseSubscriptionOutput[0]["subscriptions"]);
array_push($subscriptions,$groupID);
//step 6b: update database
if(!Database::StatementUpdateWhere("user_info", ["subscriptions"], [json_encode($subscriptions)], "s", ["User_ID"], [$owner_ID], "s"))
{
    RemoveGroup($dir.$groupID);    
    Output::Fail("failed to update database");    
}

Output::Success("new group created");

function GenerateRandomAlphanumericString(int $length)
{
    $randomPool = "bcdfghjkmnpqrstvwxyz234567890";
    $lastIndex = strlen($randomPool) - 1;

    $output = "";
    for ($i = 0; $i < $length; $i++) {
        $output .= $randomPool[random_int(0, $lastIndex)];
    }

    return $output;
}

function RemoveGroup($dir)
{
    if(!rmdir($dir)){Output::Fail("fatal error: directory removal fail");}
}
  