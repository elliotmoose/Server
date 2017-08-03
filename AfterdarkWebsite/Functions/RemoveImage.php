<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

require_once ("../../AfterDarkServer/Database.php");
require_once ("../../AfterDarkServer/Output.php");

$bar_ID = filter_input(INPUT_POST, "Bar_ID");
$imageName = filter_input(INPUT_POST, "Image_Name");

if(!isset($bar_ID))
{
    Output::Fail("no bar ID");    
}

if(!isset($imageName))
{
    Output::Fail("no image name");    
}

$folder = $_SERVER['DOCUMENT_ROOT'] . "/AfterDarkServer/Bar_Images/$bar_ID";
$imageUrl = $folder . '/' . $imageName;

if (!file_exists($imageUrl)) {
    Output::Fail("image does not exist: " . $imageUrl );    
}

//remove file
$removeSuccess = false;
if(unlink($imageUrl))
{
    $removeSuccess = true;
}


//rename files
$index = 0;
$filesToRename = 0;
$filesRenamed = 0;
$files = glob($folder."/*"); // get all file names

foreach ($files as $file) { // iterate files
    if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) == "jpg")
    {        
        $filesToRename = $filesToRename + 1;        
        if(rename($file,$folder . "/" .$index . ".jpg"))
        {
            $filesRenamed = $filesRenamed + 1;
        }
        $index = $index + 1;
    }    
}

if($removeSuccess)
{
    if($filesRenamed == $filesToRename)
    {
        Output::Success("Image removed successfully");
    }
    else
    {
        Output::Fail("Image removed but files not reordered");
    }
}
else
{
    Output::Fail("failed to remove image");
}

