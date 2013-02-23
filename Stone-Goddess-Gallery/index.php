<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Stone Goddess Rock Shop - Minerals, Rocks, Jewelry Gallery</title>
<meta name="Description" content="Images of items that we carry or have carried in the Stone Goddess Rock Shop. If you are interested in rocks and minerals but are not sure what they look like the Stone Goddess has images for you!" />
<meta name="Keywords" content="Rock Shop,Stone Goddess Rock Shop,Richmond Virginia,rock pictures, jewelry pictures,minerale images,rock images,jewelry images"/>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="../includes/global.css" type="text/css" />
<script language="JavaScript" type="text/javascript">
<!-- Begin
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=640,height=480,left = 192,top = 144');");
}
// End -->
</script>
</head>
<body>
<div id="borderimg">
<div id="border">
<div id="Container">

<div id="h1txt">
  <h1>This is a listing of many images from items that we have had or do have in the Stone Goddess Rock Shop.</h1>
</div>

<div id="content">
<?php 
		
include '../includes/dbconfig.php';

$sql = "SELECT * FROM gallery ORDER BY dateadded ASC ;";

$result = mysql_query($sql, $connect);

if (!$result) {
$stonetalkdata = 0;
echo "error!" . "\n";
echo 'Invalid query: ' . mysql_error() . "\n";
echo $sql;
} else {
 $stonetalkdata = 1;
echo "<table border='0' align='center'> <tr>";
$picnum = 0;
while ($row = @mysql_fetch_array($result))
  {
$image = $row[image];
$thumbimage = $row[thumbimage];
$picnum = $picnum + 1;
if ($picnum > 5) {
$picnum = 1;
echo "</tr><tr>";
}; 

$mysock = getimagesize(STORE_DIRECTORY."Stone-Goddess-Gallery/photogallery/photo2477/".$thumbimage); 

echo "<td background='../images/greenbg.gif' bgcolor='#CCFF99' align='center'><a style='text-decoration: none' href=javascript:popUp('images/{$image}')><strong> 
      <img border='0' vspace='5' hspace='5' src='resize_image.php?image={$image}&new_width=100&new_height=72' title='' align='bottom' /> 
      </strong></a></td>";
  };  
  echo "</tr></table>";
  mysql_free_result($result); 
  }; 
  mysql_close($connect);
?>

</div>

<div id="menu">
<?PHP $menutab = 'gallery';
require(STORE_DIRECTORY . 'includes/menu.html'); ?>
</div>
<div id="bottom">
<?PHP require(STORE_DIRECTORY . 'includes/footer.htm'); ?>
</div>
<div id="header">
<table width="100%" border="0" cellpadding="0" cellspacing="0" background="../images/mossyrocks.jpg">
  <tr> 
    <td width="72%" rowspan="2"><img src="../images/stonegoddessbannern.jpg" width="677" height="70" /></td>
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
