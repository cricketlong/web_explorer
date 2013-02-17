<?php

# use require_once, see login.inc.php
require("config.inc.php");

session_start();

//$dir: path of the directory, not the file
function validate_dir_path($dir)
{
	$full_path = ROOT_DIR."/".$_SESSION["uid"].$dir;

	# Unfortunately there is no php function to resolve all relative path parts (/../)
	# except of realpath(), but realpath() compares the path with the file system too.
	# It is better to write a function that resolves relative path parts
	# and then compare the beginning of the path with the allowed path for the files storage.
	
	# On the other hand it's maybe sufficent to just prevent /./ or /../

	if(preg_match("/\/[.]{1,2}\//", $full_path) == 1)
		return FALSE;
	
	return TRUE;
}

# omit the closing tag at the end of a file. see config.inc.php
?>
