<?php

function read_dir($root_dir, $dir) {
	$items = [];
	$pattern = '/' . trim($root_dir, '/') . '/' . trim($dir, '/') . '/*';
	foreach (glob($pattern) as $item) {
		if ($item[0] == '.')
			continue;
/*
<<<<<<< HEAD


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
			echo "/$file_name\" onclick=\"return confirm('Are you sure to recursively delete directory: $file_name?')\">delete</a></td>";

		}
		echo "</tr>";
	}

	echo "</table>";
=======
*/
		$attr = stat($item);
		$items[] = [
			'name' => $item,
			'mtime' => $attr['mtime'],
			'size' => $attr['size'],
		];
	} 
	return $items;
//>>>>>>> 7041a632f996f5a3ebb319c95a7f48af0d3e196e
}

function dir_item($file, $uid, $path)
{
	return '<a href="index.php?path=' . 
		rawurlencode('/' . user_file_name($uid, $file)) .
		'">' .
		htmlspecialchars(user_file_name($uid, $file, $path) . '/') .
		'</a>';
}
