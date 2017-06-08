<?php

require_once('./Reusable/Output.php');
require_once('./Reusable/Files.php');

$groupID = filter_input(INPUT_POST,"groupID");

if($groupID == null){Output::Fail("empty groupID");}

$dir = '../Groups/';

//step 1: read info.txt
if($infoTxtArray = Files::ReadJSONFile($dir . $groupID . '/info.txt'))
{
    Output::SuccessWithArray($infoTxtArray);
}
else
{
    Output::Fail("failed to read details");
}

