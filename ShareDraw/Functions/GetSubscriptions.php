<?php

require_once('./Reusable/Output.php');
require_once('./Reusable/Database.php');
require_once('./Reusable/Files.php');


//objective:
//get subscription group IDs, names and owner (should be within info.txt of files)
$userID = filter_input(INPUT_POST, "user_ID");

//$userID = 2;

Database::BeginConnection();
$output = Database::SelectWhereColumn("subscriptions", "user_info", "user_ID", $userID);

//get the subscription IDs
$subscriptionsJSON = $output[0]["subscriptions"];
$subscriptionsArray = json_decode($subscriptionsJSON);


$outputArray = [];

//get group information
foreach($subscriptionsArray as $subscriptionID)
{
    //find respective folder and info.txt 
    $dir = '../Groups/' . $subscriptionID .'/info.txt';
    $fileInfo = Files::ReadJSONFile($dir);
    
    //add in participants info
    $userInfoDir = '../Groups/' . $subscriptionID .'/userIDs.txt';
    $userIDArray = Files::ReadJSONFile($userInfoDir);
    
    $fileInfo["users"] = [];
    //for each ID, get their respective names
    foreach($userIDArray as $singleUserID)
    {
        //get next user info
        $userInfoOutput = Database::SelectWhereColumn("user_name,user_ID", "user_info", "user_ID", $singleUserID);
        
        //pull out current list
        $users = $fileInfo["users"];
        
        //add to list
        array_push($users,$userInfoOutput[0]);

        //push list back in
        $fileInfo["users"] = $users;
    }
    
    
    array_push($outputArray, $fileInfo);        
}

echo json_encode($outputArray);

Database::EndConnection();

