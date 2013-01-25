<?php

require("config.inc.php");

function validate_path($path)
{
	$full_path = ROOT_DIR."/".$path;
	$dest = exec("echo `cd $full_path && pwd`");

	$c = substr_count($dest, ROOT_DIR)."<br>";
	if($c > 0)
		return TRUE;

	return FALSE;
}

?>
