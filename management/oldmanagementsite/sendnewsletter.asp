<% 
if Session("loginadminokay") = True and (session("admin")= 1 or session("admin") = 2) then %>
<% 
if Request.Form("bsubmit") = "Submit" then
if session("admin")= 1 then
Dim mailmsg

'autosend newsletter
Set mailmsg = Server.CreateObject("CDONTS.NewMail")

mailmsg.From = "webmaster@stonegoddess.com"
mailmsg.To = "NewsLetter@stonegoddess.com"
mailmsg.Subject = request.form("subject")

emailmsgstr = "<!DOCTYPE HTML PUBLIC ""-//W3C//DTD HTML 4.01 Transitional//EN"" ""http://www.w3.org/TR/html4/loose.dtd"">"
emailmsgstr = emailmsgstr & "<html><head><title>" & request.form("subject") & "</title>"
emailmsgstr = emailmsgstr & "<meta http-equiv=""Content-Type"" content=""text/html; charset=iso-8859-1"">"
emailmsgstr = emailmsgstr & "</head>"
emailmsgstr = emailmsgstr & "<body bgcolor=""#ffffcc"">"
emailmsgstr = emailmsgstr & request.form("Descri")
emailmsgstr = emailmsgstr & "</body></html>"

mailmsg.Body = emailmsgstr

'mailmsg.MailFormat = 0
mailmsg.BodyFormat = 0

mailmsg.Send
Set mailmsg = Nothing
Marque = "Newsletter has been sent"
else
marque="You do not have the privileges to update or post in this form."
end if
end if
%>
<strong></strong>
<div align="center"></div>
<div align="center"><font color="#FF0000"><strong><%=Marque%></strong></font></div>
  
<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td rowspan="2" valign="top">
<form name="form1" method="post" action="">
        <fieldset><legend><strong><font color="#FF0000">Send NewsLetter:</font></strong> </legend>
		Subject:<br />
        <input name="subject" type="text" size="75">
        <br />
        NewsLetter :<br />
        <textarea name="Descri" cols="75" rows="10"></textarea>
        <br />
        <input type="submit" name="bsubmit" value="Submit">
      </fieldset>
	  </form></td>
    <td valign="top"><table border="0" align="right">
        <tr> 
          <td valign="bottom"><font color="#00FF66" size="3"><strong></strong></font> 
            <form name="form1" ACTION = "/cgi-sys/formmail.pl" METHOD = "POST">
              <fieldset><legend><strong>Add client to mailing list here.</strong></legend>
              <input type=hidden name="recipient2" value="NewsLetter-request@stonegoddess.com">
              <input type=hidden name="subject2" value="subscribe">
              <input type="text" name="email2">
              <input type=hidden name="redirect2" value="http://stonegoddess.com/management/default.asp?P=3">
              <input type="submit" name="Submit2" value="Submit">
			  </fieldset>
            </form></td>
        </tr>
      </table> </td>
  </tr>
</table>
<% 
else 
%>
You either do not have priveledges to this page or you have not logged in. <a href="http://stonegoddess.com/management/default.asp?logout=1">Click here to login.</a>
<%
end if
%>
