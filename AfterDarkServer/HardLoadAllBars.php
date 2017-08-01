<?php


//this soft load means bar data excluding: 
//images and discounts
require_once(__DIR__ . '/Database.php');

Database::BeginConnection();

$request = "Bar_Name,Bar_ID,Bar_Rating_Price,Bar_Rating_Ambience,Bar_Rating_Price,Bar_Rating_Food,Bar_Rating_Service,Bar_Rating_Avg,Bar_Description,Bar_Location_Latitude,Bar_Location_Longitude,OH_Monday,OH_Tuesday,OH_Wednesday,OH_Thursday,OH_Friday,OH_Saturday,OH_Sunday,Bar_Contact,Booking_Available,Bar_Website,Bar_Address,Bar_Tags,Bar_PriceDeterminant,lastUpdate,Bar_Rating_Count,Exclusive,Enabled";

$output = Database::Select($request, "bar_info");

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
        
        
