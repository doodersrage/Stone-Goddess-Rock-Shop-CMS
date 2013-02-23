<?php 
// Title: PHP Event Calendar
// URL: http://www.softcomplex.com/products/php_event_calendar/
// Version: 1.5.1
// Date: 03/04/2005 (mm/dd/yyyy)
// Tech. support: http://www.softcomplex.com/forum/forumdisplay.php?fid=55
// Notes: Script is free for non commercial use. Visit official site for details.

?>
<html>
<head>
	<title>PHP Event Calendar - Documentation</title>
	<meta name="description" content="ASP upload component">
	<meta name="keywords" content="PHP Event Calendar, PHP, calendar, event, IIS,  Server side, Active Server Pages, Active Server Component, TYPE=FILE, TYPE, FILE, Windows, NT, Web, RFC1867, RFC-1867, 1867, Component, ENCTYPE, multipart/form-data, multipart, vbscript, activex, jscript, netscape, internet, explorer, download">
	<meta name="robots" content="index,follow">
	<style>
	a, A:link, a:visited, a:active
		{color: #0000aa; text-decoration: none; font-family: Tahoma, Verdana; font-size: 12px}
	A:hover
		{color: #ff0000; text-decoration: none; font-family: Tahoma, Verdana; font-size: 12px}
	tr, td, ul, li
		{color: #000000; font-family: Tahoma, Verdana; font-size: 12px}
	p
		{color: #000000; font-family: Tahoma, Verdana; font-size: 12px; text-align: justify; padding-left: 25px; padding-right: 25px;}
	h1
		{color: #ffffff; background: #4682B4; font-weight: bold; font-family: Tahoma, Verdana; font-size: 14px; margin-top: 5px; padding: 5px;}
	h2
		{color: #000000; background: #DBEAF5; font-weight: bold; font-family: Tahoma, Verdana; font-size: 13px; padding: 5px; text-align: right;}
	h3
		{color: #000000; font-weight: bold; font-family: Tahoma, Verdana; font-size: 13px; margin: 2px; }
	.wcell
		{background: #FFFFFF;}
	th
		{background: #DBEAF5; color: #000000;}
	pre
		{background: #dddddd; border: 1px solid black; color: black; padding-top: 1em; white-space: pre; padding: 10px;}
	.dsc
		{color: #000000; font-family: Tahoma, Verdana; font-size: 12px; margin-left: 50px; margin-top: 10px;}
	</style>
</head>
<body bgcolor="#ffffff" leftmargin="0" marginheight="0" marginwidth="0" topmargin="0">
<h1>PHP Event Calendar Documentation<a name="top"></a></h1>
<?php 
extract($HTTP_POST_VARS);
extract($HTTP_GET_VARS);
if(is_file('help.dat')){
		include 'help.dat';
		echo $help[$part];
}?>
<h2>&nbsp;</h2>
</body>
</html>