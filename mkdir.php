<?php

# use require_once, see login.inc.php
require("config.inc.php");
require("validate_path.inc.php");

session_start();

# don't just copy from $_*, use the original
$dir_name = $_POST["dir_name"];
$pwd = $_POST["pwd"];

if(validate_dir_path($dir_name))
{
	if(mkdir(ROOT_DIR."/".$_SESSION["uid"].$pwd."/".$dir_name, 0666))
		# don't rely on HTTP Referer. Sometimes it doesn't exists or is filled with junk
		header("Location: ".$_SERVER["HTTP_REFERER"]);
}
else
{
	echo "Could not create directory: ".$dir_name."<br>";
	echo "<a href=\"".$_SERVER["HTTP_REFERER"]."\">back</a>";
}

# omit the closing tag at the end of a file. see config.inc.php
?>
