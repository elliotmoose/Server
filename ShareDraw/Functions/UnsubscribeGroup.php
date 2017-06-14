<?php

require_once('./Reusable/Database.php');
require_once('./Reusable/Output.php');
require_once('./Reusable/Files.php');

$group_ID = filter_input(INPUT_POST,"group_ID");
$user_ID = filter_input(INPUT_POST,"user_ID");

if($group_ID == null){Output::Fail("no group given");}
if($user_ID == null){Output::Fail("no user given");}

//step 1: get folder of group
$dir = '../Groups/' . $group_ID;

//step 1b: check if folder exists
if(!is_dir($dir))
{
    Output::Fail("Group doesnt exist!");
}

//step 1c: ensure that it is not group_owner (this method is only for subscriptions)
$infoTxt = Files::ReadJSONFile($dir . '/info.txt');
if($user_ID == $infoTxt["owner_ID"])
{
    Output::Fail("You cannot unsubscribe from your own group; Refresh your page" . $user_ID . $infoTxt["owner_ID"]);
}

//======================================
//step 2:remove from database
//======================================
Database::BeginConnection();

$subsDatabaseOutput = Database::SelectWhereColumn("subscriptions", "user_info", "User_ID", $user_ID);
$subscriptions = json_decode($subsDatabaseOutput[0]["subscriptions"]);


//check database if subscribed -> if subscribed -> remove from database
if(($key=array_search($group_ID, $subscriptions)) !== false)
{
    unset($subscriptions[$key]);
}




//update database with new list
if (!Database::StatementUpdateWhere("user_info", ["subscriptions"], [json_encode($subscriptions)], "s", ["User_ID"], [$user_ID], "s")) {
    Database::EndConnection();
    Output::Fail("failed to update database");
}

Database::EndConnection();


//======================================
//step 3: update userIDs.txt
//======================================
$userIDsArray = Files::ReadJSONFile($dir . '/userIDs.txt');

//step 4: remove your ID from the array
if(($key = array_search($user_ID, $userIDsArray)) !== false)
{
    unset($userIDsArray[$key]);
    
    //overwrite file
    Files::OverrideFile($dir . '/userIDs.txt', json_encode($userIDsArray));
}
else //cant find key in userIDs.txt
{    
    Output::Fail("Youre not subscribed to the group");
}


//======================================
//step 4: remove folders of this user within group
//======================================
$assignmentFolders = scandir('../Groups/' . $group_ID);
foreach($assignmentFolders as $assignmentFolder)
{
    if(is_dir('../Groups/' . $group_ID . '/' . $assignmentFolder . '/' . $user_ID))
    {
        rrmdir('../Groups/' . $group_ID . '/' . $assignmentFolder . '/' . $user_ID);
    }
    
    
}

//edit info.txt of assignments
Output::Success("you have unscubscribed!");



function rrmdir($src)
{
    $dir = opendir($src);
    while(false!== ($file = readdir($dir)))
    {
        if(($file != '.') && ($file != '..'))
        {
            $full = $src . '/' . $file;
            if(is_dir($full))
            {
                rrmdir($full);
            }
            else
            {
                unlink($full);
            }
        }
    }
    
    closedir($dir);
    if(rmdir($src))
    {
        return true;        
    }
    else
    {
        return false;
    }
}