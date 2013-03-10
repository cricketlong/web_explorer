<?php


function abspath($path) {
	// replace two or more / with only one /
	$path = preg_replace('#/{2,}#', '/', $path);
	// remove ./ (but not ../)
	$path = preg_replace('#(?<!\.)\./#', '', $path);
	// replace /foo/../ with /
	$path = preg_replace('#(?<=/|^)[^/]*/\.\./#', '', $path);
	// remove ../ or /../ from the beginning
	$path = preg_replace('#^/?\.\./#', '', $path);
	return $path;
}

//$dir: path of the directory, not the file
function validate_dir_path($uid, $dir)
{
	$user_dir = ROOT_DIR . '/' . $uid;
	$full_path = $user_dir .  '/' . trim($dir, '/');

	return strpos(abspath($full_path), $user_dir) === 0;
}

/**
 * Removes beginning file path, returning only part in users directory
 * 
 * @param int $uid
 * @param string $file
 * @param string $path optional - remove also this part of the path
 * @return string
 */
function user_file_name($uid, $file, $path = null) {
	$user_dir = ROOT_DIR . '/' . $uid;
	$dir = empty($path) ? $user_dir : $user_dir . '/' . trim($path, '/');
	if (strpos($file, $dir) === 0)
		return trim(substr($file, strlen($dir)), '/');
}

/**
 * Returns the full path from a name relative to user's dir
 *  
 * @param int $uid
 * @param string $file
 * @return string
 */
function full_file_name($uid, $file) {
	$user_dir = ROOT_DIR . '/' . $uid;
	$full_path = $user_dir .  '/' . trim($file, '/');
	return $full_path;
}

/**
 * Get current URL as scheme://hostname/
 * 
 * @return string
 */
function get_current_url() {
	$scheme = !empty($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] :
		((isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on') ? 'https' : 'http');

	return sprintf('%s://%s/%s/', $scheme, $_SERVER['HTTP_HOST'], trim(APP_PATH, '/'));
}

