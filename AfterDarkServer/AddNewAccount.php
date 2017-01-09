<?php

require_once(__DIR__ . '/Database.php');
require_once(__DIR__ . '/Output.php');
//error reporting
error_reporting(0);

$con = Database::BeginConnection();
$final = array();

$firstname = filter_input(INPUT_POST, "firstname");
$lastname = filter_input(INPUT_POST, "lastname");
$username = filter_input(INPUT_POST, "username");
$password = filter_input(INPUT_POST, "password");
$email = filter_input(INPUT_POST, "email");
$contact = filter_input(INPUT_POST, "phone");
$gender = filter_input(INPUT_POST, "gender");
$birthday = filter_input(INPUT_POST, "DOB");


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
       
    $values = [$firstname,$lastname,$username,$password,$email,$contact,$gender,$birthday];
    
    foreach($values as $i)
    {
        if($i == "" || $i == null)
        {
            Output::Fail("empty field:");
        }
    }
    
 

    $success = Database::Insert("user_info", "User_Firstname,User_Lastname,User_Name,User_Password,User_Email,User_Contact,User_Gender,User_Birthday","ssssssss", $values);
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
