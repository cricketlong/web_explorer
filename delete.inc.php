<?php

function is_dir_empty($dirname)
{
	if(readdir($dirname) === FALSE)
		return TRUE;

	return FALSE;
}

function rrmdir($dirname)
{
	$h_dir = opendir($dirname);
	while($item = readdir($h_dir))
	{
		if($item[0] == ".")
			continue;
		//echo $dirname."/".$item."<br>";
		if(is_file($dirname."/".$item))
			unlink($dirname."/".$item);
		if(is_dir($dirname."/".$item))
		{
			if(is_dir_empty($dirname."/".$item))
				rmdir($dirname."/".$item);
			else
				rrmdir($dirname."/".$item);
		}
	}

	rmdir($dirname);
}

?>
