<?php

require_once(__DIR__ . '/Output.php');

$Bar_ID = filter_input(INPUT_POST, "Bar_ID");
if($Bar_ID === null)
{
    Output::Fail("no bar ID");    
}

require_once(__DIR__ . '/Database.php');

Database:: BeginConnection();
//add page view
$oldPageViews = Database::SelectWhereColumn("Views", "bar_info","Bar_ID",$Bar_ID);

$newPageViews = $oldPageViews[0]["Views"] + 1;
if(!Database::StatementUpdateWhere("bar_info", ["Views"], [$newPageViews], "s", ["Bar_ID"], ["$Bar_ID"], "s"))
{
    Output::Fail("fail to update view count");
}
else
{
    Output::Success("Bar with ID $Bar_ID has $newPageViews views now!");
}

Database::EndConnection();