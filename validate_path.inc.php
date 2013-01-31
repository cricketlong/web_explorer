<?php

require("config.inc.php");

session_start();

//$dir: path of the directory, not the file
function validate_dir_path($dir)
{
	$full_path = ROOT_DIR."/".$_SESSION["uid"].$dir;

	if(preg_match("/\/[.]{1,2}\//", $full_path) == 1)
		return FALSE;
	
	return TRUE;
}

?>
