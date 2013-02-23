<!--#Include File="functions.asp"-->
<link rel="stylesheet" href="cssstyle.css" type="text/css">
<% 
if request.form("username") <> "" then
username = request.form("username") 
else 
username = Request.Cookies("user")("username")
end if
if request.form("password") <> "" then
password = request.form("password") 
else 
password = Request.Cookies("user")("password")
end if

If request.querystring("logout") = 1 then
	Session("loginadminokay") = ""
end if

if Request.Form("Submit") = "login" then 

sql2 = "SELECT username, password, admin FROM users WHERE username = '" & username & "'"
Set recTmp2 = Server.CreateObject ("ADODB.Recordset")
recTmp2.Open sql2, SomeDB


If not recTmp2.eof then

admin = recTmp2("admin")

if password = recTmp2("password") and  (recTmp2("admin") = 1 or recTmp2("admin") = 2) then
sql = "INSERT INTO `userlogins` ( `user` ) "
sql = sql & "VALUES ('" & username & "');" 
Set recTmp = Server.CreateObject ("ADODB.Recordset")
recTmp.Open sql, SomeDB

session("admin")=admin
session("username")=username
Session("loginadminokay") = True

if request.form("saveinfo") = 1 then
Response.Cookies("user")("username") = username
Response.Cookies("user")("password") = password
end if

response.redirect("http://stonegoddess.com/management/default.asp")
else
response.Write("<script language=""javascript"">alert('You entered an incorrect password please try again')</script>")
end if

else
response.Write("<script language=""javascript"">alert('Either your password is incorrect or you do not have the priveledges to access this page.')</script>")
end if

recTmp2.Close
Set recTmp2 = Nothing
SomeDB.Close
Set SomeDB = Nothing
end if
%>
<% 
strPage=Request.QueryString("P")
%>
<html>
<head>
	<%select case strPage 
case 1%>
<title>Stone Goddess Rock Shop - Management - Stone Talk</title>
<%case 2%>
<title>Stone Goddess Rock Shop - Management - NewsLetter</title>
<%case 3%>
<title>Stone Goddess Rock Shop - Management - Send NewsLetter</title>
<%case 4%>
<title>Stone Goddess Rock Shop - Management - New Items</title>
<%case 5%>
<title>Stone Goddess Rock Shop - Management - Show Times</title>
<%case 6%>
<title>Stone Goddess Rock Shop - Management - Store Items</title>
<%case 7%>
<title>Stone Goddess Rock Shop - Management - Gallery Manager</title>
<%case 8%>
<title>Stone Goddess Rock Shop - Management - User Manager</title>
<%case 9%>
<title>Stone Goddess Rock Shop - Management - Image upload Center</title>
<%case 10 %> 
<title>Stone Goddess Rock Shop - Management - Help Me</title>
<%case else %>
<title>Stone Goddess Rock Shop - Management - Login</title>
<%
end select
%>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="../javascript/tinymce.js"></script>

</head>
<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0">
<table class="tableimg" width="975" height="100%" border="0" align="center" cellpadding="0" cellspacing="0"> 
<tr> 
  <td height="36" colspan="3" background="../images/granit.jpg"><!--#Include file="topm.htm"--></td>
  </tr>
  <tr>
  <td colspan="3">
  <div id="mainmenu">
<!--#Include file="menu1.htm"-->
    </div></td>
</tr>
<tr> 
  <td width="100%" height="100%" align="center" valign="top">
	<%select case strPage 
case 1%>
<!--#Include File="StoneTalk.asp"-->
<%case 2%>
<!--#Include File="NewsLetter.asp"-->
<%case 3%>
<!--#Include File="sendnewsletter.asp"-->
<%case 4%>
<!--#Include File="NewItems.asp"-->
<%case 5%>
<!--#Include File="showtimes.asp"-->
<%case 6%>
<!--#Include File="StoreItems.asp"-->
<%case 7%>
<!--#Include File="gallery.asp"-->
<%case 8%>
<!--#Include File="usermanager.asp"-->
<%case 10%>
<!--#Include File="helpme.asp"-->
<%case else 
%> 
      <% if Session("loginadminokay") = "" then %>
	   <form name="form1" METHOD = "POST" >
        <strong><font color="#000000">Login here:</font></strong><font color="#000000"><br />
        Username:</font> 
        <font color="#000000"><input type="text" name="username" value=<%=username%>>
        <br />Password: </font> 
        <font color="#000000"><input type="password" name="password" value=<%=password%>>
        <br />Remember me?</font> 
        <input type="checkbox" name="saveinfo" value="1" >
        <input type="submit" name="Submit" value="login">
      </form>
	  <% end if %>
<%
end select
%>  </td>
  </tr>
  <tr> 
  <td width="100%" height="10" align="center" valign="top">
  <!--#Include File="footer.htm"-->
  </td>
  </tr>
</table>

</body>
</html> 