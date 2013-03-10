<?php

//root directory
define("ROOT_DIR", getcwd() . '/www');	//all the user directories are in the directory "www"

define('APP_PATH', 'web_explorer');

define("COOKIE_EXPIRE_TIME", 300); //in second

define('DB_HOST', 'localhost');
define('DB_NAME', 'php_test');
define('DB_USERNAME', 'php_test');
define('DB_PASSWORD', 'php_test');

define('DIR_MODE', 0700);
define('FILE_MODE', 0600);

//file extensions of the files that are allowed to be uploaded
define('UPLOAD_FILE_EXT', 'jpg|bmp|txt|pdf|doc|rar|bz2|gz');
