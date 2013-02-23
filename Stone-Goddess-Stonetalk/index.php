<?php 
include '../includes/dbconfig.php';

//$strstone = (int)$_GET['S'];
$strreccnt = (int)$_GET['R'];
$strstonename = $_GET['mineral'];

if ($strstone > 0 || $strstonename) {
$sql = "SELECT * FROM StoneTalk WHERE ";
if ($strstonename) $sql .= "linkname = '" . $strstonename . "' ;";
//if ($strstone) $sql .= "recno = " . $strstone . " ;";

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
    $descrip = $row["descri"];
	$itemname = $row["itemname"];
	$imagename = $row["image"];
	$filename = $row["file1"];
	$stoneviews = $row["views"];
	$stonerecno = $row["recno"];
 mysql_free_result($result);
  };  }; };
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Stone Goddess Rock Shop - Stone Talk <?php if (!$itemname == "") { echo '- ' . $itemname;} ?></title>
<meta name="description" content="Read about many different types of rocks and minerals while browsing the Stone Goddess Rock Shop. Learn more about <?php if (!$itemname == "") { echo $itemname . " and other";} ?> minerals!" />
<meta name="keywords" content="Stone Goddess,Stone Goddess Rock Shop,rock information,stone information,jewel info,Located in Richmond VA,minerals<?php if (!$itemname  == "") { echo "," . $itemname ; } ?>" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="http://www.stonegoddess.com/includes/global.css" type="text/css">
</head>
<body>
<div id="borderimg">
<div id="border">
<div id="Container">

<div id="h1txt">
  <h1>Read all about <?php if (!itemname == "") { echo $itemname . " and "; } ?>different kinds of rocks and minerals here at the Stone Goddess.</h1>
</div>

<div id="content">
<div align="center"><img src="http://www.stonegoddess.com/images/stonetalk.gif" alt="stone talk" width="280" height="54" />
</div>

