<?php

require_once ("../Database.php");
require_once ("../Output.php");

$merchant_ID = filter_input(INPUT_POST, "Merchant_ID");
$merchant_ID = "0";
if($merchant_ID == null)
{
    Output::Fail("no merchant ID");    
}

Database::BeginConnection();
$BarIDResults = Database::StatementSelectWhere("Bar_ID", "merchant_info", ["Merchant_ID"], [$merchant_ID], "s");
$Bar_ID = $BarIDResults[0]["Bar_ID"];
Database::EndConnection();

$uploadFolder = "../Bar_Images/$Bar_ID";

if (!file_exists($uploadFolder)) {
    mkdir($uploadFolder);
}

//remove old version
$files = glob($uploadFolder."/*"); // get all file names
foreach ($files as $file) { // iterate files
    if (is_file($file))
    {
        unlink($file); // delete file
    }
}

Output::Success("Images for bar have been updated");