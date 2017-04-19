<?php

require_once('./Reusable/Database.php');
require_once('./Reusable/Output.php');
require_once('./Reusable/Files.php');


$group_ID = filter_input(INPUT_POST, "group_ID");
$assignment_name = filter_input(INPUT_POST, "assignment_name");
$description = filter_input(INPUT_POST, "description");

//$group_ID = "HEEE";
//$assignment_name = "new assignment";
//$description = "this is a new assignment";
if($group_ID == null){Output::Fail("empty ID");}
if($assignment_name == null){Output::Fail("empty name");}
if($description == null){Output::Fail("empty description");}

//step 1: generate random group ID
$assignment_ID = GenerateRandomAlphanumericString(6);

//step 2: check for conflict with catalog -> generate new if conflict
$dir = '../Groups/';

$catalogArray = Files::ReadJSONFile($dir . 'catalog.txt');

while(array_search($assignment_ID, $catalogArray))
{
    $assignment_ID = GenerateRandomAlphanumericString(6);
}

//step 3: mkdir 
if(!mkdir($dir.$group_ID.'/'.$assignment_ID))
{
    Output::Fail("server fault: failed to create assignment");
}


//step 4: mk info.txt
if(!$infoTxt = fopen($dir.$group_ID . '/'. $assignment_ID .'/info.txt', 'w+'))
{
    //remove group
    RemoveAssignment($dir.$groupID .'/'.$assignment_ID); 
    Output::Fail("failed to initialize group");
}

//step 4b: initialize info.txt text
fwrite($infoTxt, '{"name":"'. addslashes($assignment_name) .'","closed": false,"description": "'. addslashes($description).'","assignment_ID" :"'. $assignment_ID.'","group_ID":"' . $group_ID . '"}');
fclose($infoTxt);

//step 5: catalog
$catalogDir = $dir.'catalog.txt';
$catalog = Files::ReadJSONFile($catalogDir);
array_push($catalog,$assignment_ID);
Files::OverrideFile($catalogDir, json_encode($catalog));

Output::Success("new assignment created");

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




function RemoveAssignment($dir)
{
    if(!rmdir($dir)){Output::Fail("fatal error: directory removal fail");}
}
  