<?php
//error_reporting(0);
require_once('./Reusable/Database.php');
require_once('./Reusable/Output.php');

$con = Database::BeginConnection();

$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST,'password');



$output = Database::StatementSelectWhere("*", "user_info", ["User_Name"], [$username], "s");

if($output == null)
{
    Output::Fail("Invalid Username");
}
else
{
    $info = $output[0];

    if ($info['User_Password'] == $password) {
        Output::SuccessWithArray($info);
    } else {
        Output::Fail("Invalid Password");
    }
    
}


Database::EndConnection();