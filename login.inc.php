<?php

require_once 'config.inc.php';

function login($username, $md5password) {
	if ($user = get_user($username, $md5password))
	{
		$_SESSION['uid'] = $user['uid'];
		$_SESSION['username'] = $user['username'];
		return true;
	}
	
	return false;
}

/**
 * Check user credentials against database
 * 
 * - returns false in case of an database error
 * - returns null if no user was found
 * - returns array with user's data: uid, username
 * 
 * @param string $username
 * @param string $md5password
 * @return boolean|NULL|multitype:array
 */
function get_user($username, $md5password)
{
	$mysql = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	if ($mysql->connect_errno)
	{
		error_log("Connect failed: " . $mysql->connect_error);
		return false;
	}
	$mysql->set_charset('utf8');

	if (!($stmt = $mysql->prepare("select uid, username, password from webexp_user where username=? and password=?")))
	{
		error_log("Prpare failed: " . $mysql->error);
		return false;
	}

	if (!$stmt->bind_param('ss', $username, $md5password))
	{
		error_log("BindParam failed: " . $mysql->error);
		return false;
	}
	
	if (!$stmt->execute())
	{
		error_log("Execute failed: " . $mysql->error);
		return false;
	}

	if (!$stmt->bind_result($uid, $uname, $upass))
	{
		error_log("BindResult failed: " . $mysql->error);
		return false;
	}

	if ($stmt->fetch())
		return [
			'uid' => $uid,
			'username' => $uname,
		];
	
	return null;
}
