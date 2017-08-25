<?php

require_once('./Reusable/Output.php');
require_once('./Reusable/Database.php');
require_once('./Reusable/Files.php');



$groupID = filter_input(INPUT_POST, "groupID");

if($groupID == "")
{
    Output::Fail("no group ID given");    
}

Database::BeginConnection();


//find respective folder and userIDs.txt 
    
    $userInfoDir = '../Groups/' . $groupID .'/userIDs.txt';
    $userIDArray = Files::ReadJSONFile($userInfoDir);
    
    $usernames = [];
    //for each ID, get their respective names
    foreach($userIDArray as $singleUserID)
    {
        //get next user info
        $userInfoOutput = Database::SelectWhereColumn("User_Displayname,User_ID", "user_info", "User_ID", $singleUserID);
        
        //pull out current list
        $users = $usernames;
        
        //add to list
        array_push($users,$userInfoOutput[0]);

        //push list back in
        $usernames = $users;
    }
    
    Output::SuccessWithArray($usernames);