<?php

//root directory
define("ROOT_DIR", getcwd()."/www");	//all the user directories are in the directory "www"
# there is also a magic constant named __DIR__
define("COOKIE_EXPIRE_TIME", 300);	//in second

# omit the closing php tag before the end of a file.
# PHP doesn't need it. And w/o this closing tag no whitespace can hide behind it
# These whitespace can lead to starting HTML output,
# preventing the use of header modifying functions 
?>
