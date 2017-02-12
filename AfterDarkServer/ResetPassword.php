<?php

require_once(__DIR__ . '/Database.php');
require_once(__DIR__ . '/Output.php');
require_once(__DIR__ . '/Mail.php');

Database::BeginConnection();

$user_email_input = filter_input(INPUT_POST, "User_Email");
$user_name = filter_input(INPUT_POST, "User_Name");
$newPassword = random_str(6);

if($user_name == null || $user_email_input == null)
{ 
    Output::Fail("Incomplete input");
}
//get user info from user name
$userInfoRetrive = Database::SelectWhereColumn("*", "user_info", "User_Name", $user_name);

//check if there is an email for this user
if (count($userInfoRetrive) == 0){Output::Fail("user does not exist");}

//get user email       
$user_email_retrieved = $userInfoRetrive[0]["User_Email"];
    
//check if emails match
if($user_email_retrieved != $user_email_input){Output::Fail("Email does not match");}


//set new password

$UpdateSuccess = Database::StatementUpdateWhere("user_info", ["User_Password"], [$newPassword], "s", ["User_Name"], [$user_name], "s");
if(!$UpdateSuccess){echo "could not update";}

Database::EndConnection();


$to       = $user_email_retrieved;
$subject  = 'AfterDark Password Recovery';
$message  = "Hello! Your account's password has been reset to $newPassword. Please change your password in the settings page";


if(Mail::SendMail($to,$subject,$message))
{
    Output::Success("The Email has been sent!");
}
else
{
    Output::Fail("The email could not send");
}

function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}