<?php
require_once '../PHPMailer/PHPMailerAutoload.php';


$receipient = filter_input(INPUT_GET,'to');

$receipient = "kyzee1997@gmail.com";

$mail = new PHPMailer(true);
try{
$mail -> IsSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = 	'afterdarkbars@gmail.com';
$mail->Password = 'Rahultheman97';
$mail->SMTPSecure = 'tls';
$mail->From = "afterdarkbars@gmail.com";
$mail->FromName = "AfterDark Bars";
$mail->AddAddress($receipient);
$mail->IsHTML(true);

$mail->Subject = 'test email';
$mail->Body = 'this is a test email';

if(!$mail->Send())
{
	echo 'Mail failed to send';
}
else
{
	echo 'success mail sent';
}
}
catch(phpmailerException $e)
{
echo $e->errorMessage();
}
die();
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
