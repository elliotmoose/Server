<?php

require_once('./Reusable/Database.php');
require_once('./Reusable/Output.php');

$userID = filter_input(INPUT_POST, 'User_ID');
$oldPass = filter_input(INPUT_POST, 'oldPass');
$newPass = filter_input(INPUT_POST, 'newPass');

if($userID == "" || $userID == null || $oldPass == "" || $oldPass == null || $newPass == "" || $newPass == null)
 {
    Output::Fail("Empty parameter given");
    die();
}

Database::BeginConnection();


$columns = array("User_ID");
$values = array($userID);


$result = Database::StatementSelectWhere("User_Password", "user_info", $columns, $values,"s");
$output = $result[0];
$oldPassFromDB = $output['User_Password'];
if($oldPassFromDB == null)
{
    Output::Fail("User Not Found" . $userID);
    die();
}


if (password_verify($oldPass, $oldPassFromDB)) {
    //change pass

    $update_columns = array("User_Password");
    $update_values = array(password_hash($newPass,PASSWORD_DEFAULT));
    $to_set_types = "s";
    
    $condition_columns = $columns;
    $condition_values = $values;
    $condition_types = "s";
    
    $success = Database::StatementUpdateWhere("user_info", $update_columns, $update_values, $to_set_types, $condition_columns, $condition_values, $condition_types);
    if($success)
    {
        Output::Success("success");
    }
    else
    {
        Output::Fail("failed");
    } 
       
}
else
{    
    Output::Fail("Incorrect Password");
}

Database::EndConnection();