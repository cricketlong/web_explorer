<?php

# Nimm _once um diese Meldung zu verhindern:
# Notice: Constant ROOT_DIR already defined ...
require("config.inc.php");

//$username: string, $password: md5(string)
function login($username, $password)
{
	global $mysql_conn;

	if($mysql_conn)
	{
		# Kennst du "Exploits of a Mom?" http://xkcd.com/327/
		# Der Code ist offen für einen SQL Injection Angriff
		# MySQL verhindert zwar die Verwendung von ";", so dass keine Mehrfach-Statements 
		# ausgeführt werden können, aber man kann immerhin noch die Passwort-Eingabe umgehen. 
		# Eine Eingabe von ' or 1 -- lässt das Statement alle Daten zurückgeben.
		# Dein Code verwendet nur den ersten Datensatz - aber der ist oftmals der Admin Account ... 
		# Nimm mysql_real_escape_string()
		$sql_str = "select * from webexp_user where username='$username' and password='$password'";
		# Die mysql_* functions sind seit PHP 5.5 "deprecated"
		# Nimm stattdessen mysqli_* oder PDO 
		# nimm außerdem Prepared Statements, um SQL Injection zu verhindern 
		$result = mysql_query($sql_str, $mysql_conn);
		if($result)
		{
			$row = mysql_fetch_assoc($result);
			if($row)
			{
				//username and password are correct
				$_SESSION["uid"] = $row["uid"];
				$_SESSION["username"] = $row["username"];

				//write cookies
				# !empty() ist hier verständlicher als isset()
				if(isset($_POST["remember_me"]))
				{
					//remember username
					setcookie("username", $row["username"], time() + COOKIE_EXPIRE_TIME);
					setcookie("password", $row["password"], time() + COOKIE_EXPIRE_TIME);
				}

				return TRUE;
			}
			# Resourcen freizugeben ist in PHP nicht notwendig. PHP macht selbst das am Script-Ende.
			# Du brauchst das nur in lange laufenden Script auszuführen.
			mysql_free_result($result);
		}
		//echo "<br>$sql_str";
	}

	return FALSE;
}

# schließenden PHP-Tag am Dateiende kann/sollte man weglassen
?>
