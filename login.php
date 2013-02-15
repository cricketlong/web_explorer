<?php

require_once("login.inc.php");
require_once("db_conn.php");

session_start();

$username = htmlspecialchars($_POST["username"]);
$password = htmlspecialchars($_POST["password"]);

if(!empty($username) && !empty($password))
{
	if(login($username, md5($password)))
	{
		if(!empty($_SESSION["uid"]) && !empty($_SESSION["username"]))
		{
			//echo __FILE__;
			header("Location: index.php");
			exit;
		}
	}
	else
		echo "Wrong username or password!";
}

?>

