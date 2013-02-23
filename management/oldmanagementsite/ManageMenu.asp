<% 
if Session("loginadminokay") = True then %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Stone Goddess Management Menu</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body background="../images/bg5.jpg">
<Div align="center"><img src="../images/banner5.gif" width="375" height="70"></div>
<Div align="center">Welcome <%= session("username") %></div>

<table border="1" align="center" bgcolor="#CCCCCC">
  <tr>
    <td><fieldset>
      <legend><strong><font color="#FF0000">Management Menu</font></strong></legend>
      1.<a href="StoneTalk.asp">Stone Talk</a><br />
        2.<a href="NewsLetter.asp">News Letter</a><br />
        3.<a href="sendnewsletter.asp">Send out NewsLetter</a><br />
        4.<a href="NewItems.asp">New Items</a><br />
        5.<a href="showtimes.asp">Show Times</a><br />
        6.<a href="StoreItems.asp">Store Items</a><br />
        7.<a href="gallery.asp">Gallery Manager</a><br />
        8.<a href="usermanager.asp">User Manager</a> <br />
		9.Image Upload Center
      <div align="center"><a href="helpme.asp">Tutorial</a> </div>
      </fieldset> </td>
  </tr>
</table>
<div align="center"><a href="http://stonegoddess.com/management/default.asp?logout=1">Logout</a></div>
</body>
</html>
<% 
else 
%>
You either do not have priveledges to this page or you have not logged in:
To login click here: <a href="default.asp">Log In</a>
<%
end if
%>