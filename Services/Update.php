<?php
//$op = exec("C:\MAMP\htdocs\GitPull.bat 2>&1");
//$op = exec('C:\MAMP\htdocs\update.sh');

$op = shell_exec('C:\MAMP\htdocs\update.sh');
echo nl2br($op);
//$op = implode("\n", $op);
