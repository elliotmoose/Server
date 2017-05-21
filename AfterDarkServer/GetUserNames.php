<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once (__DIR__ . "/Database.php");
require_once (__DIR__ . "/Output.php");


Database::BeginConnection();

$users = Database::Select("User_Name", "user_info");

echo json_encode($users);

Database::EndConnection();
        

