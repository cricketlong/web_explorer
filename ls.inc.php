<?php

require_once("validate_path.inc.php");

function ls($root_dir, $dir)
{
	$h_dir = opendir("$root_dir/$dir");
	list_info($root_dir, $dir, $h_dir);
}

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
		else
		{
			echo "<td></td>";
			echo "<td></td>";
			echo "<td><a href=\"delete.php?dirname=";
			if($pwd != "/")
				echo $pwd;
			echo "/$file_name\">delete</a></td>";

		}
		echo "</tr>";
	}

	echo "</table>";
}

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

?>
