<?php

require_once(__DIR__ . '/Database.php');
require_once(__DIR__ . '/Output.php');

Database::BeginConnection();
        
$userID = filter_input(INPUT_POST, 'User_ID');
$barID = filter_input(INPUT_POST, 'Bar_ID');        

if($userID == "" || $userID == null || $barID == "" || $barID == null)
{
    Output::Fail("UserID or BarID not specified");
}

//step 1: check if user has given review for this bar
$countArr = Database::StatementCountWhere('reviews', ["Bar_ID","User_ID"], [$barID,$userID], "ss");

$count = $countArr['COUNT(*)'];
if($count == 0)
{
    //can give review
    Output::Success("Can give review");
}
else
{
    //cannot give review
    Output::Fail("Cannot give review");
} 

Database::EndConnection();