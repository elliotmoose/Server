<?php
//error_reporting(0);
require_once '../Database.php';
require_once '../Output.php';

$con = Database::BeginConnection();

$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST,'password');

$resultString = "cant connect to database";

$query = sprintf("SELECT  * FROM merchant_info WHERE Username = \"%s\" ",$username);

$resultString = "Invalid ID";
if($result = mysqli_query($con,$query))
{
while($row = mysqli_fetch_assoc($result))
{
if($row['Password'] == $password)
{
    Output::SuccessWithArray($row);
}
else
{       
    Output::Fail("Invalid Password");
}
}
}
else
{
    Output::Fail("Invalid ID");
}


Database::EndConnection();