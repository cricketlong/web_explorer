<?php

# Dies ist eine Version, in der ich nur den vorhandenen Code mehr oder weniger
# anders geschrieben habe. Wenn ich es komplett selbst schreiben müsste,
# würde ich noch mehr Dinge anders lösen.
#
# Wichtig ist vor allem eine Trennung nach Business Logic und Output Logic.
# Die Business Logic (Geschäfslogik) sammelt alle Daten, verarbeitet sie und
# stellt die für die Ausgabe notwendigen Daten bereit.
# Die Ausgabelogik erstellt dann mit diesen Daten das HTML.
#
# (Ich verwende immer '' (single quotation marks) für einfache Strings.)

require_once "config.inc.php";
require_once "ls.inc.php";
require_once "login.inc.php";
require_once 'utils.inc.php';

session_start();

if (!empty($_POST['username']) && !empty($_POST['password']))
// POST check
{
	if (!login($_POST['username'], md5($_POST['password'])))
	{
		$print_login = true;
		$error = "Wrong username or password!";
	}
	else
	{
		//write cookies
		if (!empty($_POST["remember_me"]))
		{
			//remember username
			setcookie("username", $username, time() + COOKIE_EXPIRE_TIME);
			setcookie("password", md5($_POST['password']), time() + COOKIE_EXPIRE_TIME);
		}
	}
}
elseif(!empty($_COOKIE["username"]) && !empty($_COOKIE["password"]))
// check cookie, whether this user has been remembered for auto login
{
	if (!login($_COOKIE["username"], $_COOKIE["password"]))
	{
		$print_login = true;
	}
}
elseif(empty($_SESSION["username"]) && empty($_SESSION["uid"]))
// no session
{
	$print_login = true;
}

if (empty($print_login))
// is logged in
{
	//if path is invalid, go to root directory of this user
	$path = empty($_GET["path"]) ? '/' : '/' . trim($_GET["path"], '/');
	//validate path
	if(!validate_dir_path($_SESSION['uid'], $path))
	{
		header('Location: ' . get_current_url() . 'index.php');
		exit;
	}
	
	//show top-banner: home, parent, refresh, path and logout
	$parent_dir = dirname($path);
	
	$items = read_dir(ROOT_DIR . '/' . $_SESSION['uid'], $path);
}
?>
<html>
<head>
	<title>Web Explorer</title>
</head>
<body>
<?php if (!empty($print_login)): ?>
	<form action="" method="post" style="text-align: center;">
		<fieldset style="display: inline-block;">
<?php if (!empty($error)): ?>
			<p style="color:red;"><?=htmlspecialchars($error) ?></p>
<?php endif ?>		
			<p>Username:&nbsp;<input name="username" value="<?=
				isset($_COOKIE["username"]) ? $_COOKIE["username"] : '' ?>"></p>
			<p>Password:&nbsp;<input type="password" name="password"></p>
			<p><input type="checkbox" name="remember me">remember me&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="login"></p>
		</fieldset>
	</form>
<?php else: ?>
	<table style="width: 100%;">
		<tr>
			<td width="50"><a href="index.php?path=<?=rawurlencode('/') ?>">home</a></td>
	  	<td width="50"><a href="index.php?path=<?=rawurlencode($parent_dir) ?>">parent</a></td>
	  	<td><a href="index.php?path=<?=rawurlencode($path) ?>">refresh</a> <?=htmlspecialchars($path) ?></td>
	  	<td align=right></td>
	  	<td align=right><?=htmlspecialchars($_SESSION["username"]) ?>&nbsp;<a href="logout.php">logout</a></td>
		</tr>
	</table>
<?php if ($items): ?>
	<table border="1" style="margin: 1em 0;">
		<tr>
			<th align="left">file name</th>
			<th align="left">modified time</th>
			<th align="left">size</th>
			<th colspan="3">&nbsp;</th>
		</tr>
<?php foreach ($items as $item):
	$userfilename = user_file_name($_SESSION['uid'], $item['name']);
?>
		<tr>
			<td><?= is_dir($item['name']) ?
				dir_item($item['name'], $_SESSION['uid'], $path) :
				htmlspecialchars(user_file_name($_SESSION['uid'], $item['name'], $path)) ?></td>
			<td><?=date('d.m.Y H:i', $item['mtime']) ?></td>
			<td><?=number_format($item['size']) ?></td>
<?php if (!is_dir($item['name'])):?>
			<td><a href="download.php?filename=<?=rawurlencode($userfilename) ?>">download</a></td>
			<td><a href="viewfile.php?filename=<?=rawurlencode($userfilename) ?>">view</a></td>
			<td><a href="delete.php?filename=<?=rawurlencode($userfilename) ?>">delete</a></td>
<?php else:?>
			<td colspan="3">&nbsp;</td>
<?php endif;?>
		</tr>
<?php endforeach ?>	
	</table>

<?php else: ?>
	<p>No items.</p>
<?php endif ?>

<?php /* create directory */ ?>
	<form name="mkdir" action="mkdir.php" method="post">
	  directory:&nbsp;<input name="dir_name" size="16">
	  <input name="pwd" type="hidden" value="<?=htmlspecialchars($path) ?>">
	  <input type="submit" value="create">
	</form>

<?php /* upload file */ ?>
  
	<form name="upload" enctype="multipart/form-data" action="upload.php" method="post">
		<input type="hidden" name="pwd" value="<?=htmlspecialchars($path) ?>">
	  file:&nbsp;<input name="file" type="file" size="32">
	  <input type="submit" value="upload">
	</form>
	
<?php endif; ?>
</body>
</html>
