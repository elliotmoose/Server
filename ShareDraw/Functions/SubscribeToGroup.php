<?php

require_once('./Reusable/Output.php');

$user_ID = filter_input(INPUT_POST,"user_ID");
$group_ID = filter_input(INPUT_POST,"group_ID");

//$user_ID = "011";
//$group_ID = "S13F";
if($user_ID == null || $group_ID == null)
{
    Output::Fail("no user ID or group ID");
}

$fileName = '../Groups/' . $group_ID . '/info.txt';
if($file = fopen($fileName,'r+'))
{
    $fileContents = json_decode(fread($file, filesize($fileName)));
    echo json_encode($fileContents);
    
    Output::Success("");
}
else
{
    Output::Fail("This group is not initialized");
}
