<?php

require_once 'config.inc.php';
require_once 'utils.inc.php';

session_start();

# test if logged in

if (!empty($_SESSION['uid']) and !empty($_GET['filename']))
{
	$fullname = full_file_name($_SESSION['uid'], $_GET['filename']);
	if (validate_dir_path($_SESSION['uid'], $fullname) and
			file_exists($fullname))
	{
		header("Content-Type: application/octet-stream");
		header("Content-Length: ".filesize($fullname));
		header("Content-Disposition: attachment; filename=" . basename($_GET['filename']));
		readfile($fullname);
		exit;
	}
}

readfile('error.html');