<?PHP
session_start();

// disable magic quotes
if (get_magic_quotes_gpc() && !function_exists('stripslashes_deep')) {
    function stripslashes_deep($value)
    {
        $value = is_array($value) ?
                    array_map('stripslashes_deep', $value) :
                    stripslashes($value);

        return $value;
    }

    $_POST = array_map('stripslashes_deep', $_POST);
    $_GET = array_map('stripslashes_deep', $_GET);
    $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
    $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
}

require('includes/dbconfig.php');
// load WYSIWYG editor
include_once("fckeditor/fckeditor.php") ;

//echo $_SESSION['loginadminokay'] . ' test';

// read or write acount values
if (!empty($_POST["username"])) {
$username = $_POST["username"]; 
} else {
$username = $_COOKIE['userusername'];
}
if (!empty($_POST["password"])) {
$password = $_POST["password"];
} else {
$password = $_COOKIE['userpassword'];
}

// logout
if ($_GET["logout"] == 1) {
session_destroy (); 
header('Location: http://www.stonegoddess.com/management/');
}

// login script
if ($_POST["submit"] == "login") { 

$getusercntsql = "SELECT count(*) as cnt FROM users WHERE username = '" . $username . "'";
$usercntresult = mysql_query($getusercntsql);
$usercountarray = mysql_fetch_array($usercntresult);
$usercount = $usercountarray['cnt'];

if (!empty($usercount)) {

$getusersql = "SELECT username, password, admin FROM users WHERE username = '" . $username . "'";
$userresult = mysql_query($getusersql, $connect);

while ($userrow = @mysql_fetch_array($userresult)) {

$admin = $userrow["admin"];

if ($password == $userrow["password"] && ($userrow["admin"] == 1 || $userrow["admin"] == 2)) {
$sql = "INSERT INTO `userlogins` ( `user` ) ";
$sql .= "VALUES ('" . $username . "');"; 
mysql_query($sql);

$_SESSION['admin']=$admin;
$_SESSION['username']=$username;
$_SESSION['loginadminokay'] = true;

if ($_POST['saveinfo'] == 1) {
setcookie("userusername", $username);
setcookie("userpassword", $password);
}

} else {
echo "<script language=\"javascript\">alert('You entered an incorrect password please try again')</script>";
}
}
} else {
echo "<script language=\"javascript\">alert('Either your password is incorrect or you do not have the priveledges to access this page.')</script>";
}

}

// get page id
$strPage=$_GET["P"];
?>
<html>
<head>
<?PHP 
// read page id then print correct title
switch ($strPage) { 
case 1:
echo "<title>Stone Goddess Rock Shop - Management - Stone Talk</title>";
break;
case 2:
echo "<title>Stone Goddess Rock Shop - Management - NewsLetter</title>";
break;
case 3:
echo "<title>Stone Goddess Rock Shop - Management - Send NewsLetter</title>";
break;
case 4:
echo "<title>Stone Goddess Rock Shop - Management - New Items</title>";
break;
//case 5:
//echo "<title>Stone Goddess Rock Shop - Management - Show Times</title>";
//break;
case 6:
echo "<title>Stone Goddess Rock Shop - Management - Store Items</title>";
break;
case 7:
echo "<title>Stone Goddess Rock Shop - Management - Gallery Manager</title>";
break;
case 8:
echo "<title>Stone Goddess Rock Shop - Management - User Manager</title>";
break;
case 9:
echo "<title>Stone Goddess Rock Shop - Management - Image upload Center</title>";
break;
case 10:
echo "<title>Stone Goddess Rock Shop - Management - Help Me</title>";
break;
case 11:
echo "<title>Stone Goddess Rock Shop - Management - Image Upload</title>";
break;
default: 
echo "<title>Stone Goddess Rock Shop - Management - Login</title>";
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="includes/cssstyle.css" type="text/css">
<script language="javascript" type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="../javascript/tinymce.js"></script>

</head>

<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0">
<!--<div class="errormsg">This section is currently being redeveloped. Please come back shortly.</div>-->
<table class="tableimg" width="975" height="100%" border="0" align="center" cellpadding="0" cellspacing="0"> 
<tr> 
  <td height="36" colspan="3" background="../images/granit.jpg"><?PHP require("includes/topm.htm"); ?></td>
  </tr>
  <tr>
  <td colspan="3">
  <div id="mainmenu">
<?PHP require("includes/menu1.htm"); ?>
    </div></td>
</tr>
<tr> 
  <td width="100%" height="100%" align="center" valign="top">
<?PHP switch ($strPage) {
case 1:
require('modules/stonetalk.php');
break;
case 2:
require('modules/newsletter.php');
break;
case 3:
require('modules/sendnewsletter.php');
break;
case 4:
require('modules/newitems.php');
break;
//case 5:
//require('modules/showtimes.php');
//break;
case 7:
require('modules/gallery.php');
break;
case 8:
require('modules/uermanager.php');
break;
case 10:
require('modules/helpme.php');
break;
case 11:
require('modules/image_upload.php');
break;
default: 
 if (empty($_SESSION['loginadminokay'])) { ?>
	   <form name="loginform" METHOD = "POST" class="loginform">
        <div style="background:#666666; color:#FFFFFF; width:250px; margin-bottom:5px;"><strong>Login here:</strong></div>
        Username:</font> 
        <font color="#000000"><input type="text" name="username" value="<?=$username?>">
        <br />Password: </font> 
        <font color="#000000"><input type="password" name="password" value="<?=$password?>">
        <br />Remember me?</font> 
        <input type="checkbox" name="saveinfo" value="1" >
        <input type="submit" name="submit" value="login">
      </form>
	  <?PHP }
}
?>  </td>
  </tr>
  <tr> 
  <td width="100%" height="10" align="center" valign="top">
  <?PHP require("includes/footer.htm"); ?>
  </td>
  </tr>
</table>

</body>
</html>
