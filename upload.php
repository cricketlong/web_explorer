<?php

require("config.inc.php");

session_start();

$file_name = $_FILES["file"]["name"];
$file_size = $_FILES["file"]["size"];
$file_type = $_FILES["file"]["type"];
$file_tmp_name = $_FILES["file"]["tmp_name"];
$file_error = $_FILES["file"]["error"];
$pwd = $_POST["pwd"];
$last_url = $_SERVER["HTTP_REFERER"];

if($file_error == UPLOAD_ERROR_OK)
{
	if($pwd == "/")
		$path = ROOT_DIR."/".$_SESSION["uid"]."/".$file_name;
	else
		$path = ROOT_DIR."/".$_SESSION["uid"]."/".$pwd."/".$file_name;

	if(move_uploaded_file($file_tmp_name, $path))
	{
		echo "<strong>\"$file_name\"</strong> has been successfully uploaded!<br>";
		echo "file name: $file_name<br>";
		echo "file size: $file_size<br>";
		echo "file type: $file_type<br>";
		//echo "moved to $path<br>";
		//echo "pwd: $pwd<br>";
	}
}
else
	echo "<font color=\"red\">Error occured while uploading!</font><br>";

echo "<a href=\"$last_url\">back to index</a>";

?>

