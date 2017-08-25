<?php

require_once("../../AfterDarkServer/Database.php");

$barID = filter_input(INPUT_POST,"Bar_ID");

 if(!isset($_POST['editBarFormSubmit']))
 {
 	if(isset($barID))
 	{
 		header("location: ../EditBarForm.php?Bar_ID=".$barID);
 	}
	else
	{
		header("location: ../Home.php");
	}
 }



Database::BeginConnection();


$barName = filter_input(INPUT_POST,"Bar_Name");
$description = filter_input(INPUT_POST,"Bar_Description");
$contact = filter_input(INPUT_POST,"Bar_Contact");
$website = filter_input(INPUT_POST,"Bar_Website");
$mon = filter_input(INPUT_POST,"OH_Monday");
$tues = filter_input(INPUT_POST,"OH_Tuesday");
$wed = filter_input(INPUT_POST,"OH_Wednesday");
$thurs = filter_input(INPUT_POST,"OH_Thursday");
$fri = filter_input(INPUT_POST,"OH_Friday");
$sat = filter_input(INPUT_POST,"OH_Saturday");
$sun = filter_input(INPUT_POST,"OH_Sunday");
$locationAddress = filter_input(INPUT_POST,"Bar_Address");
$location_lat = filter_input(INPUT_POST,"Bar_Location_Latitude");
$location_long = filter_input(INPUT_POST,"Bar_Location_Longitude");
$exclusive = filter_input(INPUT_POST,"Exclusive");

if(IsEmpty($barName) || IsEmpty($mon) || IsEmpty($tues) || IsEmpty($wed) || IsEmpty($thurs) || IsEmpty($fri) || IsEmpty($sat) || IsEmpty($sun))
{
	echo "Form not fully filled \n";
	echo "<a href='../EditBarForm.php?Bar_ID=".$barID."'>try again</a>";
	die();
}

if($description == null)
{
	$description == "";
}

if($contact == null)
{
	$contact == "";
}

if($website == null)
{
	$website == "";
}

$select = Database::SelectWhereColumn("*", "bar_info", "Bar_ID", $barID);

if(!isset($select[0]))
{
	echo("Bar does not exist");
	die("<a href='../Home.php'>back to bar list</a>");
}

$exlusiveTinyInt = 0;
if($exclusive)
{
	$exlusiveTinyInt = 1;
}

$success = Database::StatementUpdateWhere("bar_info",["Bar_Name","Bar_Description","Bar_Contact","Bar_Website","OH_Monday","OH_Tuesday","OH_Wednesday","OH_Thursday","OH_Friday","OH_Saturday","OH_Sunday","Bar_Address","Bar_Location_Latitude","Bar_Location_Longitude","Exclusive"],[$barName,$description,$contact,$website,$mon,$tues,$wed,$thurs,$fri,$sat,$sun,$locationAddress,$location_lat,$location_long,$exlusiveTinyInt],"ssssssssssssssi",["Bar_ID"],[$barID],"s");

if($success)
{
	echo("The bar has been updated!");

	


	die("<a href='../Home.php'>back to bar list</a>");
}
else
{
	die("Failed");
}

function IsEmpty(String $input)
{
	if($input == "" || $input == null)
	{		
		return true;
	}

	return false;
}