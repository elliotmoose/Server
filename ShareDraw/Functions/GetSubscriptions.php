<?php

require_once('./Reusable/Output.php');
require_once('./Reusable/Database.php');
require_once('./Reusable/Files.php');


//objective:
//get subscription group IDs, names and owner (should be within info.txt of files)
$userID = filter_input(INPUT_POST, "User_ID");

if($userID == null){Output::Fail("no ID");}
Database::BeginConnection();
$output = Database::SelectWhereColumn("subscriptions", "user_info", "User_ID", $userID);

//get the subscription IDs
$subscriptionsJSON = $output[0]["subscriptions"];
$subscriptionsArray = json_decode($subscriptionsJSON);


$outputArray = [];

//get group information
foreach($subscriptionsArray as $subscriptionID)
{

    //check if subscription ID exists
    if(!is_dir('../Groups/' . $subscriptionID))
    {
        //remove this subscription ID from database
        
        //step 1: get IDs        
        $subIDsOutput = Database::SelectWhereColumn("subscriptions", "user_info", "User_ID", $userID);

        //step 2: remove from array
        $subIDsArray = json_decode($subIDsOutput[0]["subscriptions"],true);
        
        $key = array_search($subscriptionID, $subIDsArray);        
        if($key!==false){            
            unset($subIDsArray[$key]);
        }
        
        $subIDsArray = array_values($subIDsArray);

        //step 3: update database with new list
        
        if (!Database::StatementUpdateWhere("user_info", ["subscriptions"], [json_encode($subIDsArray)], "s", ["User_ID"], [$userID], "s")) {            
            Database::EndConnection();
            Output::Fail("failed to update database");
        }


        //skip this iteration
        continue;
    }
    
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
        $userInfoOutput = Database::SelectWhereColumn("User_Displayname,User_ID", "user_info", "User_ID", $singleUserID);
        
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

