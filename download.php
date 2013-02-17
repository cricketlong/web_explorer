<?php

# use require_once, see login.inc.php
require("config.inc.php");

# don't just copy from $_*, use the original
$filename = $_GET['filename'];
header("Content-type: text/html");
header("Content-type: application/octet-stream");
header("Content-Length: ".filesize($filename));
header("Content-Disposition: attachment; filename=$filename");
# use readfile() instead
$fp = fopen(ROOT_DIR."/".$filename, 'rb');
fpassthru($fp);
fclose($fp);

# omit the closing tag at the end of a file. see config.inc.php
?>
