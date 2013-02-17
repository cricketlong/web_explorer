<?php

# use require_once, see login.inc.php
require("config.inc.php");
require("ls.inc.php");
require("validate_path.inc.php");

session_start();

# don't just copy from $_*, use the original
$filename = $_GET['filename'];
if($filename[0] != "/")
	$full_path = ROOT_DIR."/".$_SESSION['uid']."/".$filename;
else
	$full_path = ROOT_DIR."/".$_SESSION['uid'].$filename;

# I'd use ! instead of == false, and omit the == true
if((empty($filename) == FALSE) && (validate_dir_path(get_parent_dir($filename)) == TRUE) && (file_exists($full_path)))
{
	$content = file_get_contents($full_path);
	if($content != FALSE)
		# print_r? file_get_contents() return a string, not an array
		print_r($content);
}
else
	# the standard says Location needs a full url http://...
	header("Location: error.html");

# omit the closing tag at the end of a file. see config.inc.php
?>
