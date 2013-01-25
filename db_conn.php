<?php

$mysql_conn = mysql_pconnect("localhost", "php_test", "php_test");
if(!mysql_select_db("php_test", $mysql_conn))
	unset($mysql_conn);

?>
