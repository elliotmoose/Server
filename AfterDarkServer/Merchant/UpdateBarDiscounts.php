<?php

require_once '../Database.php';
require_once '../Output.php';

Database::BeginConnection();
        
$Bar_ID = filter_input(INPUT_POST, 'Bar_ID');
$Bar_Owner_ID = filter_input(INPUT_POST, 'Bar_Owner_ID');
$Bar_Owner_Name = filter_input(INPUT_POST, 'Bar_Owner_Name');
$Discount_ID = filter_input(INPUT_POST, 'Discount_ID');

//if any of these are nil means they werent changed
$discount_name = filter_input(INPUT_GET, 'Discount_Name');
$discount_amount = filter_input(INPUT_GET, 'Discount_Amount');
$discount_description = filter_input(INPUT_GET, 'Discount_Description');

if($Discount_ID == null)
{
    Output::Fail("no discount selected");
}
//authenticate
if($Bar_Owner_Name != null && $Bar_Owner_ID != null && $Bar_ID != null)
{
    //get name and password from ID

    $output = Database::StatementSelectWhere("Username,Merchant_ID,Bar_ID", "merchant_info", ["Merchant_ID"], [$Bar_Owner_ID], "s");    
    $result = $output[0];
    if($result['Username'] == $Bar_Owner_Name && $result['Merchant_ID'] == $Bar_Owner_ID && $result['Bar_ID'] == $Bar_ID)
    {
        //check if discount exists        
        $discountExists = Database::StatementSelectWhere("*", "discounts", ["discount_ID","Bar_ID"], [$Discount_ID,$Bar_ID], "ss");
        
        if(count($discountExists) < 1)
        {
            
            $discounts = Database::SelectWhereColumn("*", "discounts", "Bar_ID", $Bar_ID);

            Output::FailWithArray($discounts);
        }
        
        $columns = [];
        $values = [];
        
        //change discount_name discount_descripton discount_amount
        if($discount_name != null)
        {
            array_push($columns, "Discount_Name");
            array_push($values,$discount_name);
        }
        
        if($discount_description != null)
        {
            array_push($columns, "discount_description");
            array_push($values,$discount_description);
        }
        
        if($discount_amount != null)
        {
            array_push($columns, "discount_amount");
            array_push($values,$discount_amount);
        }
        //to set types
        $to_set_types = "";
        for($i = 0; $i < count($columns); $i ++)
        {
            $to_set_types = $to_set_types . "s";
        }
        
        $success = Database::StatementUpdateWhere("discounts", $columns, $values, $to_set_types, ["Bar_ID","discount_ID"], [$Bar_ID,$Discount_ID], "ss");

        if($success)
        {
            $discounts = Database::SelectWhereColumn("*", "discounts", "Bar_ID", $Bar_ID);
            Output::SuccessWithArray($discounts);
        }
        else
        {
            Output::Fail("hmmmm.. an unknown error has occured when trying to update your profile");
        }    
        
    }
    else   
    {
        Output::Fail("invalide authentication" . $Bar_Owner_ID . $Bar_Owner_Name . $Bar_ID . $result['Username'] . $result['Bar_ID'] . $result['Merchant_ID']);
    }


}
else
{
    Output::Fail("null name,id or bar id given");
    
}

Database::EndConnection();