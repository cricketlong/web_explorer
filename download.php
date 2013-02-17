<?php

# Nimm require_once, siehe login.inc.php
require("config.inc.php");

# vermeide einfache Kopien von $_*, nimm das Original
$filename = $_GET['filename'];
header("Content-type: text/html");
header("Content-type: application/octet-stream");
header("Content-Length: ".filesize($filename));
header("Content-Disposition: attachment; filename=$filename");
# Nimm readfile()
$fp = fopen(ROOT_DIR."/".$filename, 'rb');
fpassthru($fp);
fclose($fp);

# schließenden PHP-Tag am Dateiende kann/sollte man weglassen
?>
