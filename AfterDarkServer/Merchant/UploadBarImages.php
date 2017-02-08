<?php

require_once ("../Database.php");
require_once ("../Output.php");

$merchant_ID = filter_input(INPUT_POST, "Merchant_ID");
$images = $_FILES;

if($merchant_ID == null)
{
    Output::Fail("no merchant ID");    
}

if($images == null)
{
    Output::Fail("no images");    
}

//MUST GET FROM DATABASE
$Bar_ID = "1";
$uploadFolder = "../Bar_Images/$Bar_ID";

if (!file_exists($uploadFolder)) {
    mkdir($uploadFolder);
}

$successUploadCount = 0;

//remove old version
$files = glob($uploadFolder."/*"); // get all file names
foreach ($files as $file) { // iterate files
    if (is_file($file))
    {
        unlink($file); // delete file
    }
}


foreach ($images as $name => $image) {
    $uploadFile = $uploadFolder . "/" . basename($image["name"]);
    


    if(move_uploaded_file($image["tmp_name"], $uploadFile))
    {
       $successUploadCount += 1;        
    }
}

if($successUploadCount == count($_FILES))
{
    Output::Success("Images uploaded successfully");    
}
else
{
    Output::Fail("Images failed to upload");
    
}




