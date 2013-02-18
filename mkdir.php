<?php

//<<<<<<< HEAD
//require_once("config.inc.php");
//require_once("validate_path.inc.php");
//=======
require_once 'config.inc.php';
require_once 'utils.inc.php';
//>>>>>>> 7041a632f996f5a3ebb319c95a7f48af0d3e196e

session_start();

# tests if logged in

/*
<<<<<<< HEAD
if(validate_dir_path($dir_name))
{
	$full_path = ROOT_DIR."/".$_SESSION["uid"]."/".$pwd."/".$dir_name;
	mkdir($full_path, 0777);
	header("Location: ".$_SERVER["HTTP_REFERER"]);
	exit;
=======
*/
$new_path = '';
if (!empty($_SESSION['uid']) and !empty($_POST['dir_name']) and !empty($_POST['pwd'])) {
		
	$new_path = trim($_POST["pwd"], '/') . '/' . trim($_POST["dir_name"], '/');
	if(validate_dir_path($_SESSION['uid'], $new_path))
	{
		if(mkdir(ROOT_DIR . '/' . $_SESSION["uid"] . '/' . $new_path, DIR_MODE))
		{
			header('Location: ' . get_current_url() . 'index.php?path=' . rawurlencode($new_path));
			exit;
		}
	}
//>>>>>>> 7041a632f996f5a3ebb319c95a7f48af0d3e196e
}
?>
<html>
<head>
	<title>Web Explorer - Error</title>
</head>
<body>
	<p>Could not create directory: <?=htmlspecialchars($new_path) ?></p>
	<p><a href="index.php">Go to root directory.</a></p>
</body>
</html>
