<?php

require_once('./Reusable/Output.php');
require_once('./Reusable/Files.php');

$user_ID = filter_input(INPUT_POST, "user_ID");
$group_ID = filter_input(INPUT_POST, "group_ID");
$assignment_ID = filter_input(INPUT_POST, "assignment_ID");

$dir = "../Groups/$group_ID/$assignment_ID/$user_ID/comments.txt";

$output = Files::ReadJSONFile($dir);
Output::SuccessWithArray($output);
