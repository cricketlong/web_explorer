<?php

# use require_once, see login.inc.php
require("config.inc.php");
require("validate_path.inc.php");
require("ls.inc.php");

session_start();

# don't just copy from $_*, use the original
$filename = $_GET['filename'];
# Don't rely on the HTTP referer. This value is sometimes not existent, sometimes manipulated.
$last_url = $_SERVER["HTTP_REFERER"];

$full_path = ROOT_DIR."/".$_SESSION["uid"].$filename;

# no need for == true here (and the following if)
# "is it true that the path valid is?" In German: "doppelt gemoppelt" - done twice
if(validate_dir_path(get_parent_dir($filename)) == TRUE)
{
	if(file_exists($full_path) == TRUE)
	{
		unlink($full_path);
	}
}

header("Location: $last_url");

# omit the closing tag at the end of a file. see config.inc.php
?>
