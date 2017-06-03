<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//ConvertCurrentPasswordsToHash

require_once('../Output.php');
require_once('../Database.php');

Database::BeginConnection();

$users = Database::Select("*", "merchant_info");

foreach($users as $user)
{    
    $password = $user["Password"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);    
    
    if(strlen($password) > 45)
    { 
       Output::Fail("already hashed");
    }

    if(Database::StatementUpdateWhere("merchant_info", ["Password"], [$hashedPassword], "s", ["Password"], [$password], "s"))
    {
        echo "success";

    }
    
        
}
