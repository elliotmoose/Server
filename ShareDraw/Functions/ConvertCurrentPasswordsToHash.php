<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//ConvertCurrentPasswordsToHash

require_once('./Reusable/Output.php');
require_once('./Reusable/Database.php');

Database::BeginConnection();

$users = Database::Select("*", "user_info");

foreach($users as $user)
{    
    $password = $user["User_Password"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if(strlen($password) > 45)
    { 
       echo "password already hashed";
       continue;
    }
    
    

    if(Database::StatementUpdateWhere("user_info", ["User_Password"], [$hashedPassword], "s", ["User_Password"], [$password], "s"))
    {
        echo "success";

    }
    
        
}
