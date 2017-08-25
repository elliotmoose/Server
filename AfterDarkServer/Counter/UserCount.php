<?php

require_once(__DIR__ . "/../Database.php");
require_once(__DIR__ . "/../Output.php");

Database::BeginConnection();

$output = Database::Select("*","user_info");

$singaporeUsers = array();
$maxSingaporeUsers = array();
foreach($output as $user)
{    
    $phoneNumber = $user["User_Contact"];        
    $firstNumber = substr($phoneNumber,0,1);    
    if($firstNumber == "8" || $firstNumber == "9")
    {
        array_push($singaporeUsers,$user);
    }
    else
    {
        if($phoneNumber == "NIL" || $phoneNumber == "")
        {
            array_push($maxSingaporeUsers,$user);
        }
    }
    
}

$count = count($output);
$sgCount = count($singaporeUsers);
$maxSgCount = count($maxSingaporeUsers) + $sgCount;
$date = date('d-m-Y H:i:s');

$stamp = array();
$stamp["date"] = $date;
$stamp["count"] = $count;
$stamp["SGCount"] = $sgCount . "-" . $maxSgCount;

$file = fopen('count.txt','r');
$stamps = json_decode(stream_get_contents($file));


array_push($stamps,$stamp);

foreach($stamps as $eachStamp)
{
    $eachStamp = (array)$eachStamp;
    $thisDate = $eachStamp["date"];
    $thisCount = $eachStamp["count"];
    $thisSGCount = $eachStamp["SGCount"];
    echo "Date: " . $thisDate . " Users: " . $thisCount . " Est. SG Users: " . $thisSGCount . '<br>';
}

file_put_contents('count.txt',json_encode($stamps));
?>
<html>
    <body>
        <form action="ClearCount.php">
            <input type="submit" value="Clear All">
        </form>        
    </body>
</html>

