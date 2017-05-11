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
    Output::Fail("Group doesnt exist already!");
}

//step 2: read info.txt to see if owner owns it
$infoTxt = Files::ReadJSONFile($dir . '/info.txt');

//step 3: if correct, rmdir
if($infoTxt["owner_ID"] == $user_ID)
{        
    //remove folder
    if(rrmdir($dir))
    {
        Output::Success("Group removed");
    }
    else
    {
        Output::Fail("Could not remove group");
    }
}
else
{
    Output::Fail("You are not the owner of the group");
}





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