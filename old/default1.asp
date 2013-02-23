<!--#Include virtual="/includes/functions.asp"-->
<% 
strPage=4
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Stone Goddess Rock Shop - Show Times</title>
<meta name="description" content="Upcoming show listings with the Stone Goddess Rock Shop. If you are interested in upcoming shows come here to view a listing of them! We are contantly having shows in and around Virginia!" />
<meta name="keywords" content="Stone Goddess,Stone Goddess Rock Shop,upcoming shows,show times,show dates,Located in Richmond VA,rock shows,mineral shows" />
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1" />
<link rel="stylesheet" href="../includes/global.css" type="text/css">
</head>
<body>
<div id="borderimg">
<div id="border">
<div id="Container">

<div id="h1txt">
  <h1>Find out when and where the stone goddess will be having its next rock show right here.</h1>
</div>

<div id="content">
<% strstone=Request.QueryString("S")
Dim recTmp,recTmp2
Dim Marque
call connectdb
%>
<div align="center"><img src="../images/showtimes.gif"> </div>
<div id="rightclm">
<div id="dek"></div>
<script language="JavaScript" src="../includes/txtpopup.js" type="text/javascript" ></script>
  <% if strstone <> "" then  
		Set recTmp = Server.CreateObject ("ADODB.Recordset")
recTmp.Open "SELECT * FROM shows WHERE recno = " & strstone, SomeDB
		If not recTmp.eof then
%>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
    <tr>
      <td width="20" height="20"><img src="../images/gretleft.gif" /></td>
      <td height="20" background="../images/greenbg.gif" bgcolor="#FFFFFF"></td>
      <td width="20" height="20"><img src="../images/gretright.gif" width="20" height="20" /></td>
    </tr>
    <tr>
      <td width="20" background="../images/greenbg.gif" bgcolor="#CCFF99"><strong> </strong> </td>
      <td bgcolor="#FFFFFF"><div align="center"><div id="stalkdescr">Date 
        Added: <strong>
                                  <% Response.Write(recTmp("dateadded")) %>
                                  </strong> <br />
        Show: <strong>
          <% Response.Write(recTmp("show")) %>
        </strong></div></div></td>
      <td width="20" rowspan="2" background="../images/greenbg.gif" bgcolor="#CCFF99">&nbsp;</td>
    </tr>
    <tr>
      <td width="20" background="../images/greenbg.gif" bgcolor="#CCFF99">&nbsp;</td>
      <td bgcolor="#FFFFFF"><hr id="stankhr" />
	  <div id="stalkdescr"><% Response.Write(recTmp("detail")) %></div>
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
  <% 
	   recTmp.Close
	   Set recTmp = Nothing
	   else
response.write "<center><b>Sorry but that item was not found.</b></center>"
end if
else %>
  <table width="301" border="0" align="center" cellpadding="0" cellspacing="0" id="AutoNumber4" style="border-collapse: collapse">
    <tr>
      <td width="20" background="../images/granit1.jpg" >&nbsp;</td>
      <td background="../images/granit1.jpg" ></td>
      <td width="20" background="../images/granit1.jpg" >&nbsp;</td>
    </tr>
    <tr>
      <td width="20" background="../images/granit1.jpg" style="font-family: verdana,arial,helvetica; font-size: 11px; color: #000000">&nbsp;</td>
      <td background="../images/Texture0306.jpg" style="font-family: verdana,arial,helvetica; font-size: 11px; color: #000000"><div align="center"><strong> <font color="#006633" size="2">Welcome to the Show
        Times section of our website. Here you will find a listing of upcoming
        shows and events.</font></strong></div></td>
      <td width="20" background="../images/granit1.jpg" style="font-family: verdana,arial,helvetica; font-size: 11px; color: #000000">&nbsp;</td>
    </tr>
    <tr>
      <td width="20" background="../images/granit1.jpg" >&nbsp;</td>
      <td background="../images/granit1.jpg" ></td>
      <td width="20" background="../images/granit1.jpg" >&nbsp;</td>
    </tr>
  </table>
  <% end if %>
</div>
<div id="leftclm">
<div id="stalkdescr">
<% dim count1
	   count1 = 0
	   if strreccnt = "" then strreccnt = 0
	   sql12 = "SELECT * FROM shows WHERE showdate >= CURDATE() ORDER BY showdate ASC LIMIT " & strreccnt & ",25" 
	Set recTmp2 = Server.CreateObject ("ADODB.Recordset")
	recTmp2.Open sql12, SomeDB
  	if recTmp2.eof then Marque = "No show dates listed"
response.write(Marque)
dim rownum
  rownum = 1
  do until recTmp2.eof 
  count1 = count1 + 1
