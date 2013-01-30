<?php

require("config.inc.php");

session_start();

//$dir: path of the directory, not the file
function validate_dir_path($dir)
{
	$full_path = ROOT_DIR."/".$_SESSION["uid"].$dir;
	if(!chdir($full_path))
		return FALSE;

	$dest = getcwd();
	$c = substr_count($dest, ROOT_DIR)."<br>";
	if($c > 0)
		return TRUE;

	return FALSE;
}

?>
