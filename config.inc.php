<?php

//root directory
# Es gibt auch eine "magische Konstante" __DIR__, 
# aber besser ist es, das Dokumentenverzeichnis außerhalb des DocumentRoot anzulegen
# /var/www/docroot/programfiles
# /var/www/files/...
define("ROOT_DIR", getcwd()."/www");	//all the user directories are in the directory "www"
define("COOKIE_EXPIRE_TIME", 300);	//in second

# Der schließende PHP Tag am Ende einer Datei kann weggelassen werden.
# PHP braucht ihn nicht. Ohne ? > kann kein Whitespace unbemerkt dahinter stehen.
# Whitespace führt dazu, dass die HTML-Ausgabe gestartet wird und damit auch die HTTP-Header.
# Man kann dann keine HTTP-Header verändernden Funktionen 
# (setcookie/session_start/header) mehr aufrufen. 
?>