%>
            <%=count1+strreccnt%>.<a style="text-decoration: none;" href="http://stonegoddess.com/Stone-Goddess-ShowTimes/?S=<%=recTmp2("recno")%>&amp;R=<%=strreccnt%>" ONMOUSEOVER="popup('<%=Left(recTmp2("show"),120)%>','lightgreen')"; ONMOUSEOUT="kill()"><strong> 
              <% Response.Write(Left(recTmp2("showdate"),15)) %>
              </strong></a><br />
          <% rownum = rownum +1
  recTmp2.movenext
  loop
recTmp2.Close
Set recTmp2 = Nothing %> 
<%if count1 = 25 or strreccnt <> "" then %>
<% if strreccnt <> 0 then %>
<a href="http://stonegoddess.com/Stone-Goddess-ShowTimes/?S=<%=strstone%>&amp;R=<%=strreccnt-25%>" >Previous</a>
  <% end if %>
&nbsp;&nbsp;&nbsp;
<% if strreccnt = "" then %><a href="http://stonegoddess.com/Stone-Goddess-ShowTimes/?S=<%=strstone%>&amp;R=50">Next</a>
<%end if %>
<%if count1 = 25 and strreccnt <> "" then %><a href="http://stonegoddess.com/Stone-Goddess-ShowTimes/?S=<%=strstone%>&amp;R=<%=strreccnt+25%>">Next</a>
<% end if %>
<% end if
call enddbcon
%>
</div>
</div>

</div>

<div id="menu">
  <div id="mainmenu">
<ul>
<li <% if strPage = "" then %>class="selected"<%end if%>><a title="Welcome Page" href="http://stonegoddess.com/">Welcome</a></li>
<li <% if strPage = 1 then %>class="selected"<%end if%>><a title="Stone Talk Page - Information on different rocks." href="http://stonegoddess.com/Stone-Goddess-Stonetalk/">Stone Talk</a></li>
<li <% if strPage = 2 then %>class="selected"<%end if%>><a title="Gallery Page - Images of items that we have or have had in the store." href="http://stonegoddess.com/Stone-Goddess-Gallery/">Gallery</a></li>
<li <% if strPage = 6 then %>class="selected"<%end if%>><a title="NewsLetter Page - Read current and previous NewsLetters." href="http://stonegoddess.com/Stone-Goddess-Newsletter/">NewsLetter</a></li>
<li <% if strPage = 7 then %>class="selected"<%end if%>><a title="New Items Page - A listing of new items in the store." href="http://stonegoddess.com/Stone-Goddess-NewItems/">New Items</a></li>
<li <% if strPage = 4 then %>class="selected"<%end if%>><a title="Show Times Page - A listing of upcoming shows." href="http://stonegoddess.com/Stone-Goddess-ShowTimes/">Show Times</a></li>
<li <% if strPage = 8 then %>class="selected"<%end if%>><a title="Stone Goddess Store Page - Come here to purchase items at our online store." href="http://stonegoddess.com/catalog/">Stone Goddess Store</a></li>
<li <% if strPage = 5 then %>class="selected"<%end if%>><a title="Contact Us Page - How to contact us and find the store." href="http://stonegoddess.com/rock-shop-contactus/">Contact Us</a></li>
<li <% if strPage = 3 then %>class="selected"<%end if%>><a title="About Us Page - Read all about how we came into existance." href="http://stonegoddess.com/Stone-Goddess-AboutUS/">About Us</a></li>
<li <% if strPage = 9 then %>class="selected"<%end if%>><a title="Links Page - Here you will find related links." href="http://stonegoddess.com/rocks-minerals-links/">Links</a></li>
<li <% if strPage = 9 then %>class="selected"<%end if%>><a title="Message Board - Come here to talk about minerals, books, jewelry, etc." href="http://stonegoddess.com/messageboard/">Board</a></li>
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
    <td width="72%" rowspan="2"><img src="../images/stonegoddessbannern.jpg" width="677" height="70"></td>
  </tr>
  <tr> 
    <td width="28%" align="center"> 
<%  if session("joinedml")=true then
	else
	if Request.Form("bsubmit") = "Join" then
	if InStr(request.form("email"),"@")=0 then 
	Response.Write("<script language='javascript'>alert('You did not enter a valid email address.')</script>")
	%>
	   <form name="form1" ACTION = "" METHOD = "POST">
        <font color="#CC0000"><strong><font color="#BDFFAA">Join our NewsLetter 
        mailing list?</font><br>
         </strong></font> 
        <input name="email" type="text" size="15">
        <input type="submit" name="bsubmit" value="Join">
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
      <form name="form1" ACTION = "" METHOD = "POST">
        <font color="#CC0000"><strong><font color="#BDFFAA">Join our NewsLetter 
        mailing list?</font><br>
         </strong></font> 
        <input name="email" type="text" size="15">
        <input type="submit" name="bsubmit" value="Join">
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
