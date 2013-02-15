<?php

require("config.inc.php");
require("ls.inc.php");
require("validate_path.inc.php");

session_start();

$filename = $_GET['filename'];
if($filename[0] != "/")
	$full_path = ROOT_DIR."/".$_SESSION['uid']."/".$filename;
else
	$full_path = ROOT_DIR."/".$_SESSION['uid'].$filename;

if((empty($filename) == FALSE) && (validate_dir_path(get_parent_dir($filename)) == TRUE) && (file_exists($full_path)))
{
	$content = file_get_contents($full_path);
	if($content != FALSE)
		print_r($content);
}
else
{
	header("Location: error.html");
	exit;
}

?>
