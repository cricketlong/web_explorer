<?php

require_once("login.inc.php");
require_once("db_conn.php");

session_start();

# this is not the right place to do escaping
# you only need escaping for the output of values 
# but it is obstructive for normal usage, the extra characters are of no use 
$username = htmlspecialchars($_POST["username"]);
$password = htmlspecialchars($_POST["password"]);

if(!empty($username) && !empty($password))
{
	if(login($username, md5($password)))
	{
		if(!empty($_SESSION["uid"]) && !empty($_SESSION["username"]))
			//echo __FILE__;
			header("Location: index.php");
	}
	else
		echo "Wrong username or password!";
}

# omit the closing tag at the end of a file. see config.inc.php
?>

