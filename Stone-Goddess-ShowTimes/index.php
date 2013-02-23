<?PHP // sets store location
define('STORE_DIRECTORY','/home/doode0/public_html/stonegoddess/');
?>
<?php 
error_reporting (E_ALL ^ E_NOTICE);
if(is_file('./install_dat.php')){
	header("Location: install.php");
	exit;
}
extract($HTTP_POST_VARS);
extract($HTTP_GET_VARS);
include 'cl_files/calendar.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Stone Goddess Rock Shop - Show Times</title>
<meta name="description" content="Upcoming show listings with the Stone Goddess Rock Shop. If you are interested in upcoming shows come here to view a listing of them! We are contantly having shows in and around Virginia!" />
<meta name="keywords" content="Stone Goddess,Stone Goddess Rock Shop,upcoming shows,show times,show dates,Located in Richmond VA,rock shows,mineral shows" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="../includes/global.css" type="text/css">
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<div id="borderimg">
<div id="border">
<div id="Container">

<div id="h1txt">
  <h1>Find out when and where the stone goddess will be having its next rock show.</h1>
</div>

<div id="content">
<div align="center"><img src="../images/showtimes.gif"> <br />
  <br />
</div>
			<table cellspacing="0" cellpadding="0" width="100%" border="0">
			<tr>
				<td width="50%" align="center" valign="top">
				<?php 
				// for $calendar_name please, use only characters allowed for file names
				new calendar('Demo_horizontal');
				?>
				</td>
				<td><img src="cl_files/img/pixel.gif" width="30" height="1" border="0"></td>
				<td width="50%" align="center" valign="top">
				<?php 
				new calendar('Demo_vertical');
				?>
				</td>
			</tr>
			</table>
			<p align="center">Both calendars are controled from <b><a href="cl_files/index.php">Control panel</a></b><?php 
				$calendar->init('Demo_horizontal');
				$calendar->show_event();
?>
</div>

<div id="menu">
<?PHP $menutab = 'showtimes';
require(STORE_DIRECTORY . 'includes/menu.html'); ?>
</div>
<div id="bottom">
<?PHP require(STORE_DIRECTORY . 'includes/footer.htm'); ?>
</div>
<div id="header">
<table width="100%" border="0" cellpadding="0" cellspacing="0" background="../images/mossyrocks.jpg">
  <tr> 
    <td width="72%" rowspan="2"><img src="../images/stonegoddessbannern.jpg" width="677" height="70"></td>
  </tr>
  <tr> 
    <td width="28%" align="center"> 
	  </td>
  </tr>
</table>
</div>
</div>


</div>
</div>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-622084-7");
pageTracker._trackPageview();
</script>
</body>
</html>
