<?php


require_once('./Reusable/Output.php');
require_once('./Reusable/Database.php');
require_once('./Reusable/Files.php');

//premissions test
//echo "testing if can read file (premissions)";
//$dir = '../Groups/catalog.txt';
//echo json_encode(Files::ReadJSONFile($dir));

//password hash test

$hashed = password_hash("Hello", PASSWORD_DEFAULT);

if(password_verify("Hell", $hashed))
{
    echo "true";
}
else
{
    echo "false";
}

