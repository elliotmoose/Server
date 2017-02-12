<?php
require_once '../PHPMailer/PHPMailerAutoload.php';
require_once (__DIR__ . '/Output.php');

function SendMail(String $receipient, String $subject, String $body)
{
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

$mail->Subject = $subject;
$mail->Body = $body;

if(!$mail->Send())
{
	return true;
}
else
{
	return false;
}
}
catch(phpmailerException $e)
{
    Output::Fail($e->errorMessage());
    return false;
}
}
