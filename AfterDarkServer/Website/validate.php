<?php

if(isset($_POST['login']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];

	if($username == "elliot" && $password == "S9728155f")
	{
		session_start();
		$_SESSION['username'] = $username;
		header("location: Home.html");
	}
}
else
{
	header("location: Login.html");
}