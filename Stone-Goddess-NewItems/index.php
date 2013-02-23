<?php 
include '../includes/dbconfig.php';

$strstone = (int)$_GET['S'];
$strreccnt = (int)$_GET['R'];

if ($strstone > 0) {
$sql = "SELECT * FROM NewItems WHERE recno = " . $strstone . " ;";

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
    $descrip = $row["items"];
	$itemname = $row["itemname"];
	$dateposted = $row["dateposted"];

  };  mysql_free_result($result); }; };
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>See what new items we have available at the Stone Goddess Rock Shop in Richmond Virginia.</title>
<meta name="description" content="We are always getting in new items at the Stone Goddess Rock Shop. Stop by and take a look at our large selection of minerals, jewelry, fossils and more!" />
<meta name="keywords" content="Stone Goddess,Stone Goddess Rock Shop,Rocks,Jewelry,Books,Carvings,Buy Online,Located in Richmond VA,minerals" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="../includes/global.css" type="text/css">
</head>
<body>
<div id="borderimg">
<div id="border">
<div id="Container">

<div id="h1txt">
  <h1>Stone Goddess Rock Shop constantly gets new items and you will find them here.</h1>
</div>

<div id="content">

<div align="center"><img src="../images/newitems.gif"></div>
<div id="rightclm">
<div id="dhtmltooltip"></div>
          <script language="JavaScript" src="../includes/txtpopup.js" type="text/javascript" ></script>
<?PHP if (!$strstone  == "") {  
If ($recTmpeof = 1) { ?>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
    <tr>
      <td width="20" height="20"><img src="../images/gretleft.gif" /></td>
      <td height="20" background="../images/greenbg.gif" bgcolor="#FFFFFF"></td>
      <td width="20" height="20"><img src="../images/gretright.gif" width="20" height="20" /></td>
    </tr>
    <tr>
      <td width="20" background="../images/greenbg.gif" bgcolor="#CCFF99"><strong> </strong> </td>
      <td bgcolor="#FFFFFF"><div align="center"><div id="stalkdescr">Date Added: <strong>
          <?php echo $dateposted ; ?>
          </strong> <br />
        Name: <strong>
          <?php echo $itemname ; ?>
        </strong></div></div></td>
      <td width="20" rowspan="2" background="../images/greenbg.gif" bgcolor="#CCFF99">&nbsp;</td>
    </tr>
    <tr>
      <td width="20" background="../images/greenbg.gif" bgcolor="#CCFF99">&nbsp;</td>
      <td bgcolor="#FFFFFF"><hr id="stankhr" />
	  <div id="stalkdescr"><?php echo $descrip ; ?></div>
      </td>
    </tr>
    <tr>
      <td colspan="4"><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%" id="AutoNumber5">
          <tr>
            <td width="20" height="20"><img src="../images/grebleft.gif" width="20" height="20" /></td>
            <td width="100%" background="../images/greenbg.gif" bgcolor="#CCFF99">&nbsp;</td>
            <td width="20" height="20"><img src="../images/grebright.gif" width="20" height="20" /></td>
          </tr>
      </table></td>
    </tr>
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
      <td background="../images/Texture0306.jpg" style="font-family: verdana,arial,helvetica; font-size: 11px; color: #000000"><div align="center"><strong> <font color="#006633" size="2">Welcome to the New 
        Items section of our website. Here you will find a listing of all 
        the new items we have added to our store.</font></strong></div></td>
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
$sql = "SELECT * FROM NewItems ORDER BY itemname ASC LIMIT $strreccnt ,25 ;";

$result = mysql_query($sql, $connect);

if (!$result) {
$stonetalkdata = 0;
echo "error!" . "\n";
echo 'Invalid query: ' . mysql_error() . "\n";
echo $sql;
} else {
$reccount = mysql_query("SELECT COUNT(*) FROM NewItems"); 
$reccountall = mysql_result($reccount,0) ; 
$stonetalkdata = 1;
$count = $count + $strreccnt;
$count1 = 0;
echo "<b>New Items:</b><br />";
echo "<div id='leftmnuitems'><ul>";

while ($row = @mysql_fetch_array($result))
  {
$old_pattern = array('/[^a-zA-Z0-9_-]+/');
$descrisub = strtolower(preg_replace($old_pattern, '&#32' , strip_tags(substr($row[items],0,250))));
$itemnamesub = substr($row[itemname],0,15);
$count = $count + 1;
$count1 = $count1 + 1;

echo "<li>{$count}.<a href='http://www.stonegoddess.com/Stone-Goddess-NewItems/?S={$row[recno]}&amp;R={$strreccnt}' ONMOUSEOVER=ddrivetip('{$descrisub}','lightgreen'); ONMOUSEOUT=hideddrivetip()><strong>{$itemnamesub}</strong></a></li>";
  };
  echo "</ul></div>";
  $movenxtcnt = $strreccnt + 25;
  $prev = $movenxtcnt - 50;
  $prevcnt = $count1 - 25;
   if ($prev > -25) {
   $prevar = 1;
   echo "<a href='http://www.stonegoddess.com/Stone-Goddess-NewItems/?S={$strstone}&amp;R={$prev}' >Previous</a>";} else {
   $prevar = 0;};
  if ($movenxtcnt < $reccountall) $prevar + 1;
  if ($prevar > 1) echo " | ";
  if ($movenxtcnt < $reccountall) echo "<a href='http://www.stonegoddess.com/Stone-Goddess-NewItems/?S={$strstone}&amp;R={$movenxtcnt}'>Next</a>";
   mysql_free_result($result);
   };
mysql_close($connect);
?>
</div>
</div>

</div>
<div id="menu">
<?PHP $menutab = 'newitems';
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
