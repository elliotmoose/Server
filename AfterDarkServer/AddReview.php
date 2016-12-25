<?php

require_once(__DIR__ . '/Database.php');
require_once(__DIR__ . '/Output.php');

Database::BeginConnection();

$User_ID = filter_input(INPUT_POST, 'User_ID');
$Bar_ID = filter_input(INPUT_POST, 'Bar_ID');
$title = filter_input(INPUT_POST, 'title');
$body = filter_input(INPUT_POST, 'body');
$avg = filter_input(INPUT_POST, 'avg');
$price = filter_input(INPUT_POST, 'price');
$food = filter_input(INPUT_POST, 'food');
$service = filter_input(INPUT_POST, 'service');
$ambience = filter_input(INPUT_POST, 'ambience');

if($Bar_ID == null)
{
    Output::Fail("no bar id");
    
}

//check if database already has a specified review for this bar
$columns = array("User_ID","Bar_ID");
$values = array($User_ID,$Bar_ID);

$reviews_given = Database::StatementCountWhere("reviews", $columns, $values, "ss");

if($reviews_given != 0)
{
    Output::Fail("Review already given");  
    die();
}


$username_result = Database::SelectWhereColumn("User_Name", "user_info", "User_ID", $User_ID);
$username = $username_result[0]['User_Name'];

//if not, add new review
$set_columns = array("User_ID","User_Name","Review_Title","Review_Text","Rating_Avg","Rating_Price","Rating_Ambience","Rating_Food","Rating_Service","Bar_ID");
$set_values = array($User_ID,$username,$title,$body,$avg,$price,$ambience,$food,$service,$Bar_ID);
$to_set_types = "ssssssssss";

$success = Database::StatementInsertWhere("reviews",$set_columns, $set_values, $to_set_types);

if($success)
{
    Output::Success("Review Added!");
}

Database::EndConnection();
