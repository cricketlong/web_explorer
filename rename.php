<?php

require_once 'config.inc.php';
require_once 'utils.inc.php';

session_start();

if(isset($_POST['old_filename']) && isset($_POST['new_filename']) && isset($_POST['path']) &&
	!empty($_SESSION['uid']) && !empty($_SESSION['username']))
{
	$old_filename = ROOT_DIR.'/'.$_SESSION['uid'].$_POST['path'].$_POST['old_filename'];
	$new_filename = ROOT_DIR.'/'.$_SESSION['uid'].$_POST['path'].$_POST['new_filename'];

	if(file_exists($old_filename))
	{
		rename($old_filename, $new_filename);
	}
}

