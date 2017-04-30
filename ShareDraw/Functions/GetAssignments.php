<?php

require_once('./Reusable/Output.php');
require_once('./Reusable/Database.php');
require_once('./Reusable/Files.php');


//objective:
//get assignment names, IDs, descriptions

$groupID = filter_input(INPUT_POST, "group_ID");
//$groupID = "S13F";

$outputArray = [];

$dir = '../Groups/' . $groupID;

$iterator = new DirectoryIterator($dir);

foreach($iterator as $fileInfo)
{
    if($fileInfo->isDir() && !$fileInfo->isDot())
    {
        $fileName = $fileInfo->getFilename();    
        
        $assignmentInfo = Files::ReadJSONFile($dir . '/' . $fileName . '/info.txt');
        
        //add in submissions info into assignment info 
        $assignment_ID = $assignmentInfo["assignment_ID"];
        $dir = "../Groups/$groupID/$assignment_ID";
        $assignmentInfo["submissions"] = GetSubmissions($dir);
        $assignmentInfo["responses"] = GetResponses($dir);
      
        array_push($outputArray,$assignmentInfo);
    }
    
}

echo json_encode($outputArray);


function GetSubmissions($dir)
{
    $outputArray = [];
    
    
//    if(false !== ($files = glob($dir . '/*',GLOB_ONLYDIR)))
//    {
//        foreach ($files as $file) {
//            echo $file;
//        }
//    }
    
    $files = scandir($dir);
    foreach ($files as $file) {
           
        if($file === ".." || $file === "."){continue;}
        if(is_file("$dir/$file/$file.jpg"))
        {
            array_push($outputArray,$file);
        }
    }
    
    
//    if($handle = opendir($dir))
//    {
//        while(false !== ($file = readdir($handle)))
//        {
//            $fileExtension = strtolower(substr($file,strrpos($file,'.') + 1));
//
//            
//            if($file != "." && $file != ".." && $fileExtension == 'jpg')                   
//            {
//                $fileName = substr($file, 0, strlen($file) - 4);
//                array_push($outputArray,$fileName);
//            }
//        }
//    }
    
    

    
    return $outputArray;
}

function GetResponses($dir)
{
    
    $outputArray = [];
    
    $files = scandir($dir);
    foreach ($files as $file) {
           
        if($file === ".." || $file === "."){continue;}
        if(is_file("$dir/$file/$file" . '_response.png'))
        {
            array_push($outputArray,$file);
        }
    }
    
    return $outputArray;

}

