<?php

require_once '../Database.php';
require_once '../Output.php';

Database::BeginConnection();
               
//if any of these are nil means they have not been edited
$Bar_ID = filter_input(INPUT_POST, 'Bar_ID');
$Bar_Owner_ID = filter_input(INPUT_POST, 'Bar_Owner_ID');
$Bar_Owner_Name = filter_input(INPUT_POST, 'Bar_Owner_Name');

$Bar_Name = filter_input(INPUT_GET, 'Bar_Name');
$Bar_Description = filter_input(INPUT_GET, 'Bar_Description');
$Bar_Contact = filter_input(INPUT_GET, 'Bar_Contact');
$Bar_Website = filter_input(INPUT_GET, 'Bar_Website');
$Bar_BookingAvailable = filter_input(INPUT_GET, 'Bar_BookingAvailable');

$Bar_OHMonday = filter_input(INPUT_GET, 'OH_Monday');
$Bar_OHTuesday = filter_input(INPUT_GET, 'OH_Tuesday');
$Bar_OHWednesday = filter_input(INPUT_GET, 'OH_Wednesday');
$Bar_OHThursday = filter_input(INPUT_GET, 'OH_Thursday');
$Bar_OHFriday = filter_input(INPUT_GET, 'OH_Friday');
$Bar_OHSaturday = filter_input(INPUT_GET, 'OH_Saturday');
$Bar_OHSunday = filter_input(INPUT_GET, 'OH_Sunday');


if($Bar_ID == NULL)
{
    Output::Fail("No Bar ID Given");
}

//authenticate
if($Bar_Owner_Name != null && $Bar_Owner_ID != null && $Bar_ID != null)
{
    //get name and password from ID

    $result = Database::StatementSelectWhere("Username,Merchant_ID,Bar_ID", "merchant_info", ["Merchant_ID"], [$Bar_Owner_ID], "s");    
    
    if($result['Username'] == $Bar_Owner_Name && $result['Merchant_ID'] == $Bar_Owner_ID && $result['Bar_ID'] == $Bar_ID)
    {
        $columns = [];
        $values = [];
        //change
        if($Bar_Name != NULL)
        {
            //check if name is taken
            $BarNameUsed = Database::SelectWhereColumn("Bar_ID", "bar_info", "Bar_Name", $Bar_Name);
            foreach($BarNameUsed as $value)
            {
                if($value['Bar_ID'] != $Bar_ID)
                {
                    Output::Fail("Bar Name Taken");
                }
                
            }
            array_push($columns, "Bar_Name");
            array_push($values, $Bar_Name);
        }
    
        if($Bar_Contact != NULL)
        {
            array_push($columns, "Bar_Contact");
            array_push($values, $Bar_Contact);
        }
        
        if($Bar_Website != NULL)
        {
            array_push($columns, "Bar_Website");
            array_push($values, $Bar_Website);
        }
        
        if($Bar_BookingAvailable != NULL)
        {
            array_push($columns, "Booking_Available");
            array_push($values, $Bar_BookingAvailable);
        }
        
        if($Bar_Description != NULL)
        {
            array_push($columns, "Bar_Description");
            array_push($values, $Bar_Description);
        }
        
        if($Bar_OHMonday != NULL)
        {
            array_push($columns, "OH_Monday");
            array_push($values, $Bar_OHMonday);
        }
        if($Bar_OHTuesday != NULL)
        {
            array_push($columns, "OH_Tuesday");
            array_push($values, $Bar_OHTuesday);
        }
        if($Bar_OHWednesday != NULL)
        {
            array_push($columns, "OH_Wednesday");
            array_push($values, $Bar_OHWednesday);
        }
        if($Bar_OHThursday != NULL)
        {
            array_push($columns, "OH_Thursday");
            array_push($values, $Bar_OHThursday);
        }
        if($Bar_OHFriday != NULL)
        {
            array_push($columns, "OH_Friday");
            array_push($values, $Bar_OHFriday);
        }
        if($Bar_OHSaturday != NULL)
        {
            array_push($columns, "OH_Saturday");
            array_push($values, $Bar_OHSaturday);
        }
        if($Bar_OHSunday != NULL)
        {
            array_push($columns, "OH_Sunday");
            array_push($values, $Bar_OHSunday);
        }

        
        //to set types
        $to_set_types = "";
        for($i = 0; $i < count($columns); $i ++)
        {
            $to_set_types = $to_set_types . "s";
        }
        
        $success = Database::StatementUpdateWhere("bar_info", $columns, $values, $to_set_types, ["Bar_ID"], [$Bar_ID], "s");

        if($success)
        {
            Output::Success("Bar Profile Updated!");
        }
        else
        {
            Output::Fail("hmmmm.. an unknown error has occured when trying to update your profile");
        }    
        
    }
    else   
    {
        Output::Fail("invalide authentication" . $Bar_Owner_ID . $Bar_Owner_Name . $Bar_ID);
    }


}
else
{
    Output::Fail("incomplete authentication given");
}

if($Bar_Name != null)
{
    //change bar name
}
Database::EndConnection();

