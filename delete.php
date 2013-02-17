<?php

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