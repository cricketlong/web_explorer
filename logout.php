<?php

# use require_once, see login.inc.php
require("config.inc.php");

session_start();

setcookie("username", "", time() - COOKIE_EXPIRE_TIME);
setcookie("password", "", time() - COOKIE_EXPIRE_TIME);

$_SESSION["uid"] = "";
$_SESSION["username"] = "";

session_destroy();

//jump back to index.php
# the standard says Location needs a full url http://...
header("Location: index.php");
//echo '<script type=text/javascript>location.href="index.php"</script>';

# omit the closing tag at the end of a file. see config.inc.php
?>
