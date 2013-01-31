<?php

require("config.inc.php");
require("validate_path.inc.php");

session_start();

$dir_name = $_POST["dir_name"];
$pwd = $_POST["pwd"];

if(validate_dir_path($dir_name))
{
	if(mkdir(ROOT_DIR."/".$_SESSION["uid"].$pwd."/".$dir_name, 0666))
		header("Location: ".$_SERVER["HTTP_REFERER"]);
}
else
{
	echo "Could not create directory: ".$dir_name."<br>";
	echo "<a href=\"".$_SERVER["HTTP_REFERER"]."\">back</a>";
}

?>
