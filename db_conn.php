<?php
# Don't use the p(ersistant) variant if you don't know all the implications.
# You have to properly configure both the webserver and the mysql server
# to handle persistant connections without drawbacks.
# A MySQL connection establishment is fast enough, there is no real advantage
# in using persistent connection, especially not in such a small application.
$mysql_conn = mysql_pconnect("localhost", "php_test", "php_test");
# Always consider that a mysql function (in fact almost every function) can fail.
# $mysql_conn is false in this, but false is not an accepted value for the
# following mysql functions -> 
# Warning: mysql_select_db() expects parameter 2 to be resource, boolean given ...
if(!mysql_select_db("php_test", $mysql_conn))
	unset($mysql_conn);

# what character encoding do you want to use to communicate with the mysql server?
# use mysql_set_charset() or an equivalent


# omit the closing tag at the end of a file. see config.inc.php
?>
