<?php

require("config.inc.php");

session_start();

setcookie("username", "", time() - COOKIE_EXPIRE_TIME);
setcookie("password", "", time() - COOKIE_EXPIRE_TIME);

$_SESSION["uid"] = "";
$_SESSION["username"] = "";

session_destroy();

//jump back to index.php
header("Location: index.php");
//echo '<script type=text/javascript>location.href="index.php"</script>';

?>
