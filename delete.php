<?php

# Nimm require_once, siehe login.inc.php
require("config.inc.php");
require("validate_path.inc.php");
require("ls.inc.php");

session_start();

# vermeide einfache Kopien von $_*, nimm das Original
$filename = $_GET['filename'];
# Der HTTP Referer ist nicht zuverlässig. Dieser Wert ist manchmal nicht vorhanden oder manipuliert
$last_url = $_SERVER["HTTP_REFERER"];

$full_path = ROOT_DIR."/".$_SESSION["uid"].$filename;

# "== true" ist hier nicht notwendig
# "Ist es wahr, dass der Pfad valide ist?" Das ist "doppelt gemoppelt"
if(validate_dir_path(get_parent_dir($filename)) == TRUE)
{
	if(file_exists($full_path) == TRUE)
	{
		unlink($full_path);
	}
}

# Der Standard verlangt eine vollständige URL http://...
header("Location: $last_url");

# schließenden PHP-Tag am Dateiende kann/sollte man weglassen
?>
