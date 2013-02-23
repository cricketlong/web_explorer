<?php

function is_dir_empty($dir_name)
{
	if(readdir($dir_name) === FALSE)
		return TRUE;

	return FALSE;
}

function rrmdir($dir_name)
{
	$h_dir = opendir($dir_name);
	while($item = readdir($h_dir))
	{
		if($item[0] == ".")
			continue;
		//echo $dir_name."/".$item."<br>";
		if(is_file($dir_name."/".$item))
			unlink($dir_name."/".$item);
		if(is_dir($dir_name."/".$item))
		{
			if(is_dir_empty($dir_name."/".$item))
				rmdir($dir_name."/".$item);
			else
				rrmdir($dir_name."/".$item);
		}
	}

	rmdir($dir_name);
}

?>
