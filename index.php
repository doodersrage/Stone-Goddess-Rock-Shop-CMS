<?PHP // sets store location
include 'includes/dbconfig.php';

// add email address to newsletter
if ($_POST["newsletter"] == 1) {
$check_query = mysql_query("SELECT email FROM newsletter_list WHERE email = '".$_POST['email_address']."';");
$found_email_cnt = mysql_num_rows($check_query);

if (empty($found_email_cnt)) {
mysql_query("INSERT INTO newsletter_list (email) VALUES ('".$_POST['email_address']."');");
$Marque = "Email address added to mailing list.<br>";
} else {
$Marque = "Email address already exists within mailing list.<br>";
}

}

// print sitemap link
$land_page = 1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Stone Goddess Rock Shop - minerals shop, carvings shop, fossils shop, in Richmond Virginia. KEEPING YOU IN TOUCH WITH NATURE!</title>
<meta name="Description" content="Come find rocks, minerals, jewelry, carvings and rock or mineral books at the Stone Goddess Rock Shop in Richmond Virginia directly off route 1. Browse our mineral shop today! Buy rocks or Minerals! Do not forget to browse our jewelry shop!" />
<meta name="Keywords" content="rock shop,mineral shop,jewelry shop,stone goddess,stone goddess rock shop,rocks,minerals,jewelry,rock books,mineral books,carvings,fossils,buy rocks online,buy minerals online,richmond va rock shop,richmond virginia mineral shop,buy rocks,buy minerals,rock and mineral shop in va,fossils richmond,rocks richmond,minerals richmond,rock shop richmond" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="includes/global.css" type="text/css" />
<meta name="verify-v1" content="1xQtuR2AHFmSK/40QL+WDZQEis9BMcny2xYw2vSs7RM=" />
</head>
<body>
<div id="borderimg">
  <div id="border">
    <div id="Container">
      <div id="h1txt">
        <h2>Stone Goddess Rock Shop: Keeping You In Touch With Nature! Richmond Virginia Mineral Shop, Shop Rocks, Shop Jewelry, Shop Mineral Books</h2>
      </div>
      <div id="content">
        <div align="center"> <?PHP echo $Marque; ?><img src="images/welcome.gif" width="235" height="54" /> <br />
          <img src="images/eggs.jpg" alt="Image of rocks, minerals, and fossils at the Stone Goddess Rock Shop" width="400" height="288" /> </div>
        <h3>Come visit us at the Stone Goddess Rock Shop Richmond VA Rock Shop!</h3>
        <p>If you have not been out to see us the Stone Goddess Rock Shop is located near Richmond Virginia in Chesterfield on route 1 (Jefferson Davis Highway). Our address is listed below or you could simply enter your address on the <a title="About Us Page - Read all about how we came into existance." href="http://www.stonegoddess.com/about-stone-goddess-rock-shop/">about us</a> page to get directions. We are located at the top of a hill and the knotty paneling is like that of an old time rock shop. This was done to be away from malls and other world distractions. We are working hard to make it worth your time to visit us. Having a modest start of just enough money for two months rent, some old fixtures and boxes. Thanks to our great customers we now carry items from dinosaur eggs to books on Dowsing.</p>
        <p>New items from around the world come in and leave our doors at the Stone Goddess Rock Shop. We now have crystals and minerals of every shape and color even some from out of earths physical grasp! The Stone Goddess Rock Shop is a great place to take your kids to learn information to write school papers on the past or plan to be future dinosaur hunters!  Fossils that we carry could be easily locked away within major museums.</p>
        <h4>Stone Goddess Rock Shop is more than a Richmond Virginia mineral shop!</h4>
        <p> To keep you 
          in touch with nature we also have books that tell about nature 
          and keep you interactive with nature. A part of being 
          in touch with nature is being in touch with ourselves and 
          other cultures, for this we have brought part of the world 
          to you. When you enter the shop; in each section you enter 
          a different country and different times in history. In the 
          shop you will find no wars just the best of nature and what makes us who we are.</p>
        <h5>Visit the Stone Goddess Rock Shop, your rock and mineral shop in VA!</h5>
        <form id="form1" name="form1" method="post" action="">
          <table border="0" align="center" cellpadding="4" cellspacing="0">
            <tr>
              <td align="center" bgcolor="#CCCCCC"><span class="style1">Sign Up For Our Newsletter</span></td>
            </tr>
            <tr>
              <td bgcolor="#FFFFFF">Email Address:
                <input type="text" name="email_address" id="email_address" /></td>
            </tr>
            <tr>
              <td align="center" bgcolor="#FFFFFF"><input type="hidden" name="newsletter" value="1" />
                <input type="submit" name="button" id="button" value="Sign Up" /></td>
            </tr>
          </table>
        </form>
        <br />
        <table align="center" width="360" height="275" border="0" cellspacing="0" id="AutoNumber6" style="border-collapse: collapse">
          <tr>
            <td><table cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%" id="AutoNumber11">
                <tr>
                  <td width="100%"><div align="center"><strong><u><font color="#006600" face="Footlight MT Light">STONE 
                      GODDESS ROCKSHOP </font></u></strong></div>
                    <div align="center"><strong><font face="Times New Roman"> &nbsp;&nbsp;Rare
                      Crystals - Jewelry - Stone Carvings<br />
                      &nbsp;&nbsp;Pendulums - Incense - Cut Stones<br />
                      &nbsp;&nbsp;World Class Minerals and Fossils </font></strong></div></td>
                </tr>
                <tr>
                  <td width="100%"><div align="center"> <strong><font color="#006600" face="Arial,Helvetica" size="2">(804)-279-0780</font></strong></div></td>
                </tr>
                <tr>
                  <td width="100%"><div align="center"><strong><font face="Times New Roman">&nbsp;&nbsp;10017
                      Jefferson Davis Hwy.<br />
                      &nbsp;&nbsp;Richmond Va. 23237<br />
                      &nbsp;&nbsp;I-95 exit 62, Route 288 to 301 North 1/2 Mile</font></strong></div></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td ><div align="center"><strong><font color="#006600" face="Footlight MT Light"><u>Store 
                Hours:</u></font> </strong></div>
              <table width="100%" cellpadding="0" cellspacing="0" id="AutoNumber10" style="border-collapse: collapse">
                <tr>
                  <td width="46%" align="center"><div align="right"><strong> <font face="Footlight MT Light" size="2">Monday 
                      and Tuesday</font></strong></div></td>
                  <td width="54%" align="center"><strong><font face="Footlight MT Light" size="2">Closed </font></strong></td>
                </tr>
                <tr>
                  <td width="46%" align="center"><div align="right"><strong> <font face="Footlight MT Light" size="2">Wednesday 
                      - Friday</font></strong></div></td>
                  <td width="54%" align="center"><strong><font face="Footlight MT Light" size="2">10 
                    AM TO 5:30 PM </font></strong></td>
                </tr>
                <tr>
                  <td width="46%" align="center"><div align="right"><strong> <font face="Footlight MT Light" size="2">Saturday</font></strong></div></td>
                  <td width="54%" align="center"><strong><font face="Footlight MT Light" size="2">10 
                    AM TO 5 PM </font></strong></td>
                </tr>
                <tr>
                  <td width="46%" align="center"><div align="right"><strong><font face="Footlight MT Light" size="2">Sunday</font></strong></div></td>
                  <td width="54%" align="center"><strong><font face="Footlight MT Light" size="2">1 
                    PM TO 5 PM</font></strong></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td height="10"></td>
          </tr>
        </table>
        <div align="center">
          <div align="center"><strong> <font size="3" color="#FF0000"> <a href="http://www.stonegoddess.com/rock-shop-contactus/">Questions or comments about the Stone Goddess Rock Shop?</a></font></strong></div>
        </div>
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
            <td width="72%" rowspan="2"><img src="images/stonegoddessbannern.jpg" alt="Image of Stone Goddess Rock Shop logo" width="677" height="70" /></td>
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
</body>
</html>
