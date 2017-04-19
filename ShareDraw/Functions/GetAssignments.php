<?php

require_once('./Reusable/Output.php');
require_once('./Reusable/Database.php');
require_once('./Reusable/Files.php');


//objective:
//get assignment names, IDs, descriptions

$groupID = filter_input(INPUT_POST, "group_ID");


$outputArray = [];

$dir = '../Groups/' . $groupID;

$iterator = new DirectoryIterator($dir);

foreach($iterator as $fileInfo)
{
    if($fileInfo->isDir() && !$fileInfo->isDot())
    {
        $fileName = $fileInfo->getFilename();    
        
        $assignmentInfo = Files::ReadJSONFile($dir . '/' . $fileName . '/info.txt');
        
        array_push($outputArray,$assignmentInfo);
    }
    
}

echo json_encode($outputArray);


