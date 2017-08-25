<?php

require_once("../../AfterDarkServer/Database.php");

  if(isset($_POST['registerBarFormSubmit']))
  {

  }
  else
  {
    header("location: ../RegisterBarForm.php");
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
$images = $_FILES["imagesInput"];

if(IsEmpty($barName) || IsEmpty($mon) || IsEmpty($tues) || IsEmpty($wed) || IsEmpty($thurs) || IsEmpty($fri) || IsEmpty($sat) || IsEmpty($sun) || IsEmpty($locationAddress) || IsEmpty($location_lat) || IsEmpty($location_long) || IsEmpty($exclusive) )
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
	echo("Bar already exists");
	die("<a href='../Home.php'>back to bar list</a>");
}

$exlusiveTinyInt = 0;
if($exclusive)
{
	$exlusiveTinyInt = 1;
}

$success = Database::StatementInsert("bar_info",["Bar_Name","Bar_Description","Bar_Contact","Bar_Website","OH_Monday","OH_Tuesday","OH_Wednesday","OH_Thursday","OH_Friday","OH_Saturday","OH_Sunday","Bar_Address","Bar_Location_Latitude","Bar_Location_Longitude","Exclusive","Enabled"],[$barName,$description,$contact,$website,$mon,$tues,$wed,$thurs,$fri,$sat,$sun,$locationAddress,$location_lat,$location_long,$exlusiveTinyInt,1],"ssssssssssssssii");
if(!$success)
{
    echo "failed to register with database";
    echo json_encode($success);
	die("<a href='../Home.php'>back to bar list</a>");
}

//
//
//				UPLOADING OF BAR IMAGESS
//
//
$barIDResult = Database::StatementSelectWhere("Bar_ID", "bar_info",["Bar_Name"],[$barName],"s");
$bar_ID = $barIDResult[0]["Bar_ID"];

if(!isset($bar_ID))
{
    Output::Fail("no bar ID");    
}

if(!isset($images))
{
    echo "no images";
}

$uploadFolder = $_SERVER['DOCUMENT_ROOT'] . "/AfterDarkServer/Bar_Images/$bar_ID";

if (!file_exists($uploadFolder)) {
    mkdir($uploadFolder);
}

$successUploadCount = 0;
$failedUploadCount = 0;

echo "uploading" . " ". count($_FILES) ." " . "images... \n";

//check file types
foreach ($images as $image)
{

    $ext = pathinfo($image["name"], PATHINFO_EXTENSION);
    if (strtolower($ext) != "jpg" && strtolower($ext) != "jpeg")
    {
        Output::Fail("Images Must Be In jpg. Given: " . strtolower($ext));
    }
}

foreach ($images as $image) {

    $uploadFile = $uploadFolder . "/" . JpgImagesCount($uploadFolder) . ".jpg";        

    if(move_uploaded_file($image["tmp_name"], $uploadFile) === true)
    {
       $successUploadCount += 1;        
    }
    else
    {
        $failedUploadCount += 1;
    }
}

$imagesUploadSuccess = false;
if($successUploadCount == count($_FILES) && $failedUploadCount == 0)
{    
  	  $imagesUploadSuccess = true;
}



//
//
//				CHECK IF SUCCESSFULLY REGISTERED BAR
//
//


if($success && $imagesUploadSuccess)
{	

	echo("The bar has been added! ID:" . $bar_ID);

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


function JpgImagesCount($uploadFolder)
{
    //count number of images
    $fileCount = 0;
    $files = glob($uploadFolder."/*"); // get all file names
    foreach ($files as $file) { // iterate files
        if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) == "jpg")
        {
            $fileCount += 1;
        }
    
    }

    return $fileCount;
}

