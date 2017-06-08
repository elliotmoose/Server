<?php

require_once('./Reusable/Output.php');
require_once('./Reusable/Database.php');
require_once('./Reusable/Files.php');


$owner_ID = filter_input(INPUT_POST, "owner_ID");
$groupID = filter_input(INPUT_POST, "groupID");
$group_name = filter_input(INPUT_POST, "group_name");
$description = filter_input(INPUT_POST, "description");


if($owner_ID == null){Output::Fail("empty ID");}
if($groupID == null){Output::Fail("empty groupID");}
if($group_name == null){Output::Fail("empty name");}
if($description == null){Output::Fail("empty description");}



$dir = '../Groups/';

//step 1: read info.txt
$infoTxtArray = Files::ReadJSONFile($dir . $groupID . '/info.txt');

//step 2: check if is owner
if($infoTxtArray["owner_ID"] != $owner_ID)
{
    Output::Fail("Owner ID Mismatch");
}

//step 3: edit info
$infoTxtArray["name"] = rawurldecode($group_name);
$infoTxtArray["description"] = rawurldecode($description);

//step 4: write info
if(false !== Files::OverrideFile($dir . $groupID . '/info.txt', json_encode($infoTxtArray)))
{
    Output::Success("group edited");
}
else
{
    Output::Fail("failed to edit group");
}
