<?php

# Nimm require_once, siehe login.inc.php
require("config.inc.php");

session_start();

//$dir: path of the directory, not the file
function validate_dir_path($dir)
{
	$full_path = ROOT_DIR."/".$_SESSION["uid"].$dir;

	# Leider gibt es keine PHP-Funktion, die relative Pfad-Teile (/../) auflöst.
	# Es gibt nur realpath(), aber das prüft auch auf vorhandene Verzeichnisse.
	# Es ist besser, eine Funktion zu schreiben, die zuerst relative Pfade in 
	# absolute auflöst und dann den Beginn mit dem Pfad für die zu speichernden Dateien.

	# Andererseits ist es sicherlich auch ausreichend, /./ und /../ zu verhindern.
	
	if(preg_match("/\/[.]{1,2}\//", $full_path) == 1)
		return FALSE;
	
	return TRUE;
}

# schließenden PHP-Tag am Dateiende kann/sollte man weglassen
?>
