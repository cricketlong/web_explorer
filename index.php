<html>
<body>
<?php
# Eine HTML-Ausgabe führt dazu, dass die HTTP-Header gesendet werden. 
# Ab diesem Zeitpunkt kann man keine HTTP-Header-Funktionen mehr verwenden.
# z.B. session_start() - wegen des Session Cookie, oder header()
# Warning: session_start(): Cannot send session cookie - headers already sent by (output started at... 

# require(_once) ist keine Function, die Klammern können weggelassen werden
require_once("config.inc.php");
require_once("ls.inc.php");
require_once("login.inc.php");

//connect to mysql server
require_once("db_conn.php");

# Session ist bereits in einem der Include-Files gestartet -> PHP Notice
# error_reporting(E_ALL); ini_set('display_errors', 'on');
# oder besser in der php.ini setzen
session_start();

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
# Wenn du einfache Anführungszeichen (single quotation marks) für einen String
# verwendest, der doppelte Anführungszeichen enthält, kannst du das Escaping sparen
	exit;
}

//check cookie, wether this user has been remembered for auto login
if(!empty($_COOKIE["username"]) && !empty($_COOKIE["password"]))
{
	//echo "auto login<br>";
	login($_COOKIE["username"], $_COOKIE["password"]);
}

$path = $_GET["path"];
# Obwohl es sehr oft zu sehen ist, Werte aus den $_*-Arrays in einfache Variablen
# umzukopieren, ist dies nicht besonders sinnvoll. Es wird nur durch die zusätzlichen 
# Variablen die Komplexität erhöht und der eigentliche Ursprung des Wertes versteckt. 
# Manchmal wird argumentiert, dass es einfacher ist, $variablen in ""-Strings einzufügen. 
# Ja, vielleicht, aber meistens muss man htmlspecialchars() verwenden, um XSS zu verhindern.
# Man muss also den String unterbrechen, um die Funktion aufzurufen,
# und hat keinen Vorteil von der einfachen Variable. 
 
//if path is invalid, go to root directory of this user
if(empty($path))
	$path = "/";
if($path[0] != "/")
	$path = "/".$path;

//validate path
if(validate_dir_path($path) == FALSE)
{
# Der Standard verlangt eine vollständige URL http://...
# Die meisten Browser kommen jedoch auch mit der Kurzform zurecht.
	header("Location: index.php");
}

//show top-banner: home, parent, refresh, path and logout
$p_dir = get_parent_dir($path);
echo "<table width=100%>";
echo "<tr>";
# Verhindere XSS! Nimm immer Escaping Functionen wenn du Werte in einen String
# oder ein Kommando/Statement einfügst.
# Nimm htmlspecialchars() für das Einfügen von Daten in HTML
# Nimm rawurlencode() für das Einfügen von Daten in URLs
# Nimm rawurlencode() zuerst und dann htmlspecialchars(), wenn du Daten in eine URL
# einfügst, die in HTML eingefügt wird.
# echo '<p>' . htmlspecialchars($value) . '</p>';
# $url = 'http://example.com/path=' . rawurlencode($value);
# echo '<a href="' . htmlspecialchars($url) . '">htmlspecialchars($link_name)</a>'; 
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
