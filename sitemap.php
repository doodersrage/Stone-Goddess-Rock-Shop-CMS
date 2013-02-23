<?php 
include 'includes/dbconfig.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Stone Goddess Rock Shop : Sitemap minerals, carvings, fossils, in Richmond Virginia. KEEPING YOU IN TOUCH WITH NATURE!</title>
<meta name="Description" content="Find rocks minerals jewelry fossils and more at the Stone Goddess Rock Shop in Richmond Virginia!" />
<meta name="Keywords" content="rock shop,stone goddess,stone goddess rock shop,rocks,minerals,jewelry,books,carvings,fossils,buy online,richmond va,richmond virginia,buy rocks,buy minerals,rock and mineral shops in va,fossils stones minerals,rock shop richmond" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="includes/global.css" type="text/css" />
<meta name="verify-v1" content="1xQtuR2AHFmSK/40QL+WDZQEis9BMcny2xYw2vSs7RM=" />
</head>

<body>
<div id="borderimg">
<div id="border">
<div id="Container">

<div id="h1txt">
  <h1>Stone Goddess Rock Shop: Keeping you in touch with nature sitemap for rocks minerals jewelry fossils and more.</h1>
</div>

<div id="content">
  <p><a href="http://www.stonegoddess.com/">Welcome to the Stone Goddess Rock Shop </a> - This is a link back to the main page of our site. <br />
      <a href="http://www.stonegoddess.com/catalog/">Online Stone Goddess Rock Shop Store </a> - This link will take you to our online store where you will be able to purchase rocks, minerals, jewelrym fossils and more.<br />
      <a href="http://www.stonegoddess.com/Stone-Goddess-AboutUS/">About The Stone Goddess Rock Shop </a> - This link will tell you more about the Stone Goddess Rock Shop and how to locate us.<br />
      <a href="http://www.stonegoddess.com/rocks-minerals-links/">Stone Goddess Rock Shop Links </a> - Here you will find interesting links.<br />
      <a href="http://www.stonegoddess.com/Stone-Goddess-Gallery/">Stone Goddess Rock Shop Gallery </a><br />
      <a href="http://www.stonegoddess.com/rock-shop-contactus/">Contact Us At The Stone Goddess Rock Shop </a><br />
      <a href="http://www.stonegoddess.com/Stone-Goddess-Stonetalk/">Stone Goddess Rock Shop Stone Talk </a> - Learn all about various minerals.</p>

    <?php
if (!$strreccnt) $strreccnt = 0;
$sql = "SELECT * FROM StoneTalk ORDER BY itemname ASC;";

$result = mysql_query($sql, $connect);

if (!$result) {
$stonetalkdata = 0;
echo "error!" . "\n";
echo 'Invalid query: ' . mysql_error() . "\n";
echo $sql;
} else {
$reccount = mysql_query("SELECT COUNT(*) FROM StoneTalk"); 
$reccountall = mysql_result($reccount,0) ; 
$stonetalkdata = 1;
$count = $count + $strreccnt;
$count1 = 0;
echo "<dl>";
while ($row = @mysql_fetch_array($result))
  {

$itemnamesub = substr($row[itemname],0,15);
$count++;
$count1++;
$findnext = ($count / 25) > 1;
if ($findnext > 0) {
$movenexttotal = $findnext * 25;
$movenxtcnt = $movenexttotal;
} else $movenxtcnt = 0;

echo "<dt>{$count}.<a  href='http://www.stonegoddess.com/Stone-Goddess-Stonetalk/{$row[linkname]}/'>{$row[itemname]}</a></dt>\n";

if ($movenxtcnt < $reccountall) $prevar + 1;
  };
  echo "</dl>";
   mysql_free_result($result);
   };
?>
    <a href="http://www.stonegoddess.com/Stone-Goddess-Newsletter/">Stone Goddess Rock Shop Newsletter </a>
	    <?php
if (!$strreccnt) $strreccnt = 0;
$sql = "SELECT * FROM NewsLetter ORDER BY lettertitle ASC;";

$result = mysql_query($sql, $connect);

if (!$result) {
$stonetalkdata = 0;
echo "error!" . "\n";
echo 'Invalid query: ' . mysql_error() . "\n";
echo $sql;
} else {
$reccount = mysql_query("SELECT COUNT(*) FROM NewsLetter"); 
$reccountall = mysql_result($reccount,0) ; 
$stonetalkdata = 1;
$count = $strreccnt;
$count1 = 0;
echo "<dl>";
while ($row = @mysql_fetch_array($result))
  {

$itemnamesub = substr($row[lettertitle],0,15);
$count++;
$count1++;
$findnext = ($count / 25) > 1;
if ($findnext > 0) {
$movenexttotal = $findnext * 25;
$movenxtcnt = $movenexttotal;
} else $movenxtcnt = 0;

echo "<dt>{$count}.<a  href='http://www.stonegoddess.com/Stone-Goddess-Newsletter/?S={$row[recno]}&amp;R={$movenxtcnt}'>{$itemnamesub}</a></dt>";

if ($movenxtcnt < $reccountall) $prevar + 1;
  };
  echo "</dl>";
   mysql_free_result($result);
   };
?>      
<a href="http://www.stonegoddess.com/Stone-Goddess-ShowTimes/">Stone Goddess Rock Shop Show Times </a> - this link will take you to a page giving you up to date information on new rock and mineral shows.
	    <?php
if (!$strreccnt) $strreccnt = 0;
$sql = "SELECT * FROM shows WHERE showdate >= CURDATE() ORDER BY showdate ASC;";

$result = mysql_query($sql, $connect);

if (!$result) {
$stonetalkdata = 0;
echo "error!" . "\n";
echo 'Invalid query: ' . mysql_error() . "\n";
echo $sql;
} else {
$reccount = mysql_query("SELECT COUNT(*) FROM shows"); 
$reccountall = mysql_result($reccount,0) ; 
$stonetalkdata = 1;
$count = $strreccnt;
$count1 = 0;
echo "<dl>";
while ($row = @mysql_fetch_array($result))
  {

$itemnamesub = substr($row[show],0,15);
$count++;
$count1++;
$findnext = ($count / 25) > 1;
if ($findnext > 0) {
$movenexttotal = $findnext * 25;
$movenxtcnt = $movenexttotal;
} else $movenxtcnt = 0;

echo "<dt>{$count}.<a href='http://www.stonegoddess.com/Stone-Goddess-ShowTimes/?S={$row[recno]}&amp;R={$movenxtcnt}'>{$itemnamesub}</a></dt>";

if ($movenxtcnt < $reccountall) $prevar + 1;
  };
  echo "</dl>";
   mysql_free_result($result);
   };
?>     
    <a href="http://www.stonegoddess.com/Stone-Goddess-NewItems/">Stone Goddess Rock Shop New Items </a> - Visit here to learn more about new items at the Stone Goddess.
    <br />
  </p>
</div>

<div id="menu">
<?PHP require(STORE_DIRECTORY . 'includes/menu.html'); ?>
</div>

<div id="bottom">
<?PHP require(STORE_DIRECTORY . 'includes/footer.htm'); ?>
</div>

<div id="header">
<table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/mossyrocks.jpg">
  <tr> 
    <td width="72%" rowspan="2"><img src="images/stonegoddessbannern.jpg" width="677" height="70" /></td>
  </tr>
  <tr> 
    <td width="28%" align="center">&nbsp;</td>
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
<?PHP mysql_close($connect); ?>
</body>
</html>
