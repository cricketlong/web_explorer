<?php

require_once 'config.inc.php';
require_once 'utils.inc.php';

session_start();

setcookie("username", "", time() - COOKIE_EXPIRE_TIME);
setcookie("password", "", time() - COOKIE_EXPIRE_TIME);

$_SESSION = [];

session_destroy();

//jump back to index.php
header('Location: ' . get_current_url() . 'index.php');
