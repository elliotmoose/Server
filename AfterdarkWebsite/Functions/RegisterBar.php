<?php

require_once("../../AfterDarkServer/Database.php");

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
$exclusive = filter_input(INPUT_POST,"Exclusive");
$locationAddress = filter_input(INPUT_POST,"Bar_Address");
$location_lat = filter_input(INPUT_POST,"Bar_Location_Latitude");
$location_long = filter_input(INPUT_POST,"Bar_Location_Longitude");

if(IsEmpty($barName) || IsEmpty($mon) || IsEmpty($tues) || IsEmpty($wed) || IsEmpty($thurs) || IsEmpty($fri) || IsEmpty($sat) || IsEmpty($sun))
{
	echo "Form not fully filled \n";
	echo "<a href='../RegisterBarForm.php'>try again</a>";
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

$select = Database::SelectWhereColumn("*", "bar_info", "Bar_Name", $barName);

if(isset($select[0]))
{
	die("Bar already exists");
}

$exlusiveTinyInt = 0;
if($exclusive)
{
	$exlusiveTinyInt = 1;
}


$success = Database::StatementInsert("bar_info",["Bar_Name","Bar_Description","Bar_Contact","Bar_Website","OH_Monday","OH_Tuesday","OH_Wednesday","OH_Thursday","OH_Friday","OH_Saturday","OH_Sunday","Exclusive"],[$barName,$description,$contact,$website,$mon,$tues,$wed,$thurs,$fri,$sat,$sun,$exlusiveTinyInt],"sssssssssssi");

if($success)
{
	die("The bar has been added!");
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