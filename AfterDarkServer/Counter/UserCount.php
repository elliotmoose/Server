<?php

require_once(__DIR__ . "/../Database.php");
require_once(__DIR__ . "/../Output.php");

Database::BeginConnection();

$output = Database::Select("*","user_info");

$count = count($output);
$date = date('d-m-Y H:i:s');

$stamp = array();
$stamp["date"] = $date;
$stamp["count"] = $count;

$file = fopen('count.txt','r');
$stamps = json_decode(stream_get_contents($file));

array_push($stamps,$stamp);

foreach($stamps as $eachStamp)
{
    $eachStamp = (array)$eachStamp;
    $thisDate = $eachStamp["date"];
    $thisCount = $eachStamp["count"];
    echo "Date: " . $thisDate . " Count: " . $thisCount . '<br>';
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

