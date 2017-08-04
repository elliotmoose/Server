<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

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
Database::BeginConnection();
$BarIDResults = Database::StatementSelectWhere("Bar_ID", "merchant_info", ["Merchant_ID"], [$merchant_ID], "s");
$Bar_ID = $BarIDResults[0]["Bar_ID"];
Database::EndConnection();

if($Bar_ID == null)
{
    Output::Fail("Merchant ID does not exist: " . $merchant_ID);
}

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
    
    echo $uploadFile;
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
    echo count($_FILES);
    Output::Fail("Images failed to upload");
    
}




