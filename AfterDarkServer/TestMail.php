<?php

$to = "kyzee1997@gmail.com";
$from = "AfterDarkBars@gmail.com";
$message = "test";
$headers = 'From: AfterDarkBars@gmail.com' . "/r/n" .
	 'MIME-Version: 1.0' . "/r/n" .
'Content-type: text/html; charset=utf-8';

if(mail($to,$from,$message,$headers))
{
	echo "success, mail sent";
}
else
{
	echo "failed";
}
