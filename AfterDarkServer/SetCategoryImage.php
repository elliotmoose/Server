
<?php
require_once (__DIR__ . '/Database.php');
require_once (__DIR__ . '/Output.php');

$catname = filter_input(INPUT_POST, "Category_Name");

//step 1 check if cat exists
$con = Database::BeginConnection();
$count = $category = Database::StatementCountWhere('categories', ['Category_Name'], [$catname], "s");
if ($count == 1)
{
    //step 2 if exists -> upload
    $folder = '/Applications/MAMP/htdocs/AfterDarkServer/Category_Images';
    $destinationPath = ($folder . '/' . $catname . '.' . pathinfo($_FILES['imagefield']['name'],PATHINFO_EXTENSION));
    
    if(move_uploaded_file($_FILES['imagefield']['tmp_name'], $destinationPath))
    {
        echo 'file uploaded successfully';
    }
    
    //step 3 -> save path for load
    if(Database::StatementUpdateWhere('categories', ['ImagePath'], [$destinationPath], 's', ['Category_Name'], [$catname], 's'))
    {
        //updated!
        echo 'file path updated successfully';
    }
}
else
{
    die('ERROR: category \'' . $catname . '\' does not exist!!');
}

Database::EndConnection();








