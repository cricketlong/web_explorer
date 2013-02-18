<?php

<<<<<<< HEAD
require("config.inc.php");
require("validate_path.inc.php");
require("ls.inc.php");
require("delete.inc.php");

session_start();

$filename = $_GET['filename'];
$dirname = $_GET['dirname'];
$last_url = $_SERVER["HTTP_REFERER"];

if(isset($filename) == TRUE && validate_dir_path(dirname($filename)) == TRUE)
{
	$full_path = ROOT_DIR."/".$_SESSION["uid"].$filename;
	if(file_exists($full_path) == TRUE)
	{
		//if this is a file, remove it
		unlink($full_path);
	}
}

if(isset($dirname) == TRUE && validate_dir_path($dirname) == TRUE)
{
	$full_path = ROOT_DIR."/".$_SESSION["uid"].$dirname;
	if(is_dir($full_path))
	{
		//if this is a directory, remove it recursively
		//echo $full_path."<br>";
		rrmdir($full_path);
	}
}

header("Location: $last_url");
exit;

?>
=======
require_once 'config.inc.php';
require_once 'utils.inc.php';

session_start();

# No, no, no. No GET for data changing operations. Greetings from Crawlers.
if (!empty($_SESSION['uid']) and !empty($_GET['filename']))
{
	$fullfilename = full_file_name($_SESSION['uid'], $_GET['filename']);
	if (validate_dir_path($_SESSION['uid'], $fullfilename) && file_exists($fullfilename))
	{
		if (unlink($fullfilename))
		{
			$returnpath = strpos($_GET['filename'], '/') === false ? '/' : dirname($_GET['filename']);
			header('Location: ' . get_current_url() . 'index.php?path=' . rawurlencode($returnpath));
		}
	}
}

readfile('error.html');
>>>>>>> 7041a632f996f5a3ebb319c95a7f48af0d3e196e
