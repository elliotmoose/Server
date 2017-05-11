<?php

require_once('./Reusable/Output.php');
require_once('./Reusable/Database.php');
require_once('./Reusable/Files.php');


$user_ID = filter_input(INPUT_POST, "user_ID");
$group_ID = filter_input(INPUT_POST, "group_ID");

if ($user_ID == null || $group_ID == null) {
    Output::Fail("no user ID or group ID");
}

Database::BeginConnection();

$fileName = '../Groups/' . $group_ID . '/userIDs.txt';

$userIDsArray = Files::ReadJSONFile($fileName);
foreach ($userIDsArray as $userSubbedID) {
    if ($userSubbedID == $user_ID) {
        Database::EndConnection();
        Output::Fail("You have already subscribed to this group!!");
    }
}

array_push($userIDsArray, $user_ID);
Files::OverrideFile($fileName, json_encode($userIDsArray));

//step 2: fill in database subscription
//step 2a: first get subscriptions
$databaseSubscriptionOutput = Database::SelectWhereColumn("subscriptions", "user_info", "user_ID", $user_ID);

$subscriptions = json_decode($databaseSubscriptionOutput[0]["subscriptions"]);

//step 2b: check if subscription already exists
foreach ($subscriptions as $subscription) {
    if ($subscription == $group_ID) {
        Database::EndConnection();
        Output::Fail("You have already subscribed to this group!!");
    }
}
//step 2c: update subscriptions
array_push($subscriptions, $group_ID);

if (!Database::StatementUpdateWhere("user_info", ["subscriptions"], [json_encode($subscriptions)], "s", ["user_ID"], [$user_ID], "s")) {
    
    Database::EndConnection();
    Output::Fail("failed to update database");
}
else
{
    Database::EndConnection();
    Output::Success("Subscribed!");
}


