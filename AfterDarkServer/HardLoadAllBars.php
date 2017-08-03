<?php


//this soft load means bar data excluding: 
//images and discounts
require_once(__DIR__ . '/Database.php');

Database::BeginConnection();

$output = Database::Select("*", "bar_info");

$finalOut = array();
foreach ($output as $bar) {
    
        
    //check if enabled
    if($bar["Enabled"] === 0)
    {
        continue;
    }
    $bar_ID = $bar["Bar_ID"];
    //add number of images
    $path = (__DIR__ . "/Bar_Images/$bar_ID/");
    $filecount = 0;
    $files = glob($path . "*");

    if ($files) {
        $filecount = count($files);        
    }
    
    $bar['maxImageCount'] = $filecount;
    
    array_push($finalOut,$bar);    
}



echo json_encode($finalOut);

Database::EndConnection();
        
        
