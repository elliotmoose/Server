<?php
//error_reporting(0);
require_once(__DIR__ . '/Database.php');

$con = Database::BeginConnection();

$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST,'password');

$query = sprintf("SELECT  * FROM user_info WHERE User_Name = \"%s\" ",$username);

if($result = mysqli_query($con,$query))
{
while($row = mysqli_fetch_assoc($result))
{
if($row['User_Password'] == $password)
{
    Output::SuccessWithArray($row);
}
else
{
    Output::fail("Invalid Password");
}
}
}
else
{
    Output::Fail("Invalid ID");
}

Database::EndConnection();