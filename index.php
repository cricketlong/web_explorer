<?php

require_once("config.inc.php");
require_once("ls.inc.php");
require_once("login.inc.php");

//connect to mysql server
require_once("db_conn.php");

session_start();

//echo $_SESSION["username"].":".$_SESSION["uid"]."<br>";
if(empty($_SESSION["username"]) || empty($_SESSION["uid"]))
{
	echo "<div align=center><form action=\"login.php\" method=\"post\">".
		 "<p>Username:&nbsp;<input name=\"username\" value=\"";
		 if(isset($_COOKIE["username"]))
			 echo $_COOKIE["username"];
		 echo "\" />";
	echo "<p>Password:&nbsp;<input type=\"password\" name=\"password\" />".
		 "<p><input type=\"checkbox\" name=\"remember me\" />remember me&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
		 "<input type=\"submit\" value=\"login\" /></form></div>";
	exit;
}

//check cookie, wether this user has been remembered for auto login
if(!empty($_COOKIE["username"]) && !empty($_COOKIE["password"]))
{
	//echo "auto login<br>";
	login($_COOKIE["username"], $_COOKIE["password"]);
}

$path = $_GET["path"];

//if path is invalid, go to root directory of this user
if(empty($path))
	$path = "/";

ls(ROOT_DIR."/".$_SESSION["uid"], $path);

?>
