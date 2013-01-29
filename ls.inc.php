<?php

require_once("validate_path.inc.php");

function ls($root_dir, $dir)
{
	exec("ls -l $root_dir/$dir", $output);

	array_shift($output);
	list_info($dir, $output);
}

function list_info($pwd, $info)
{
	echo "<table>";
	echo "<tr>";
	echo	"<th width=100 align=left>file name</th>
			<th width=120 align=left>modified time</th>
			<th width=50 align=left>size</th>";
	echo "</tr>";

	foreach($info as $line)
	{
		preg_match("/^([^ ]*[ ]+)[^ ]*[ ]+[^ ]*[ ]+[^ ]*[ ]+([^ ]*)[ ]+([^ ]*[ ]+[^ ]*[ ]+[^ ]*)[ ]+([^ ]*)$/", $line, $info_array);
		$permission = array_shift($info_array);
		$file_name = array_pop($info_array);
		$time = array_pop($info_array);
		$size = array_pop($info_array);
		echo "<tr>";
		if($permission[0] == "d")
		{
			if($pwd == "/")
				echo "<td><a href=\"index.php?path=/$file_name\">$file_name</a></td>";
			else
				echo "<td><a href=\"index.php?path=$pwd/$file_name\">$file_name</a></td>";
		}
		else
			echo "<td>$file_name</td>";
		echo "<td>$time</td>";
		echo "<td>$size</td>";
		if($permission[0] == "-")
		{
			if($pwd != "/")
				$full_path = $pwd."/".$file_name;
			else
				$full_path = "/".$file_name;
			echo "<td><a href=\"download.php?filename=$full_path\">download</a></td>";
			echo "<td><a href=\"viewfile.php?filename=$full_path\">view</a></td>";
			echo "<td><a href=\"delete.php?filename=$full_path\">delete</a></td>";
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
