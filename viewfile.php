<?php

# Nimm require_once, siehe login.inc.php
require("config.inc.php");
require("ls.inc.php");
require("validate_path.inc.php");

session_start();

# vermeide einfache Kopien von $_*, nimm das Original
$filename = $_GET['filename'];
if($filename[0] != "/")
	$full_path = ROOT_DIR."/".$_SESSION['uid']."/".$filename;
else
	$full_path = ROOT_DIR."/".$_SESSION['uid'].$filename;

# Nimm lieber ! statt == false, und lass das == true weg
if((empty($filename) == FALSE) && (validate_dir_path(get_parent_dir($filename)) == TRUE) && (file_exists($full_path)))
{
	$content = file_get_contents($full_path);
	if($content != FALSE)
		# print_r()? file_get_contents() gibt einen String zurück, kein Array
		print_r($content);
}
else
	# Der Standard verlangt eine vollständige URL http://...
	header("Location: error.html");

# schließenden PHP-Tag am Dateiende kann/sollte man weglassen
?>
