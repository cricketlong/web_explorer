<?php

function read_dir($root_dir, $dir) {
	$items = [];
	$pattern = '/' . trim($root_dir, '/') . '/' . trim($dir, '/') . '/*';
	foreach (glob($pattern) as $item) {
		if ($item[0] == '.')
			continue;
		$attr = stat($item);
		$items[] = [
			'name' => $item,
			'mtime' => $attr['mtime'],
			'size' => $attr['size'],
		];
	} 
	return $items;
}

function dir_item($file, $uid, $path)
{
	return '<a href="index.php?path=' . 
		rawurlencode('/' . user_file_name($uid, $file)) .
		'">' .
		htmlspecialchars(user_file_name($uid, $file, $path) . '/') .
		'</a>';
}
