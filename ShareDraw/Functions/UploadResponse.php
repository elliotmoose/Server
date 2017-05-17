<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

require_once('./Reusable/Output.php');
require_once('./Reusable/Database.php');
require_once('./Reusable/Files.php');

$user_ID = filter_input(INPUT_POST, "user_ID");
$group_ID = filter_input(INPUT_POST, "group_ID");
$assignment_ID = filter_input(INPUT_POST, "assignment_ID");
$commentInfo = filter_input(INPUT_POST, "commentInfo");

$images = $_FILES;

if($user_ID == null){Output::Fail("no user ID");}
if($group_ID == null){Output::Fail("no group ID");}
if($assignment_ID == null){Output::Fail("no assignment ID");}

$assignmentFolder = "../Groups/$group_ID/$assignment_ID";

if (is_dir($assignmentFolder) === false) {
    Output::Fail("this assignment does not exist: $assignmentFolder");    
}

//if this submission hasnt been initialized
if(is_dir("$assignmentFolder/$user_ID") === false)
{
    //create new folder for submission
    mkdir("$assignmentFolder/$user_ID");
}



////remove old version
//$files = glob($destinationFolder."/*"); // get all file names
//foreach ($files as $file) { // iterate files
//    if (is_file($file))
//    {
//        unlink($file); // delete file
//    }
//}

//save comments into a txt file
$dir = "../Groups/$group_ID/$assignment_ID/$user_ID/comments.txt";
if(!$commentInfoTxt = fopen($dir, 'w+'))
{
    //remove group
    Output::Fail("failed to initialize info txt");
}
else
{
    fwrite($commentInfoTxt, $commentInfo);
    fclose($commentInfoTxt);
}


if($images != null)
 {
    foreach ($images as $name => $image) {
        $destinationFile = "../Groups/$group_ID/$assignment_ID/$user_ID/$user_ID" . "_response.png";

        if (move_uploaded_file($image["tmp_name"], $destinationFile)) {
            Output::Success("Images uploaded successfully");
        } else {
            Output::Fail("failed to upload" . $image["tmp_name"] . 'to' . "$assignment_ID");
        }
    }
    
    Output::Fail("Images failed to upload");

}
else
{
    Output::Success("Comments uploaded successfully");
}


    





