<?PHP
include '../includes/dbconfig.php';

if ($_POST['sersubmit'] == "Submit") {
	if ($_POST['txtaddress'] == "" || $_POST['txtcity'] == "" || $_POST['txtstate'] == "" || $_POST['txtzip'] == "") {
	if ($_POST['txtaddress'] == "") $marque = "You did not enter an address. \\r\\n";
	if ($_POST['txtcity'] == "") $marque .= "You did not enter a city. \\r\\n";
	if ($_POST['txtstate'] == "") $marque .= "You did not enter a state. \\r\\n";
	if ($_POST['txtzip'] == "") $marque .= "You did not enter a zip code. ";
	echo "<script language='javascript'>alert('" . $marque . "')</script>";
	} else{
	$newaddr = "Location: http://maps.google.com/maps?saddr=" . trim(str_replace(" ", "+",$_POST['txtaddress'])) . "%2C+" . trim(str_replace(" ", "+",$_POST['txtcity'])) . "%2C+" . trim(str_replace(" ", "+",$_POST['txtstate'])) . "%2C+" . trim(str_replace(" ", "+",$_POST['txtzip'])) . "&daddr=10017+Jefferson+Davis+Hwy%2C+Richmond%2C+VA+23237&hl=en";
	header($newaddr);
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Find out about the Stone Goddess Rock Shop here.</title>
<meta name="Description" content="Read up on the Stone Goddess Rock Shops history here. Let the Stone Goddess Rock Shop be your place for rocks, minerals, jewelry and books in Richmond VA!" />
<meta name="Keywords" content="va rock shop,stone goddess,stone goddess rock shop,stone goddess richmond va,richmond,virginia,rocks,richmond va minerals" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAnD7zdyR74ConQrcSSRK6XBQdpdP3xdcqfyxQqSnk4TD4-a1wFBStToV3urx5xw0uowqjg-WI1bl0yg"
            type="text/javascript"></script>
<script src="googlemaps.js" type="text/javascript"></script>
<link rel="stylesheet" href="../includes/global.css" type="text/css" />
</head>
<body  onload="load()" onunload="GUnload()">
<div id="borderimg">
  <div id="border">
    <div id="Container">
      <div id="h1txt">
        <h2>Stone Goddess Rock Shop is an old time rock shop in Richmond Virginia.</h2>
      </div>
      <div id="content">
        <div align="center"><img src="../images/aboutus.gif" /></div>
        <div id="map"> </div>
        <div align="left">
        <h3>The Stone Goddess Rock Shop is your Richmond VA Rock Shop!</h3>
          <p>&nbsp;&nbsp;&nbsp;&nbsp;For those who have not 
            been out to see us, we are in Chesterfield on Jefferson Davis Highway. 
            The location is at the top of a hill and the knotty paneling is like that 
            of an old time rock shop. We did this to be away from malls and world 
            distractions. We have worked hard to make it worth your time if you wanted 
            to visit with us. Just three short years ago, the Stone Goddess was opened 
            with just enough money for two months rent, some old fixtures and a few 
            boxes of minerals and crystals. Thanks to you who have shopped with us, 
            we now carry items from Dino Eggs to books on Dowsing.</p>
            <h4>We are your Richmond Virginia minerals supplier!</h4>
          <p>&nbsp;&nbsp;&nbsp;&nbsp;Every day new items from around the world enter 
            and leave the doors at the Goddess. We now have minerals and crystals 
            of every color and shape and some from outer space. The fossils we carry 
            could easily be in major museums. We are now becoming a place for kids, 
            to come and write school papers on the past, or plan to be a future dino 
            hunter!</p>
          <p>Our most recent addition to <a title="Stone Goddess Store Page - Come here to purchase at the online store." href="http://www.stonegoddess.com/catalog/">The Stone Goddess Rock Shop is the online store</a> not many products have been added as of recent but soon you will be able to simply login and purchase any of our wonderful rocks, minerals, jewelry, carvings and books. </p>
        </div>
        <h5>For directions to The Stone Goddess Rock Shop enter your address below.</h5>
        <form name="form1" id="frmsearchmp" method="post" action="">
          <table align="center">
          <tr>
            <td><div align="right">Address:</div></td>
            <td><div align="left">
                <input name="txtaddress" type="text" id="txtaddress" size="25" maxlength="25" />
              </div></td>
          </tr>
          <tr>
            <td><div align="right">City:</div></td>
            <td><div align="left">
                <input name="txtcity" type="text" id="txtcity" size="25" maxlength="25" />
              </div></td>
          </tr>
          <tr>
            <td><div align="right">State:</div></td>
            <td><div align="left">
                <input name="txtstate" type="text" id="txtstate" size="2" maxlength="2" />
              </div></td>
          </tr>
          <tr>
            <td><div align="right">Zip:</div></td>
            <td><div align="left">
                <input name="txtzip" type="text" id="txtzip" size="10" maxlength="10" />
              </div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="left">
              <input type="reset" name="Reset" value="Reset" />
              <input type="submit" name="sersubmit" value="Submit" onclick='return confirm(&quot;This will redirect you away from our site. \r\n To return click the back button within your browser.&quot;)'/>
            </td>
          </tr>
        </form>
      </div>
      </td>
      </tr>
      </table>
      <div align="center"></div>
    </div>
    <div id="menu">
<?PHP $menutab = 'aboutus';
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
