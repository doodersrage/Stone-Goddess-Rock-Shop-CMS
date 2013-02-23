<?PHP // sets store location
define('STORE_DIRECTORY','/home/doode0/public_html/stonegoddess/');
?>
<?php

if ($_GET['new']) {
setcookie ("sent", 0);
$sent = 0;
}

if ($_POST['Submit']) {

if (strpos($_POST['email'],'@')) {
$email = $_POST['email'];
//set cookie value
setcookie ("sent", 1);
$sent = 1;

if ($_POST['recipient'] == 1) $fromeml = "admin@stonegoddess.com"; else $fromeml = "robert.mcdowell@doodersrage.com";

$comment = $_POST['comment'];
$subject = $_POST['subject'];

//add From: header
$headers = "From: " . $email . "\r\n";

//specify MIME version 1.0
$headers .= "MIME-Version: 1.0\r\n";

//unique boundary
$boundary = uniqid("HTMLEMAIL");

//tell e-mail client this e-mail contains//alternate versions
$headers .= "Content-Type: multipart/alternative; boundary = $boundary\r\n\r\n";

//plain text version of message
$body = "--$boundary\r\n" .
   "Content-Type: text/plain; charset=ISO-8859-1\r\n" .
   "Content-Transfer-Encoding: base64\r\n\r\n";
$body .= chunk_split(base64_encode(strip_tags($comment)));

//HTML version of message
$body .= "--$boundary\r\n" .
   "Content-Type: text/html; charset=ISO-8859-1\r\n" .
   "Content-Transfer-Encoding: base64\r\n\r\n";
$body .= chunk_split(base64_encode($comment));

//send message
echo "<script language='javascript'>alert('Thank you for sending a message to the Stone Goddess Rock Shop!')</script>";
mail($fromeml, $subject, $body, $headers);
} else {
echo "<script language='javascript'>alert('You did not enter a valid email address!')</script>";
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Contact us at the Stone Goddess Rock Shop.</title>
<meta name="description" content="Come find Rocks, jewelry, carvings and books at the Stone Goddess Rock Shop store located in Richmond Virginia off of route 1. Visit us on your travels for rocks and minerals and you will be happy you did!" />
<meta name="keywords" content="rock shop,Stone Goddess,Stone Goddess Rock Shop,rocks,jewelry,books,carvings,fossils,buy online,richmond va rock shop,richmond virginia,richmond,richmond VA minerals,jewelry richmond" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="../includes/global.css" type="text/css">
<script language="javascript" type="text/javascript" src="../management/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="../javascript/tinymcemin.js"></script>
</head>

<body>
<div id="borderimg">
<div id="border">

<div id="Container">
<div id="h1txt">
  <h2>If you have a comment or idea that you would like to send us at the Stone Goddess please do it here.</h2>
</div>

<div id="content">
<div align=center> <img src="../images/contactus.gif" /></div>

<h3>Contact the Stone Goddess Rock Shop.</h3>

<?PHP
if ($HTTP_COOKIE_VARS["sent"] != 1 || $sent != 1) { 
?>
<div id="contactus">
<form name="form" METHOD = "POST" ACTION = "http://www.stonegoddess.com/rock-shop-contactus/" >
  <table border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td> 
        <label>
        <input name="recipient" type="radio" value=1 checked>
        Store and Merchandise Inquiries</label>
          <br />
          <label> 
          <input type="radio" name="recipient" value=2>
          Web site Inquiries</label>
        <br />
        Your email address: 
        <label> </label>
        <br />
          <input name="email" type="text" value="<?PHP echo $email ?>" size="25">
        <br />
          Subject:<br />
          <input name="subject" type="text" value="<?PHP echo $subject ?>" size="50">
          <br />
          Comment:<br />
          <textarea name="comment" cols="50" rows="12"><?PHP echo $comment ?></textarea>
          <br />
          <input type="submit" name="Submit" value="Submit"  onClick='return confirm("Submit comment?")'>
      </td>
    </tr>
  </table>
</form>
</div>
<?PHP 
} else {
echo '<div align="center"><a href="http://www.stonegoddess.com/rock-shop-contactus/?new=1">Click here to send the Stone Goddes Rock Shop another message.</a></div>';
}
?>
<p>Do you have any questions about merchandise that you have seen within the shop or items you would like to see within it? If you do please fill out the form below with suggestions or comments of what you would like to see in the Stone Goddess Rock Shop in Richmond Virginia. We will gladly answer your questions as soon as possible. If you want to send an email for store related questions or suggestions please select store ormerchandise inquiries from the form to the left. For questions or ideas related to the site and its online store please select website inquiries.</p>
<h4>Contact the Stone Goddess Rock Shop, your Richmond VA minerals location.</h4>
<p>At the Stone Goddess Rock Shop more merchandise is always coming including rocks, minerals, jewelry, carvings and related books. If you do not see anything of interests you at the store or while browsing our <a title="Stone Goddess Store Page - Come here to purchase at the online store." href="http://www.stonegoddess.com/catalog/">online store</a> should provide what you are looking for. Please take the time to write and let us know what interests you and what you are looking for. If you would like to see one of our shows please have a look at <a title="Show Times Page - A listing of upcoming shows." href="http://www.stonegoddess.com/Stone-Goddess-ShowTimes/">show times</a>! </p>
<h5>Make the Stone Goddess Rock Shop your Richmond VA rock shop!</h5>
<p>We hope that you have enjoyed your visit to The Stone Goddess Rock Shop and that you return soon. If you are yet to come visit the store, what are you waiting for! </p>
<table width="301" height="164" border="0" align="center" cellpadding="3" cellspacing="0" id="AutoNumber4" style="border-collapse: collapse">
  <tr>
    <td width="20" background="../images/granite1.jpg" >&nbsp;</td>
    <td background="../images/granite1.jpg" > </td>
    <td width="20" background="../images/granite1.jpg" >&nbsp;</td>
  </tr>
  <tr>
    <td width="20" background="../images/granite1.jpg" style="font-family: verdana,arial,helvetica; font-size: 11px; color: #000000">&nbsp;</td>
    <td background="../images/Texture0306.jpg" style="font-family: verdana,arial,helvetica; font-size: 11px; color: #000000">
      <div align="center"><strong> <font color=#006633 size="2">STONE GODDESS ROCKSHOP </font> </strong> </div>
      <div align="left"><font face="Times New Roman" size="2"><strong>Rare Crystals
            - Jewelry - Stone Carvings <br />
        Pendulums - Incense - Cut Stones <br />
        World Class Minerals and Fossils </strong></font></div>
      <div align="center"><strong><font color=#009900>804-279-0780</font></strong></div>
      <div align="left"><strong><font face="Times New Roman" size="2">10017 Jefferson
            Davis Hwy. <br />
        Richmond Va. 23237 <br />
        I-95 exit 62, Route 288 to 301 North 1/2 Mile</font></strong> </div>
    </td>
    <td width="20" background="../images/granite1.jpg" style="font-family: verdana,arial,helvetica; font-size: 11px; color: #000000">&nbsp;</td>
  </tr>
  <tr>
    <td width="20" background="../images/granite1.jpg" >&nbsp; </td>
    <td background="../images/granite1.jpg" ></td>
    <td width="20" background="../images/granite1.jpg" >&nbsp;</td>
  </tr>
</table>
</div>

<div id="menu">
<?PHP $menutab = 'contactus';
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
