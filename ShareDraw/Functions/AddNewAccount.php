<?php

require_once('./Reusable/Output.php');
require_once('./Reusable/Database.php');
//error reporting
error_reporting(0);

$con = Database::BeginConnection();
$final = array();

$displayname = filter_input(INPUT_POST, "displayname");
$username = filter_input(INPUT_POST, "username");
$password = filter_input(INPUT_POST, "password");
$email = filter_input(INPUT_POST, "email");


////test
//$username = "username";
//$password = "pass";
//$email = "email";

$username_ok = false;
$email_ok = false;
if($username == "" || $username == null || $email == "" || $email == null)
{
    Output::Fail("Invalid Entry");
}

//check if username is used
$same_username_count = Database::Count("user_info", "User_Name", $username);

//check if email is used
$same_email_count= Database::Count("user_info", "User_Email", $email);

if ($same_username_count['COUNT(*)']  > 0) {
    Output::Fail("Username Already Exists");
} else {
    $username_ok = true;
}

if ($same_email_count['COUNT(*)']  > 0) {
    Output::Fail("Email Already Exists");
} else {
    $email_ok = true;
}

if ($username_ok && $email_ok) {
       
    $values = [$displayname,$username,password_hash($password,PASSWORD_DEFAULT),$email];
    
    foreach($values as $i)
    {
        if($i == "" || $i == null)
        {
            Output::Fail("empty field:");
        }
    }
    
 
    $columns = ["User_Displayname","User_Name","User_Password","User_Email"];
    $success = Database::StatementInsert("user_info", $columns, $values, "ssss");
    
    if($success)
    {
        $arrayAssoc = Database::SelectWhereColumn("*", "user_info", "User_Name", $username);
        
        $user_details = $arrayAssoc[0];
        
        Output::SuccessWithArray($user_details);
        
    }
    else
    {
         Output::Fail("Fail to create account");
    }

    
}

Database::EndConnection();
