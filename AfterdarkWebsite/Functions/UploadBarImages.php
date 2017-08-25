<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

require_once ("../../AfterDarkServer/Database.php");
require_once ("../../AfterDarkServer/Output.php");

$bar_ID = filter_input(INPUT_POST, "Bar_ID");
$images = $_FILES;

if(!isset($bar_ID))
{
    Output::Fail("no bar ID");    
}

if(!isset($images))
{
    Output::Fail("no images");    
}

$uploadFolder = $_SERVER['DOCUMENT_ROOT'] . "/AfterDarkServer/Bar_Images/$bar_ID";

if (!file_exists($uploadFolder)) {
    mkdir($uploadFolder);
}

$successUploadCount = 0;
$failedUploadCount = 0;


//check file types
foreach ($images as $image)
{

    $ext = pathinfo($image["name"], PATHINFO_EXTENSION);
    if (strtolower($ext) != "jpg" && strtolower($ext) != "jpeg")
    {
        Output::Fail("Images Must Be In jpg. Given: " . strtolower($ext));
    }
}

foreach ($images as $image) {

    $uploadFile = $uploadFolder . "/" . JpgImagesCount($uploadFolder) . ".jpg";    

    if(move_uploaded_file($image["tmp_name"], $uploadFile) === true)
    {
       $successUploadCount += 1;        
    }
    else
    {
        $failedUploadCount += 1;
    }
}

if($successUploadCount == count($_FILES) && $failedUploadCount == 0)
{    
    //Output::Success("Images uploaded successfully: " . count($_FILES) + json_encode($_FILES));
    Output::Success("Images uploaded successfully: " . count($_FILES));
    //Output::Success($successUploadCount . " images uploaded successfully " . $failedUploadCount . " images failed to upload.");    
}
else
{
    Output::Fail($successUploadCount . " images uploaded successfully " . $failedUploadCount . " images failed to upload");            
}


function JpgImagesCount($uploadFolder)
{
    //count number of images
    $fileCount = 0;
    $files = glob($uploadFolder."/*"); // get all file names
    foreach ($files as $file) { // iterate files
        if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) == "jpg")
        {
            $fileCount += 1;
        }
    
    }

    return $fileCount;
}

