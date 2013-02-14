<?php

require_once("config.inc.php");
require_once("validate_path.inc.php");

session_start();

$dir_name = $_POST["dir_name"];
$pwd = $_POST["pwd"];

if(validate_dir_path($dir_name))
{
	$full_path = ROOT_DIR."/".$_SESSION["uid"]."/".$pwd."/".$dir_name;
	mkdir($full_path, 0777);
	header("Location: ".$_SERVER["HTTP_REFERER"]);
}
else
{
	echo "Could not create directory: ".$dir_name."<br>";
	echo "<a href=\"".$_SERVER["HTTP_REFERER"]."\">back</a>";
}

?>
