<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('./Reusable/Output.php');
require_once('./Reusable/Files.php');

$owner_ID = filter_input(INPUT_POST, "owner_ID");
$groupID = filter_input(INPUT_POST, "groupID");
$assignmentID = filter_input(INPUT_POST, "assignmentID");
$assignment_name = filter_input(INPUT_POST, "assignment_name");
$description = filter_input(INPUT_POST, "description");
//
//$owner_ID = "20";
//$groupID = "mkpggf";
//$assignmentID = "x47b3n";
//$assignment_name = "test";
//$description = "description";

if($owner_ID == null){Output::Fail("empty ID");}
if($groupID == null){Output::Fail("empty groupID");}
if($assignmentID == null){Output::Fail("empty assignmentID");}
if($assignment_name == null){Output::Fail("empty name");}
if($description == null){Output::Fail("empty description");}

$dir = '../Groups/';
$assignmentDir = $dir . $groupID . '/' . $assignmentID . '/info.txt';

//step 1: read info.txt
 $groupInfoTxtArray = Files::ReadJSONFile($dir . $groupID . '/info.txt');

//step 2: check if is owner
if( $groupInfoTxtArray["owner_ID"] != $owner_ID)
{
    Output::Fail("Owner ID Mismatch");
}

$assignmentInfoTxtArray = Files::ReadJSONFile($assignmentDir);

//step 3: edit info
 $assignmentInfoTxtArray["name"] = rawurldecode($assignment_name);
 $assignmentInfoTxtArray["description"] = rawurldecode($description);

//step 4: write info
if(false !== Files::OverrideFile($assignmentDir, json_encode( $assignmentInfoTxtArray)))
{
    Output::Success("assignment edited");
}
else
{
    Output::Fail("failed to edit group");
}