<?php 

require_once(__DIR__ . '/Database.php');

$con = Database :: BeginConnection();

$Bar_ID = filter_input(INPUT_GET, 'Bar_ID');
$User_ID = filter_input(INPUT_GET, 'User_ID');
$lowerRangeLimit = filter_input(INPUT_GET, 'LowerRangeLimit');
$count = filter_input(INPUT_GET, 'Count');



$sql = sprintf("SELECT * FROM reviews WHERE Bar_ID = %d LIMIT %d,%d" ,$Bar_ID,$lowerRangeLimit,$count );

$outputArrayAssoc = Database::QueryStringToArrayAssoc($sql);

//get user review
$user_review = Database::StatementSelectWhere('*', 'reviews', ['User_ID','Bar_ID'], [$User_ID,$Bar_ID], 'ss');

echo json_encode($user_review);

//if there is no user review
if(count($user_review) <= 0)
{
    echo json_encode($outputArrayAssoc);
}
else
{

    //if initial one contains review
    if (in_array($user_review, $outputArrayAssoc, false))
    {
        echo json_encode($outputArrayAssoc);
    }
    else
    {
        array_push($outputArrayAssoc, $user_review);
        echo json_encode($outputArrayAssoc);
    }
    

    
}

Database :: EndConnection();

		