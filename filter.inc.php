<?php

require_once 'config.inc.php';

function check_file_ext($filename)
{
	$ext = pathinfo($filename, PATHINFO_EXTENSION);

	//replace '|' with '\|', so that for example 'g|z' will be replaced with 'g\|z'
	$ext = str_replace('|', '\|', $ext);
	//file extension can be in three positions, for example 'gz|' or '|gz|' or '|gz'
	$pattern = '/(^'.$ext.'\||\|'.$ext.'\||\|'.$ext.'$)/';
	if(preg_match($pattern, UPLOAD_FILE_EXT) == 1)
		return true;

	return false;
}

