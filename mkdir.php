<?php

# Nimm require_once, siehe login.inc.php
require("config.inc.php");
require("validate_path.inc.php");

session_start();

# vermeide einfache Kopien von $_*, nimm das Original
$dir_name = $_POST["dir_name"];
$pwd = $_POST["pwd"];

if(validate_dir_path($dir_name))
{
	if(mkdir(ROOT_DIR."/".$_SESSION["uid"].$pwd."/".$dir_name, 0666))
		# Verlass dich nicht auf den HTTP-Referer. Der ist nicht immer vorhanden
		# oder manchmal mit Müll gefüllt. 
		header("Location: ".$_SERVER["HTTP_REFERER"]);
}
else
{
	echo "Could not create directory: ".$dir_name."<br>";
	echo "<a href=\"".$_SERVER["HTTP_REFERER"]."\">back</a>";
}

# schließenden PHP-Tag am Dateiende kann/sollte man weglassen
?>
