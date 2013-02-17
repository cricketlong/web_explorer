<?php

require_once("login.inc.php");
require_once("db_conn.php");

session_start();

# Hier ist nicht die richtige Stelle für Escaping. Escaping wird für Ausgabewerte benötigt,
# es ist aber ungünstig für das normale Arbeiten mit den Werten. Die zusätzlichen
# Escape-Zeichen stören nur.
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

# schließenden PHP-Tag am Dateiende kann/sollte man weglassen
?>

