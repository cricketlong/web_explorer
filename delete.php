<?php

require("config.inc.php");
require("validate_path.php");
require("ls.inc.php");

$filename = $_GET['filename'];
$pwd = $_GET['pwd'];

$full_path = ROOT_DIR.$filename;
echo $full_path."<br>";

if(validate_path(get_parent_dir($filename)) == TRUE && file_exists($full_path) == TRUE)
{
	unlink($full_path);
}

header("Location: index.php?path=$pwd");

?>
