<?php
//error_reporting(0);
require_once '../Database.php';
require_once '../Output.php';

$con = Database::BeginConnection();

$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST,'password');

$resultString = "cant connect to database";

$query = sprintf("SELECT  * FROM merchant_info WHERE Username = \"%s\" ",$username);

$output = Database::StatementSelectWhere("*", "merchant_info", ["Username"], [$username], "s");

if($output == null)
{
    Output::Fail("Invalid Username");
}
else
{
    $info = $output[0];

    if (password_verify($password, $info['User_Password'])) {
        Output::SuccessWithArray($info);
    } else {
        Output::Fail("Invalid Password");
    }
    
}

    


Database::EndConnection();