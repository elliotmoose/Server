<?php

require_once (__DIR__ . '/Database.php');
require_once (__DIR__ . '/Output.php');

Database::BeginConnection();

$cat_name = filter_input(INPUT_GET, 'Category_Name');

//get path from database
if($output = Database::SelectWhereColumn('*', 'categories', 'Category_Name',$cat_name))
{
    $path = $output[0]['ImagePath'];
    echo "<img src=\"{../Category_Images/Category_Cosy.jpg}\"/ width=200 height=200>";
    echo $path;
}
//show image from path

Database::EndConnection();
        
       
