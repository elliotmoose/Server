<?php

require_once('./Database.php');
require_once('./Output.php');
require_once('./Mail.php');

Database::BeginConnection();

$user_email_input = filter_input(INPUT_POST, "User_Email");
$user_name = filter_input(INPUT_POST, "User_Name");
$newPassword = random_str(6);


//$user_name = "mooselliot";
//$user_email_input = "elliot_koh_1997@yahoo.com.sg";
//$2y$10$dRA3aYiI8wOiosatKJnkMOZC7rfRc6Bxp0/ci2RKznRqH.qPPmCWe
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




$to       = $user_email_retrieved;
$subject  = 'AfterDark Password Recovery';
$message  = "Hello! Your account's password has been reset to $newPassword. Please change your password in the settings page";

//future edit:
//update first 
//if fail email, revert update

$mailSent = Mail::SendMail($to,$subject,$message);
if($mailSent)
{
    //if sent the mail then change password
    $newHashedPassword = password_hash($newPassword,PASSWORD_DEFAULT);
    $UpdateSuccess = Database::StatementUpdateWhere("user_info", ["User_Password"], [$newHashedPassword], "s", ["User_Name"], [$user_name], "s");
    if(!$UpdateSuccess){                        
        Output::Fail("could not update");}
    Output::Success("The Email has been sent!");
}
else
{
    Output::Fail("The email could not send");
}

Database::EndConnection();

function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}