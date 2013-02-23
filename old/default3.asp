<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--#Include virtual="/includes/functions.asp"-->
<% 
strPage=2
%>
<script language="JavaScript" type="text/javascript">
<!-- Begin
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=640,height=480,left = 192,top = 144');");
}
// End -->
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Stone Goddess Rock Shop - Minerlas, Rocks, Jewelry Gallery</title>
<meta name="Description" content="Images of items that we carry or have carried in the Stone Goddess Rock Shop. If you are interested in rocks and minerals but are not sure what they look like the Stone Goddess has images for you!" />
<meta name="Keywords" content="Rock Shop,Stone Goddess Rock Shop,Richmond Virginia,rock pictures, jewelry pictures,minerale images,rock images,jewelry images"/>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1" />
<link rel="stylesheet" href="../includes/global.css" type="text/css" />
</head>
<body>
<div id="borderimg">
<div id="border">
<div id="Container">

<div id="h1txt">
  <h1>This is a listing of many images from items that we have had or do have in the Stone Goddess Rock Shop.</h1>
</div>

<div id="content">
<% strstone=Request.QueryString("S")
%>
<%
Dim recTmp,recTmp2
call connectdb%>
<div align="center"><a name="top" id="top"></a><img src="../images/gallery.gif" width="208" height="54" /></div> 
<table border="0" align="center">
  <% 
	Set recTmp2 = Server.CreateObject ("ADODB.Recordset")
	recTmp2.Open "SELECT * FROM gallery ORDER BY dateadded ASC" , SomeDB
  dim rownum
  rownum = 1
  do until recTmp2.eof 
  if rownum = 1 then %>
  <tr> 
    <% end if %>
    <td background="../images/greenbg.gif" bgcolor="#CCFF99"><a style="text-decoration: none" href="javascript:popUp('images/<% Response.Write(recTmp2("image")) %>')"><strong> 
      <img border="0" vspace="5" hspace="5" src="photogallery/photo2477/<% Response.Write(Left(recTmp2("thumbimage"),15)) %>" title="" align="bottom" width="100" height="75" /> 
      </strong></a></td>
    <% if rownum = 5 then %>
  </tr>
  <% end if %>
  <% rownum = rownum +1
  if rownum > 5 then rownum = 1
  recTmp2.movenext
  loop
  if recTmp2.eof and rownum => 5 then %>
  <% end if
recTmp2.Close
Set recTmp2 = Nothing
call enddbcon
%>
</table>
</div>

<div id="menu">
  <div id="mainmenu">
<ul>
<li><a title="Welcome Page" href="http://stonegoddess.com/">Welcome</a></li>
<li><a title="Stone Talk Page - Information on different rocks." href="http://stonegoddess.com/Stone-Goddess-Stonetalk/">Stone Talk</a></li>
<li class="selected"><a title="Gallery Page - Images of items that we have or have had in the store." href="http://stonegoddess.com/Stone-Goddess-Gallery/">Gallery</a></li>
<li><a title="NewsLetter Page - Read current and previous NewsLetters." href="http://stonegoddess.com/Stone-Goddess-Newsletter/">NewsLetter</a></li>
<li><a title="New Items Page - A listing of new items in the store." href="http://stonegoddess.com/Stone-Goddess-NewItems/">New Items</a></li>
<li><a title="Show Times Page - A listing of upcoming shows." href="http://stonegoddess.com/Stone-Goddess-ShowTimes/">Show Times</a></li>
<li><a title="Stone Goddess Store Page - Come here to purchase items at our online store." href="http://stonegoddess.com/catalog/">Stone Goddess Store</a></li>
<li><a title="Contact Us Page - How to contact us and find the store." href="http://stonegoddess.com/rock-shop-contactus/">Contact Us</a></li>
<li><a title="About Us Page - Read all about how we came into existance." href="http://stonegoddess.com/Stone-Goddess-AboutUS/">About Us</a></li>
<li><a title="Links Page - Here you will find related links." href="http://stonegoddess.com/rocks-minerals-links/">Links</a></li>
<li><a title="Message Board - Come here to talk about minerals, books, jewelry, etc." href="http://stonegoddess.com/messageboard/">Board</a></li>
</ul>
  </div>
</div>
<div id="bottom">
<div align="center"><a title="Welcome Page" href="http://stonegoddess.com/">Welcome</a> 
  | <a title="Stone Talk Page - Information on different rocks." href="http://stonegoddess.com/Stone-Goddess-Stonetalk/">Stone 
  Talk</a> | <a title="Gallery Page - Images of items that we have or have had in the store." href="http://stonegoddess.com/Stone-Goddess-Gallery/">Gallery</a> 
  | <a title="NewsLetter Page - Read current and previous NewsLetters." href="http://stonegoddess.com/Stone-Goddess-Newsletter/">NewsLetter</a> 
  | <a title="New Items Page - A listing of new items in the store." href="http://stonegoddess.com/Stone-Goddess-NewItems/">New 
  Items</a> | <a title="Show Times Page - A listing of upcoming shows." href="http://stonegoddess.com/Stone-Goddess-ShowTimes/">Show 
  Times</a> | <a title="Stone Goddess Store Page - Come here to purchase at the online store." href="http://stonegoddess.com/catalog/">Stone Goddess Store</a> | <a title="Contact Us Page - How to contact us and find the store." href="http://stonegoddess.com/rock-shop-contactus/">Contact 
  Us</a> | <a title="About Us Page - Read all about how we came into existance." href="http://stonegoddess.com/Stone-Goddess-AboutUS/">About 
  Us</a> | <a title="Links Page - Here you will find related links." href="http://stonegoddess.com/rocks-minerals-links/">Links</a> | <a title="Links Page - Here you will find related links." href="http://stonegoddess.com/messageboard/">Stone Goddess Rock Shop Message Board</a> 
<br />
<font size="2">Copyright &copy; 2003-<%= datepart("yyyy",date())%> 
  Stone Goddess Rock Shop</font></div>
</div>
<div id="header">
<table width="100%" border="0" cellpadding="0" cellspacing="0" background="../images/mossyrocks.jpg">
  <tr> 
    <td width="72%" rowspan="2"><img src="../images/stonegoddessbannern.jpg" width="677" height="70" /></td>
  </tr>
  <tr> 
    <td width="28%" align="center"> 
<%  if session("joinedml")=true then
	else
	if Request.Form("bsubmit") = "Join" then
	if InStr(request.form("email"),"@")=0 then 
	Response.Write("<script language='javascript'>alert('You did not enter a valid email address.')</script>")
	%>
	   <form action = "" method = "post" name="form1" id="form1">
        <font color="#CC0000"><strong><font color="#BDFFAA">Join our NewsLetter 
        mailing list?</font><br />
         </strong></font> 
        <input name="email" type="text" size="15" />
        <input type="submit" name="bsubmit" value="Join" />
       </form>
	 <%
	else
	emailaddr = request.form("email")
	call joinmaillist(emailaddr)
	session("joinedml")=true
	Response.Write("<script language='javascript'>alert('Thank you for joining our mailing list.')</script>")
	end if
	else
	%>
      <form action = "" method = "post" name="form1" id="form1">
        <font color="#CC0000"><strong><font color="#BDFFAA">Join our NewsLetter 
        mailing list?</font><br />
         </strong></font> 
        <input name="email" type="text" size="15" />
        <input type="submit" name="bsubmit" value="Join" />
      </form>
	  <% end if 
	  	 end if
	  %>  	    </td>
  </tr>
</table>
</div>
</div>
</div>
</div>
</body>
</html>
