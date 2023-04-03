<?php

$EMAIL_ID = 976583868; // 9-digit integer value (i.e., 123456789)

require_once '/home/common/php/dbInterface.php'; // Add database functionality
require_once '/home/common/php/mail.php'; // Add email functionality
require_once '/home/common/php/p4Functions.php'; // Add Project 4 base functions

processPageRequest(); // Call the processPageRequest() function

// DO NOT REMOVE OR MODIFY THE CODE OR PLACE YOUR CODE ABOVE THIS LINE

function authenticateUser($username, $password) 
{
	$userCredit = validateUser($username, $password);
	if($userCredit != null)
	{
		session_start();
		$_SESSION["userId"] = $userCredit[0];
		$_SESSION["displayName"] = $userCredit[1];
		$_SESSION["emailAddress"] = $userCredit[2];
		return true;

	}
	else
	{
		return false;
	}
}

function displayLoginForm($message = "")
{
	require_once  './templates/logon_form.html';
}

function processPageRequest()
{// DO NOT REMOVE OR MODIFY THE CODE OR PLACE YOUR CODE BELOW THIS LINE

	if(session_status() == PHP_SESSION_ACTIVE)
	{
		session_destroy();
	}
	// DO NOT REMOVE OR MODIFY THE CODE OR PLACE YOUR CODE ABOVE THIS LINE
	if(empty($_POST))
	{
		displayLoginForm();
	}

	if(isset($_POST['action']))
	{
		$userName = $_POST['username'];
		$password = $_POST['password'];
		$valueTest = authenticateUser($userName, $password);
		if($valueTest == true){
			header("Location: index.php");
			die();
		}elseif ($valueTest == false)
		{
			$message = "invalid username or password";
			displayLoginForm($message);
		}

	}
}

?>
