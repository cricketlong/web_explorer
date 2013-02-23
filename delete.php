<?php

require("config.inc.php");
require("delete.inc.php");
require("utils.inc.php");

session_start();

if(empty($_SESSION['uid']))
	exit;
if(isset($_GET['filename']))
{
	$file_name = rawurldecode($_GET['filename']);
	$returnpath = dirname($file_name);
}
if(isset($_GET['dirname']))
{
	$dir_name = rawurldecode($_GET['dirname']);
	$returnpath = dirname($dir_name);
}

$uid = $_SESSION['uid'];

if(isset($file_name) && validate_dir_path($uid, dirname($file_name)))
{
	$full_file_name = ROOT_DIR."/".$_SESSION["uid"].$file_name;
	if(is_file($full_file_name) == TRUE)
	{
		//if this is a file, remove it
		unlink($full_file_name);
	}
}

if(isset($dir_name) && validate_dir_path($uid, $dir_name))
{
	$full_dir_path = ROOT_DIR."/".$_SESSION["uid"].$dir_name;
	echo $full_dir_path;
	if(is_dir($full_dir_path))
	{
		//if this is a directory, remove it recursively
		rrmdir($full_dir_path);
	}
}

header('Location: ' . get_current_url() . 'index.php?path=' . rawurlencode($returnpath));
