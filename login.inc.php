<?php

# use the _once to prevent
# Notice: Constant ROOT_DIR already defined ...
require("config.inc.php");

//$username: string, $password: md5(string)
function login($username, $password)
{
	global $mysql_conn;

	if($mysql_conn)
	{
		# Do you know "Exploits of a Mom?" http://xkcd.com/327/
		# This code is open for a SQL injection attack
		# Although mysql prevents the usage of ";" to concatenate multiple statements
		# as in the comic, you still can use it to bypass the password check
		# An input of ' or 1 -- makes the statement to return all rows.
		# You only uses the first result - which is in most cases the admin's account... 
		# Use mysql_real_escape_string(), but see next comment
		$sql_str = "select * from webexp_user where username='$username' and password='$password'";
		# the mysql_* functions are deprecated since PHP 5.5
		# use mysqli_* or PDO instead
		# also use Prepared Statements to prevent SQL injection 
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
				# usage of !empty() is maybe more clear than isset()
				if(isset($_POST["remember_me"]))
				{
					//remember username
					setcookie("username", $row["username"], time() + COOKIE_EXPIRE_TIME);
					setcookie("password", $row["password"], time() + COOKIE_EXPIRE_TIME);
				}

				return TRUE;
			}
			# there is no need to free ressources in PHP. PHP will care about itself
			# you only need this in cases of long running scripts
			mysql_free_result($result);
		}
		//echo "<br>$sql_str";
	}

	return FALSE;
}

# omit the closing tag at the end of a file. see config.inc.php
?>