<div id="rightclm">
<div id="dhtmltooltip"></div>
<script language="javascript" src="http://www.stonegoddess.com/includes/txtpopup.js" ></script>
<?PHP if (!$strstone  == "" || !$strstonename == "") {  
If ($recTmpeof = 1) { 
$stoneviews++;
$updateviewsquery = "UPDATE `StoneTalk` SET `views` = " . $stoneviews . " WHERE `recno` = " . $stonerecno;
mysql_query($updateviewsquery);
?>
        <table width="675" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
          <tr>
            <td width="20" height="20"><img src="http://www.stonegoddess.com/images/gretleft.gif" alt="3" /></td>
            <td height="20" background="http://www.stonegoddess.com/images/greenbg.gif" bgcolor="#FFFFFF"></td>
            <td width="20" height="20"><img src="http://www.stonegoddess.com/images/gretright.gif" alt="4" width="20" height="20" /></td>
          </tr>
          <tr>
            <td width="20" background="http://www.stonegoddess.com/images/greenbg.gif" bgcolor="#CCFF99"> </td>
            <td bgcolor="#FFFFFF"><div align="center"><div id="stalkdescr">
              <?php if (!$filename  == "") { ?>
              <img src="http://www.stonegoddess.com/Stone-Goddess-Stonetalk/images/<?php echo $imagename ;?>" /><br />
              <?php } else { ?>
              <img src="http://www.stonegoddess.com/Stone-Goddess-Stonetalk/images/noimg.jpg" width="128" height="128" /><br />
              <?php } ?>
<h2>Name: 
<?php echo $itemname ; ?></h2>
</div></div></td>
            <td width="20" rowspan="2" background="http://www.stonegoddess.com/images/greenbg.gif" bgcolor="#CCFF99"></td>
          </tr>
          <tr>
            <td width="20" background="http://www.stonegoddess.com/images/greenbg.gif" bgcolor="#CCFF99"></td>
            <td align="left" bgcolor="#FFFFFF">
			<hr id="stankhr" />
              <div id="stalkdescr"><?php echo $descrip ; ?></div>
            </td>
          </tr>
          <tr>
            <td colspan="4"><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%" id="AutoNumber5">
                <tr>
                  <td width="20" height="20"><img src="http://www.stonegoddess.com/images/grebleft.gif" alt="1" width="20" height="20" /></td>
                  <td width="100%" background="http://www.stonegoddess.com/images/greenbg.gif" bgcolor="#CCFF99"></td>
                  <td width="20" height="20"><img src="http://www.stonegoddess.com/images/grebright.gif" alt="2" width="20" height="20" /></td>
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
		<table width="301" height="164" border="0" align="center" cellpadding="3" cellspacing="0" style="border-collapse: collapse">
        <tr> 
      <td width="20" background="http://www.stonegoddess.com/images/granite1.jpg" >&nbsp;</td>
      <td background="http://www.stonegoddess.com/images/granite1.jpg" > </td>
      <td width="20" background="http://www.stonegoddess.com/images/granite1.jpg" >&nbsp;</td>
    </tr>
    <tr> 
      <td width="20" background="http://www.stonegoddess.com/images/granite1.jpg" style="font-family: verdana,arial,helvetica; font-size: 11px; color: #000000">&nbsp;</td>
      <td background="http://www.stonegoddess.com/images/Texture0306.jpg" style="font-family: verdana,arial,helvetica; font-size: 11px; color: #000000"> 
        <div align="center"><strong> <font color="#006633" size="2">Welcome to the Stone 
              Talk section of the Stone Goddess Rock Shop website. Here you will be able to read up on 
              rocks and minerals that we have and have had in our store. If you are looking 
              at an item and have no idea as to its history or uses you will find 
              them here.</font></strong> </div>		</td>
      <td width="20" background="http://www.stonegoddess.com/images/granite1.jpg" style="font-family: verdana,arial,helvetica; font-size: 11px; color: #000000">&nbsp;</td>
    </tr>
    <tr> 
      <td width="20" background="http://www.stonegoddess.com/images/granite1.jpg" >&nbsp; </td>
      <td background="http://www.stonegoddess.com/images/granite1.jpg" ></td>
      <td width="20" background="http://www.stonegoddess.com/images/granite1.jpg" >&nbsp;</td>
    </tr>
  </table>
	<?php } ?>
</div>

<div id="leftclm">
<div id="stalkdescr">
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
echo "<b>Learn About:</b><br />";
echo "<div id='leftmnuitems'><ul>";
while ($row = @mysql_fetch_array($result))
  {
$descrisub = strtolower(preg_replace('/[^a-zA-Z0-9_-]+/', '&#32' , strip_tags(substr($row[descri],0,250))));

$itemnamesub = substr($row[itemname],0,15);
$count = $count + 1;
$count1 = $count1 + 1;

echo "<li>{$count}.<a  href='http://www.stonegoddess.com/Stone-Goddess-Stonetalk/{$row[linkname]}/' ONMOUSEOVER=ddrivetip('{$descrisub}','lightgreen',300); ONMOUSEOUT=hideddrivetip()><strong>{$itemnamesub}</strong></a></li>\n";
  };
  echo "</ul></div>";

   };
   mysql_free_result($result);
mysql_close($connect);
?>
</div>
</div>

</div>

<div id="menu">
<?PHP 
$menutab = 'stonetalk';
require(STORE_DIRECTORY . 'includes/menu.html'); ?>
</div>

<div id="bottom">
<?PHP require(STORE_DIRECTORY . 'includes/footer.htm'); ?>
</div>

<div id="header">
<table width="100%" border="0" cellpadding="0" cellspacing="0" background="http://www.stonegoddess.com/images/mossyrocks.jpg">
  <tr> 
    <td width="72%" rowspan="2"><img src="http://www.stonegoddess.com/images/stonegoddessbannern.jpg" width="677" height="70" /></td>
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
