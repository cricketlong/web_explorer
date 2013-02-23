<?php

require_once 'config.inc.php';
require_once 'utils.inc.php';

session_start();

$new_path = '';
if (!empty($_SESSION['uid']) and !empty($_POST['dir_name']) and !empty($_POST['pwd'])) {
		
	$new_path = trim($_POST["pwd"], '/') . '/' . trim($_POST["dir_name"], '/');
	if(validate_dir_path($_SESSION['uid'], $new_path))
	{
		if(mkdir(ROOT_DIR . '/' . $_SESSION["uid"] . '/' . $new_path, DIR_MODE))
		{
			header('Location: ' . get_current_url() . 'index.php?path=/' . rawurlencode($_POST['pwd']));
			exit;
		}
	}
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
