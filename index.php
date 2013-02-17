<html>
<body>
<?php
# Start of HTML output results in sending HTTP-Headers
# After this point you can't use any any header modifiying funktions
# like session_start() - due to the Session Cookie, or header()
# Warning: session_start(): Cannot send session cookie - headers already sent by (output started at... 
# You can use output_buffering, but I wouldn't rely on it.

require_once("config.inc.php");
require_once("ls.inc.php");
require_once("login.inc.php");

# require is not a function, you can omit the braces

//connect to mysql server
require_once("db_conn.php");

session_start();
# session is alread started in one of the include files -> PHP Notice

//echo $_SESSION["username"].":".$_SESSION["uid"]."<br>";
if(empty($_SESSION["username"]) || empty($_SESSION["uid"]))
{
	echo "<div align=center><form action=\"login.php\" method=\"post\">".
		 "<p>Username:&nbsp;<input name=\"username\" value=\"";
		 if(isset($_COOKIE["username"]))
			 echo $_COOKIE["username"];
		 echo "\" />";
	echo "<p>Password:&nbsp;<input type=\"password\" name=\"password\" />".
		 "<p><input type=\"checkbox\" name=\"remember me\" />remember me&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
		 "<input type=\"submit\" value=\"login\" /></form></div>";
# using single quotation marks around a string containing double quotation marks
# saves the use of escaping backslashes
	exit;
}

//check cookie, wether this user has been remembered for auto login
if(!empty($_COOKIE["username"]) && !empty($_COOKIE["password"]))
{
	//echo "auto login<br>";
	login($_COOKIE["username"], $_COOKIE["password"]);
}

$path = $_GET["path"];
# although seen very often there is no sens in copying values from $_* arrays
# to single variables. you only add complexity and camouflage the real origin of a value.
# Sometimes it's argued simple variables are easier to insert into double quoted strings.
# Yes, maybe, but you almost ever have to use htmlspecialchars() to prevent XSS,
# so the function call leads to string concatenation and you don't need to insert
# simple variables into ""-strings anymore.  
 
//if path is invalid, go to root directory of this user
if(empty($path))
	$path = "/";
if($path[0] != "/")
	$path = "/".$path;

//validate path
if(validate_dir_path($path) == FALSE)
{
# the standard says Location needs a full url http://...
	header("Location: index.php");
}

//show top-banner: home, parent, refresh, path and logout
$p_dir = get_parent_dir($path);
echo "<table width=100%>";
echo "<tr>";
# Prevent XSS! Make proper usage of escaping functions whenever you insert values
# into a string of commands etc.
# use rawurlencode() for insering data into URLs
# use htmlspecialchars() for inserting data into HTML
# use rawurlencode() first and htmlspecialchars() then if you insert data into a
# URL which is inserted into HTML 
echo "<td width=40><a href=\"index.php?path=/\">home</a>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	  <td width=50><a href=\"index.php?path=$p_dir\">parent</a>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	  <td><a href=\"index.php?path=$path\">refresh</a>&nbsp;&nbsp;&nbsp;&nbsp;$path</td>
	  <td align=right></td>
	  <td align=right>".$_SESSION["username"]."&nbsp;&nbsp;&nbsp;<a href=\"logout.php\">logout</a></td>";
echo "</table>";
echo "</tr><br>";

//list directory
ls(ROOT_DIR."/".$_SESSION["uid"], $path);

echo "<br>";

//create directory
echo "<form name=\"mkdir\" action=\"mkdir.php\" method=\"post\">
	  directory:&nbsp;<input name=\"dir_name\" size=\"16\" />
	  <input name=\"pwd\" type=\"hidden\" value=\"$path\" />
	  <a href=\"javascript:mkdir.submit()\">create</a>
	  </form>";

//upload file
echo "<form name=\"upload\" enctype=\"multipart/form-data\" action=\"upload.php\" method=\"post\">
	  file:&nbsp;<input name=\"file\" type=\"file\" size=\"32\" />
	  <a href=\"javascript:upload.submit()\">upload</a>
	  </form>";

?>
</html>
</body>
