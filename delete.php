<?php

require("config.inc.php");
require("validate_path.inc.php");
require("ls.inc.php");
require("delete.inc.php");

session_start();

$filename = $_GET['filename'];
$dirname = $_GET['dirname'];
$last_url = $_SERVER["HTTP_REFERER"];

if(isset($filename) == TRUE && validate_dir_path(dirname($filename)) == TRUE)
{
	$full_path = ROOT_DIR."/".$_SESSION["uid"].$filename;
	if(file_exists($full_path) == TRUE)
	{
		//if this is a file, remove it
		unlink($full_path);
	}
}

if(isset($dirname) == TRUE && validate_dir_path($dirname) == TRUE)
{
	$full_path = ROOT_DIR."/".$_SESSION["uid"].$dirname;
	if(is_dir($full_path))
	{
		//if this is a directory, remove it recursively
		//echo $full_path."<br>";
		rrmdir($full_path);
	}
}

header("Location: $last_url");

?>
