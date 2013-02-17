<?php

require_once 'config.inc.php';
require_once 'utils.inc.php';

session_start();

if (!empty($_SESSION['uid']) and !empty($_GET['filename']))
{
	$fullfilename = full_file_name($_SESSION['uid'], $_GET['filename']);
	if (validate_dir_path($_SESSION['uid'], $fullfilename) && file_exists($fullfilename))
	{
		readfile($fullfilename);
		exit;
	}
}

readfile('error.html');
