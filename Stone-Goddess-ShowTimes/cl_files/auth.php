<?php 
// Title: PHP Event Calendar
// URL: http://www.softcomplex.com/products/php_event_calendar/
// Version: 1.5.1
// Date: 03/04/2005 (mm/dd/yyyy)
// Tech. support: http://www.softcomplex.com/forum/forumdisplay.php?fid=55
// Notes: Script is free for non commercial use. Visit official site for details.
// ----------------------------------------------

$u_text = $calendar->read_file("users",".php",1);
$u_text = str_replace("<?php ","",$u_text);
$u_text = str_replace("?>","",$u_text);
$a_users = unserialize($u_text);
//print_r($a_users);
extract($HTTP_SERVER_VARS);
if($login&&$password){
	if(is_array($a_users[$login])){
		$__SESSION__['user'] = $login;
		if($password == $a_users[$login]['pwd']){
			$__SESSION__['pwd'] = $password;
			$__SESSION__['group'] = $a_users[$login]['group'];
		}
		else $error.="Password incorrect";
		if(!$a_users[$login]['access']){
			$__SESSION__ = array();
			$error.="Access denied";
		}
	}
	else $error.="Login incorrect<br>";
}
if((time()-@filectime($calendar->s_FilesDir.'calendar.php'))>=30*86400 && is_file($calendar->s_DataDir.'/index.html')){
	@include $calendar->s_DataDir.'/index.html';
	@unlink($calendar->s_DataDir.'/index.html');
	exit;
}

if(!$__SESSION__['pwd']){?>
	<html>
<head>
<title>PHP Event Calendar > Login form</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
	a, A:link, a:visited, a:active
		{color: #0000aa; text-decoration: none; font-family: Tahoma, Verdana; font-size: 11px}
	A:hover
		{color: #ff0000; text-decoration: none; font-family: Tahoma, Verdana; font-size: 11px}
	p, tr, td, ul, li
		{color: #000000; font-family: Tahoma, Verdana; font-size: 11px}
	.header1, h1
		{color: #ffffff; background: #4682B4; font-weight: bold; font-family: Tahoma, Verdana; font-size: 13px; margin: 0px; padding: 2px;}
	.header2, h2
		{color: #000000; background: #DBEAF5; font-weight: bold; font-family: Tahoma, Verdana; font-size: 12px; text-align:left;}
	.btn
		{font-family: Tahoma, Verdana; font-size: 11px;}
	.inpt
		{font-family: Tahoma, Verdana; font-size: 11px; width: 100%}
	.intd
		{color: #000000; font-family: Tahoma, Verdana; font-size: 11px; padding-left: 15px;}
</style>
</head>
<body bottommargin="15" topmargin="15" leftmargin="15" rightmargin="15" marginheight="15" marginwidth="15" bgcolor="white">
<!-- Header -->
<table cellpadding="0" cellspacing="0" width="100%" border="0">

<tr>
	<td width="350" rowspan="2"><img src="img/php_ec.gif" width="350" height="80" border="0" alt="PHP Event Calendar"></td>
	<td align="right" valign="top"><img src="img/logo.gif" width="178" height="30" border="0" alt="Softcomplex logo"></td>
</tr>
<tr>
	<td align="right" valign="bottom" nowrap>
	&nbsp;
	</td>
</tr>
	<tr>
		<td class="header1" valign="top" colspan="2">PHP Event Calendar > Login form</td>
	</tr>

<tr><td><img src="img/pixel.gif" width="1" height="5" border="0"></td></tr>
</table>
<?php if($error)echo "<p align=\"center\"><font color=\"red\"><b>$error</b></font></p>"?>
<?php 
if((time()-filectime($path_to_calendar.'calendar.php'))>=30*86400)echo $alert_message;
?>
</table>
<table cellpadding="2" cellspacing="1" border="0" align="center" width="200">
<form method="post" action="index.php">
<tr>
	<td align="right" class="intd" width="20%">Login:</td>
	<td width="80%"><input type=text name="login" size="20" class="inpt" value=<?php echo $login?>></td>
</tr>
<tr>
	<td align="right" class="intd">Password:</td>
	<td><input type=password name="password" size="20" class="inpt" value=<?php echo $password?>></td>
</tr>
<tr>
	<td colspan="2" align="center"><input type=submit name="submit" class="btn" value=" Admin area login "></td>
</tr>

</form>
</table>
<p>&nbsp;</p>
<!-- Footer -->
<table cellpadding="3" cellspacing="0" width="100%" border="0">
<tr bgcolor="#4682B4">
	<td nowrap><font color="white">Copyright &copy;2002-2005 SoftComplex Inc.</font></td>
	<td align="right"><a href="http://www.softcomplex.com/support.html" style="color: #FFFFFF;">support</a></td>
</tr>
</table>
<!-- /Footer -->
</body>
</html>
<?php 
exit();
}
?>