<?php

require("config.inc.php");

//$username: string, $password: md5(string)
function login($username, $password)
{
	global $mysql_conn;

	if($mysql_conn)
	{
		$sql_str = "select * from webexp_user where username='$username' and password='$password'";
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
				if(isset($_POST["remember_me"]))
				{
					//remember username
					setcookie("username", $row["username"], time() + COOKIE_EXPIRE_TIME);
					setcookie("password", $row["password"], time() + COOKIE_EXPIRE_TIME);
				}

				return TRUE;
			}
			mysql_free_result($result);
		}
		//echo "<br>$sql_str";
	}

	return FALSE;
}

?>
