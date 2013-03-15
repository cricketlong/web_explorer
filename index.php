<?php

require_once "config.inc.php";
require_once "ls.inc.php";
require_once "login.inc.php";
require_once 'utils.inc.php';

session_start();

//set timezone
date_default_timezone_set('Europe/Berlin');

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
{
	// check cookie, whether this user has been remembered for auto login
	if (!login($_COOKIE["username"], $_COOKIE["password"]))
	{
		$print_login = true;
	}
}
elseif(empty($_SESSION["username"]) && empty($_SESSION["uid"]))	// no session
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
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="style.css" type="text/css">
	<script src="jquery-1.9.1.js"></script>
	<script src="jquery-ui.js"></script>
	<script>
		$(function(){
			/* rename dialog */
			$('a').click(function(){
				if($(this).attr('id') == 'rename'){
					$('#old_filename').val($(this).parent().parent().children(':first').text());
					$('#new_filename').val($(this).parent().parent().children(':first').text());
					$('#rename_dialog').dialog('open');
				}
			});

			$('#rename_dialog').dialog({
				autoOpen: false,
				width: 300,
				modal: true,
				buttons: {
					'confirm': function(){
						$.post('rename.php', {	path: $('#label_cur_path').text(),
												old_filename: $('#old_filename').val(),
												new_filename: $('#new_filename').val() });
						$(this).dialog('close');
						location.reload();
					}
				}
			});
		});

	</script>
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
			<td width="50"><a href="index.php?path=<?=rawurlencode('/') ?>"><font size="4">home</font></a></td>
	  	<td width="50"><a href="index.php?path=<?=rawurlencode($parent_dir) ?>"><font size="4">parent</font></a></td>
	  	<td><a href="index.php?path=<?=rawurlencode($path) ?>"><font size="4">refresh</font></a>
			<label id="label_cur_path"><?=htmlspecialchars($path) ?></label></td>
	  	<td align=right></td>
	  	<td align=right><?=htmlspecialchars($_SESSION["username"]) ?>&nbsp;<a href="logout.php" align="right"><font size="4">logout</font></a></td>
		</tr>
	</table>
<?php if ($items): ?>
	<table id="ls">
		<tr>
			<th>file name</th>
			<th>modified time</th>
			<th>size</th>
			<th colspan="4">&nbsp;</th>
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
			<td><a href="download.php?filename=<?=rawurlencode('/'.$userfilename) ?>">download</a></td>
			<td><a href="viewfile.php?filename=<?=rawurlencode('/'.$userfilename) ?>">view</a></td>
			<td><a href="delete.php?filename=<?=rawurlencode('/'.$userfilename) ?>">delete</a></td>
<?php else:?>
			<td colspan="2"></td>
			<td><a href="delete.php?dirname=<?=rawurlencode('/'.$userfilename) ?>">delete</a></td>
<?php endif;?>
			<td><a id="rename" href="javascript:void(0);">rename</a></td>
		</tr>
<?php endforeach ?>	
	</table>

<?php else: ?>
	<p>No items.</p>
<?php endif ?>

<br>
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

<?php /* rename dialog div */ ?>
<div id="rename_dialog" title="rename file">
<form>
	<input id="old_filename" type="hidden" value=""></input>
	<input id="new_filename" value=""></input>
</form>

</body>
</html>
