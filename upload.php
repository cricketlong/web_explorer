<?php

require_once 'config.inc.php';
require_once 'utils.inc.php';

session_start();

if (!empty($_SESSION['uid']) and !empty($_POST["pwd"])) {
	$path = full_file_name($_SESSION['uid'], $_POST["pwd"]);
	
	if ($_FILES["file"]["error"] == UPLOAD_ERR_OK and
			strpos($_FILES["file"]["name"], '/') === false)
	{
		$file_name = $path . '/' . $_FILES["file"]["name"];
		if (validate_dir_path($_SESSION['uid'], $file_name) and
				!file_exists($file_name) and
				move_uploaded_file($_FILES["file"]["tmp_name"], $file_name))
		{
			chmod($file_name, FILE_MODE);
			$ok = true;
		}
	}
}
?>
<html>
<head>
<title>Web Explorer - File upload</title>
</head>
<body>
<?php if (!empty($ok)): ?>
	<p><strong><?=htmlspecialchars($_FILES["file"]["name"]) ?></strong> has been successfully uploaded!</p>
	<p>file name: <?=htmlspecialchars($_FILES["file"]["name"]) ?></p>
	<p>file size: <?=number_format($_FILES["file"]["size"]) ?></p>
	<p>file type: <?=htmlspecialchars($_FILES["file"]["type"]) ?></p>
<?php else: ?>
	<p style="color:red;">Error occured while uploading!</p>
<?php endif ?>
	<p><a href="index.php">back to index</a></p>
</body>
</html>			
