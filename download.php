<?php

require("config.inc.php");

$filename = $_GET['filename'];
header("Content-type: text/html");
header("Content-type: application/octet-stream");
header("Content-Length: ".filesize($filename));
header("Content-Disposition: attachment; filename=$filename");
$fp = fopen(ROOT_DIR."/".$filename, 'rb');
fpassthru($fp);
fclose($fp);

?>
