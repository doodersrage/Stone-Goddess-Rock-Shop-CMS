<?php 
include '../includes/dbconfig.php';

$strstone = (int)$_GET['S'];
$strreccnt = (int)$_GET['R'];

if ($strstone > 0) {
$sql = "SELECT * FROM NewsLetter WHERE recno = " . $strstone . " ;";

$result = mysql_query($sql, $connect);

if (!$result) {
$stonetalkdata = 0;
echo "error!" . "\n";
echo 'Invalid query: ' . mysql_error() . "\n";
echo $sql;
} else {
 $stonetalkdata = 1;

while ($row = @mysql_fetch_array($result))
  {
    $descrip = $row["letter"];
	$itemname = $row["lettertitle"];
	$dateposted = $row["dateposted"];
	$stoneviews = $row["views"];
	$stonerecno = $row["recno"];
  };  mysql_free_result($result); }; };
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Stone Goddess Rock Shop - Stone Goddess Newsletter</title>
<meta name="description" content="Come here to read the Stone Goddess Rock Shop Newsletter and find out about the many happenings with our store. Come here to learn more about upcoming items or shows at The Stone Goddess Rock Shop!" />
<meta name="keywords" content="Stone Goddess,Stone Goddess Rock Shop,Stone Goddess newsletter,Richmond Virginia,Located in Richmond VA,stone goddess newsletter,newsletter stonegoddess" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="../includes/global.css" type="text/css">
</head>
<body>
<div id="borderimg">
<div id="border">
<div id="Container">

<div id="h1txt">
  <h1>Read about different events, new items and things to come in the Stone Goddess Rock Shop newsletter.</h1>
</div>

<div id="content">
<div align="center"><img src="../images/newsletter.gif"> </div>

<div id="rightclm">
<div id="dhtmltooltip"></div>
          <script language="JavaScript" src="../includes/txtpopup.js" type="text/javascript" ></script>
<?PHP if (!$strstone  == "") {  
If ($recTmpeof = 1) { 
$stoneviews++;
$updateviewsquery = "UPDATE `NewsLetter` SET `views` = " . $stoneviews . " WHERE `recno` = " . $stonerecno;
mysql_query($updateviewsquery);
?>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
    <tr>
      <td width="20" height="20"><img src="../images/gretleft.gif" alt="3" /></td>
      <td height="20" background="../images/greenbg.gif" bgcolor="#FFFFFF"></td>
      <td width="20" height="20"><img src="../images/gretright.gif" alt="4" width="20" height="20" /></td>
    </tr>
    <tr>
      <td width="20" background="../images/greenbg.gif" bgcolor="#CCFF99"><strong> </strong> </td>
      <td bgcolor="#FFFFFF"><div align="center"><div id="stalkdescr">Date Added: <strong>
          <?php echo $dateposted ; ?>
          </strong> <br />
        NewsLetter: <strong>
          <?php echo $itemname ; ?>
        </strong></div>
      </div></td>
      <td width="20" rowspan="2" background="../images/greenbg.gif" bgcolor="#CCFF99">&nbsp;</td>
    </tr>
    <tr>
      <td width="20" background="../images/greenbg.gif" bgcolor="#CCFF99">&nbsp;</td>
      <td bgcolor="#FFFFFF"><hr id="stankhr" />
	  <div id="stalkdescr"><?php echo $descrip ; ?></div></td>
    </tr>
    <tr>
      <td colspan="4"><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%" id="AutoNumber5">
          <tr>
            <td width="20" height="20"><img src="../images/grebleft.gif" alt="1" width="20" height="20" /></td>
            <td width="100%" background="../images/greenbg.gif" bgcolor="#CCFF99">&nbsp;</td>
            <td width="20" height="20"><img src="../images/grebright.gif" alt="2" width="20" height="20" /></td>
          </tr>
      </table></td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
  </table>
<?php
} else {
echo "<center><b>Sorry but that item was not found.</b></center>";
}
?>
		<?php } else { ?>
  <table width="301" border="0" align="center" cellpadding="0" cellspacing="0" id="AutoNumber4" style="border-collapse: collapse">
    <tr>
      <td width="20" background="../images/granite1.jpg" >&nbsp;</td>
      <td background="../images/granite1.jpg" ></td>
      <td width="20" background="../images/granite1.jpg" >&nbsp;</td>
    </tr>
    <tr>
      <td width="20" background="../images/granite1.jpg" style="font-family: verdana,arial,helvetica; font-size: 11px; color: #000000">&nbsp;</td>
      <td background="../images/Texture0306.jpg" style="font-family: verdana,arial,helvetica; font-size: 11px; color: #000000"><div align="center"><strong> <font color="#006633" size="2">Welcome to the NewsLetter 
        section of our website here you will find a listing of our recent 
        newsletters. </font></strong></div></td>
      <td width="20" background="../images/granite1.jpg" style="font-family: verdana,arial,helvetica; font-size: 11px; color: #000000">&nbsp;</td>
    </tr>
    <tr>
      <td width="20" background="../images/granite1.jpg" >&nbsp;</td>
      <td background="../images/granite1.jpg" ></td>
      <td width="20" background="../images/granite1.jpg" >&nbsp;</td>
    </tr>
  </table>
	<?php } ?>
</div>

<div id="leftclm">
<div id="stalkdescr">
<?php
if (!$strreccnt) $strreccnt = 0;
$sql = "SELECT * FROM NewsLetter ORDER BY lettertitle ASC LIMIT $strreccnt ,25 ;";

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
$count = $count + $strreccnt;
$count1 = 0;
echo "<b>Newsletters:</b><br />";
echo "<div id='leftmnuitems'><ul>";

while ($row = @mysql_fetch_array($result))
  {
$descrisub = strtolower(preg_replace('/[^a-zA-Z0-9_-]+/', '&#32' , strip_tags(substr($row[letter],0,250))));
$itemnamesub = substr($row[lettertitle],0,15);
$count = $count + 1;
$count1 = $count1 + 1;

echo "<li>{$count}.<a  href='http://www.stonegoddess.com/Stone-Goddess-Newsletter/?S={$row[recno]}&amp;R={$strreccnt}' ONMOUSEOVER=ddrivetip('{$descrisub}','lightgreen'); ONMOUSEOUT=hideddrivetip()><strong>{$itemnamesub}</strong></a></li>";
  };
  echo "</li></div>";
  $movenxtcnt = $strreccnt + 25;
  $prev = $movenxtcnt - 50;
  $prevcnt = $count1 - 25;
   if ($prev > -25) {
   $prevar = 1;
   echo "<a href='http://www.stonegoddess.com/Stone-Goddess-Newsletter/?S={$strstone}&amp;R={$prev}' >Previous</a>";} else {
   $prevar = 0;};
  if ($movenxtcnt < $reccountall) $prevar + 1;
  if ($prevar > 1) echo " | ";
  if ($movenxtcnt < $reccountall) echo "<a href='http://www.stonegoddess.com/Stone-Goddess-Newsletter/?S={$strstone}&amp;R={$movenxtcnt}'>Next</a>";
   mysql_free_result($result);
   };
mysql_close($connect);
?>
</div>
</div>

</div>

<div id="menu">
<?PHP $menutab = 'newsletter';
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
