<?php

require_once("validate_path.inc.php");

function ls($root_dir, $dir)
{
	# you can use glob() instead of the combination of opendir()/readdir() 
	$h_dir = opendir("$root_dir/$dir");
	list_info($root_dir, $dir, $h_dir);
}

# do you really need ths to be a separate function?
function list_info($root_dir, $pwd, $h_dir)
{
	echo "<table>";
	echo "<tr>";
	echo	"<th align=left>file name</th>
			<th align=left>modified time</th>
			<th align=left>size</th>";
	echo "</tr>";

	while($file_name = readdir($h_dir))
	{
		# using glob() you can use a simple foreach
		# and you can skip the check for both . and ..
		# (but you will still need this test for hidden files)
		//ignore hidden-files and "." and "..", 
		if($file_name[0] == ".")
			continue;

		if($pwd == "/")
			$path = "$root_dir/$file_name";
		else
			$path = "$root_dir/$pwd/$file_name";
		$attr = stat($path);
		$mtime = date("d.m.Y H:i", $attr["mtime"])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		$size = $attr["size"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<tr>";

		//if this item is a directory
		if(is_dir($path))
		{
			# XSS!
			if($pwd == "/")
				echo "<td><a href=\"index.php?path=/$file_name\">$file_name</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
			else
				echo "<td><a href=\"index.php?path=$pwd/$file_name\">$file_name</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
		}
		else
			echo "<td>$file_name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
		echo "<td>$mtime</td>";
		echo "<td>$size</td>";
		if(!is_dir($path))
		{
			echo "<td><a href=\"download.php?filename=";
			if($pwd != "/")
				echo $pwd;
			echo "/$file_name\">download</a></td>";
			echo "<td><a href=\"viewfile.php?filename=";
			if($pwd != "/")
				echo $pwd;
			echo "/$file_name\">view</a></td>";
			echo "<td><a href=\"delete.php?filename=";
			if($pwd != "/")
				echo $pwd;
			echo "/$file_name\">delete</a></td>";
		}
		echo "</tr>";
	}

	echo "</table>";
}

# you can use dirname() instead of this function 
function get_parent_dir($dir)
{
	$p_dir = rtrim($dir, "/");
	$p_dir = preg_split("/[\/]+/", $p_dir);
	array_pop($p_dir);
	$p_dir = implode($p_dir, "/");

	if(empty($p_dir))
		$p_dir = "/";
	return $p_dir;
}

# omit the closing tag at the end of a file. see config.inc.php
?>
