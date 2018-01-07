<?php

ini_set('session.cookie_secure','0');


if(isset($_POST['login']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];

	if($username == "e" && $password == "e")
	{
		session_start();
		$_SESSION['username'] = $username;

		CheckForLastActivity();

		header("location: Home.php");
	}
	else
	{
		echo "error: invalid username";		
	}
}
else
{
	header("location: Login.html");
}

function CheckForLastActivity()
{
	//last ativity
		if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) 
		{			
    		// last request was more than 30 minutes ago
    		session_unset();     // unset $_SESSION variable for the run-time 
    		session_destroy();   // destroy session data in storage
		}

		$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
}
