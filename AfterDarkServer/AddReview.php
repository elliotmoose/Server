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

//$User_ID = "2";
//$Bar_ID = "0";
//$avg = "3";
//$price = "2";
//$food = "4";
//$service = "3";
//$ambience = "3";

if($Bar_ID == null)
{
    Output::Fail("no bar id");
    
}

//check if database already has a specified review for this bar
$columns = array("User_ID","Bar_ID");
$values = array($User_ID,$Bar_ID);

$reviews_given = Database::StatementCountWhere("reviews", $columns, $values, "ss");

if($reviews_given['COUNT(*)'] != 0)
{
    Output::Fail("Review already given" . json_encode($reviews_given));  
    die();
}


$username_result = Database::SelectWhereColumn("User_Name", "user_info", "User_ID", $User_ID);
$username = $username_result[0]['User_Name'];

//if not, add new review
$set_columns = array("User_ID","User_Name","Review_Title","Review_Text","Rating_Avg","Rating_Price","Rating_Ambience","Rating_Food","Rating_Service","Bar_ID");
$set_values = array($User_ID,$username,$title,$body,$avg,$price,$ambience,$food,$service,$Bar_ID);
$to_set_types = "ssssssssss";

$success = Database::StatementInsert("reviews",$set_columns, $set_values, $to_set_types);

//also, update bar's average review
//step 1: Get bar's reviews
$barReviews = Database::SelectWhereColumn("Bar_Rating_Avg,Bar_Rating_Food,Bar_Rating_Price,Bar_Rating_Ambience,Bar_Rating_Service,Bar_Rating_Count", "bar_info", "Bar_ID", $Bar_ID);
//step 2: Get number of bar reviews given

//step 3: take current average * number + new review / total number
$barAvg = $barReviews[0]['Bar_Rating_Avg'];
$barPrice = $barReviews[0]['Bar_Rating_Price'];
$barFood = $barReviews[0]['Bar_Rating_Food'];
$barService = $barReviews[0]['Bar_Rating_Service'];
$barAmbience = $barReviews[0]['Bar_Rating_Ambience'];

$totalReviewCount = $barReviews[0]['Bar_Rating_Count'];
$newBarAvg = ($barAvg*$totalReviewCount + $avg)/($totalReviewCount+1);
$newBarPrice = ($barPrice*$totalReviewCount + $price)/($totalReviewCount+1);
$newBarFood = ($barFood*$totalReviewCount + $food)/($totalReviewCount+1);
$newBarService = ($barService*$totalReviewCount + $service)/($totalReviewCount+1);
$newBarAmbience = ($barAmbience*$totalReviewCount + $ambience)/($totalReviewCount+1);

//step 4: update bar's new average
$newCount = $totalReviewCount + 1;
$update_columns = array("Bar_Rating_Avg","Bar_Rating_Food","Bar_Rating_Price","Bar_Rating_Ambience","Bar_Rating_Service","Bar_Rating_Count");
$update_values = array($newBarAvg,$newBarFood,$newBarPrice,$newBarAmbience,$newBarService,$newCount);
$update_types = "ssssss";
$updateSuccess = Database::StatementUpdateWhere("bar_info", $update_columns, $update_values, $update_types,["Bar_ID"], [$Bar_ID], "s");

//if($updateSuccess)
//{
//    echo "avg:".$newBarAvg." food:".$newBarFood." price:".$newBarPrice." ambience:".$newBarAmbience." service:".$newBarService;
//}

if($success && $updateSuccess)
{
    Output::Success("Review Added!");
}
else
{
    Output::Fail("Server fault: Cant add review");
}

Database::EndConnection();
