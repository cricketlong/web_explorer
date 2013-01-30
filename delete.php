<?php

require("config.inc.php");
require("validate_path.inc.php");
require("ls.inc.php");

session_start();

$filename = $_GET['filename'];
$last_url = $_SERVER["HTTP_REFERER"];

$full_path = ROOT_DIR."/".$_SESSION["uid"].$filename;

if(validate_dir_path(get_parent_dir($filename)) == TRUE)
{
	if(file_exists($full_path) == TRUE)
	{
		unlink($full_path);
	}
}

header("Location: $last_url");

?>
