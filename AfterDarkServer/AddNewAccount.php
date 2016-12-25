<?php

require_once(__DIR__ . '/Database.php');

//error reporting
error_reporting(0);

$con = Database::BeginConnection();
$final = array();


$username = filter_input(INPUT_POST, "username");
$password = filter_input(INPUT_POST, "password");
$email = filter_input(INPUT_POST, "email");

////test
//$username = "username";
//$password = "pass";
//$email = "email";

$username_ok = false;
$email_ok = false;

if($username == "" || $username == null || $password == "" || $password == null || $email == "" || $email == null)
{
    $final['success'] = "false";
    $final['detail'] = "Invalid Entry";
    die(json_encode($final));
}

//check if username is used
$same_username_count = Database::Count("user_info", "User_Name", $username);

//check if email is used
$same_email_count = Database::Count("user_info", "User_Email", $email);

if ($same_username_count > 0) {
    $final['success'] = "false";
    $final['detail'] .= "Username Already Exists";
    $final['detail'] .= PHP_EOL;
} else {
    $username_ok = true;
}

if ($same_email_count > 0) {
    $final['success'] = "false";
    $final['detail'] .= "Email Already Exists";
} else {
    $email_ok = true;
}

if ($username_ok && $email_ok) {
    $values = array();
    array_push($values, $username);
    array_push($values, $password);
    array_push($values, $email);
    
    $success = Database::Insert("user_info", "User_Name,User_Password,User_Email","sss", $values);
    
    if($success)
    {
        $final['success'] = "true";
        $final['detail'] = "Account Successfully Created"; 
        
        //return user details too
        
        $arrayAssoc = Database::SelectWhereColumn("*", "user_info", "User_Name", $username);
        
        $user_details = $arrayAssoc[0];
        
        $final = array_merge($final,$user_details);
    }

    
}

echo json_encode($final);

Database::EndConnection();
