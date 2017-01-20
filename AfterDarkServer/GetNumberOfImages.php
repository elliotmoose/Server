<?php

require_once(__DIR__ . '/Database.php');

$bar_ID = filter_input(INPUT_GET, "Bar_ID");

$path = (__DIR__ ."/Bar_Images/$bar_ID/");
$filecount = 0;
$files = glob($path."*");
if($files)
{
    $filecount = count($files);
}
echo $filecount;
