<?php
# Nimm nicht die p(ersistant)-Version wenn du nicht alle Bedingungen dafür kennst.
# Du musst den Webserver und den MySQL-Server ordentlich konfigurieren,
# um persistente Verbindungen ohne Nachteile nutzen zu können.
# Ein MySQL-Verbindungsaufbau ist schnell genug, es gibt keinen wirklichen Vorteil
# für die p-Variante, besonders nicht in solch einer kleinen Anwendung.
$mysql_conn = mysql_pconnect("localhost", "php_test", "php_test");
# Berücksichtige immer, dass eine mysql-Function (eigentlich fast jede Funktion)
# einen Fehler zurückgeben kann.
# $mysql_conn ist false in diesem Fall, aber false ist kein gültiger Wert für
# nachfolgende mysql Functionen -> 
# Warning: mysql_select_db() expects parameter 2 to be resource, boolean given ...
if(!mysql_select_db("php_test", $mysql_conn))
	unset($mysql_conn);

# In welcher Zeichenkodierung (character encoding) möchtest du mit dem MySQL_Server
# kommunizieren? Nimm mysql_set_charset()

# mysql_*-Funktionen sollten nicht mehr verwendet werden, stattdessen mysqli oder PDO

# schließenden PHP-Tag am Dateiende kann/sollte man weglassen
?>
