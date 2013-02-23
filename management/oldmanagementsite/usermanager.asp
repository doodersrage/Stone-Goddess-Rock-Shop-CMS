<% 
if Session("loginadminokay") = True and session("admin")= 1 then %>
<script language="VBScript" runat="server" >

</script>
<%
if Request.Form("bsubmit") = "Submit" then

if Request.Form("recno") <> "" then

	fname = Request.Form("fname")
	mi = Request.Form("mi")
	lname = Request.Form("lname")
	address1 = Request.Form("address1")
	address2 = Request.Form("address2")
	city = Request.Form("city")
	state12 = Request.Form("state")
	zip = Request.Form("zip")
	
	born = datepart("yyyy",Request.Form("born")) & "-" & datepart("m",Request.Form("born")) & "-" & datepart("d",Request.Form("born"))
	
	email1 = Request.Form("email1")
	username = Request.Form("username")
	password = Request.Form("password1")
	admin = Request.Form("admin")
	
If admin = "Yes" then admin = 1
if admin = "No" then admin = 0

sql = "UPDATE `users` SET "
sql = sql & "`fname` = '" & fname & "',`mi` = '" & mi & "',`lname` = '" & lname & "',`address1` = '" & address1 & "',"
sql = sql & "`address2` = '" & address2 & "',`city` = '" & city & "',`state1` = '" & state12 & "',"
sql = sql & "`zip` = '" & zip & "',`born` = '" & born & "',`emailaddr` = '" & email1 & "',"
sql = sql & "`username` = '" & username & "',`password` = '" & password & "',`admin` = '" & admin & "'"
sql = sql & " WHERE `recno` = '" & Request.Form("recno") & "' LIMIT 1 ;"

Set recTmp = Server.CreateObject ("ADODB.Recordset")
recTmp.Open sql, SomeDB
'recTmp.Close
'Set recTmp = Nothing

	fname = ""
	mi = ""
	lname = ""
	address1 = ""
	address2 = ""
	city = ""
	state12 = ""
	zip = ""
	born = ""
	email1 = ""
	username = ""
	password = ""
	admin = 0

Marque = "Account has been updated"
else
Marque = "you have not selected an account to edit yet"
end if

end if
if Request.Form("bsubmit") = "Delete" then

recno1 = request.form("managesel")

sql3 = "DELETE FROM `users` WHERE `recno` = " & recno1

Set recTmp = Server.CreateObject ("ADODB.Recordset")
recTmp.Open sql3, SomeDB
end if
if Request.Form("bsubmit") = "Edit" then

	recno = request.form("managesel")

	if recno <> "" then

	sql4 = "SELECT * FROM users WHERE recno = " & recno
	Set recTmp3 = Server.CreateObject ("ADODB.Recordset")
	recTmp3.Open sql4 , SomeDB
	
	stonerecno = recTmp3("recno")
	fname = "'" &  server.htmlencode(recTmp3("fname")) & "'"
	mi = "'" &  server.htmlencode(recTmp3("mi")) & "'"
	lname = "'" &  server.htmlencode(recTmp3("lname")) & "'"
	address1 = "'" &  server.htmlencode(recTmp3("address1")) & "'"
	address2 = "'" &  server.htmlencode(recTmp3("address2")) & "'"
	city = "'" &  server.htmlencode(recTmp3("city")) & "'"
	state12 = "'" &  server.htmlencode(recTmp3("state1")) & "'"
	zip = "'" &  server.htmlencode(recTmp3("zip")) & "'"
	born = "'" &  server.htmlencode(recTmp3("born")) & "'"
	email1 = "'" &  server.htmlencode(recTmp3("emailaddr")) & "'"
	username = "'" &  server.htmlencode(recTmp3("username")) & "'"
	password = "'" &  server.htmlencode(recTmp3("password")) & "'"
	admin = recTmp3("admin")
	else
	Marque = "You have not chosen an item to edit"
	end if
	
end if
%>
<div align="center"></div>
<div align="center"><%=Marque%></div>
<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td rowspan="2" valign="top"> 
      <form name="form1" method="post" action="">
                  <fieldset>
          <legend><strong><font color="#FF0000">User Manager: 
          </font></strong></legend>
		<table border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td valign="top">
<div align="right">Name:<strong> 
                <input type=hidden name="recno" value=<%=stonerecno%>>
                </strong> <br />
              </div></td>
            <td valign="top"> First: 
              <input name="fname" type="text" size="15" maxlength="25" value=<%=fname%>>
              MI: 
              <input name="mi" type="text" size="2" maxlength="2" value=<%=mi%>>
              Last: 
              <input name="lname" type="text" size="15" maxlength="25" value=<%=lname%>> 
            </td>
          </tr>
          <tr> 
            <td valign="top">
<div align="right">Address1: </div></td>
            <td valign="top">
<input name="address1" type="text" maxlength="50" value=<%=address1%>></td>
          </tr>
          <tr> 
            <td valign="top">
<div align="right">Address2: </div></td>
            <td valign="top">
<input name="address2" type="text" maxlength="50" value=<%=address2%>></td>
          </tr>
          <tr> 
            <td valign="top">
<div align="right">City: </div></td>
            <td valign="top">
<input name="city" type="text" size="15" maxlength="25" value=<%=city%>>
              State: 
              <input name="state" type="text" size="2" maxlength="2" value=<% if state12 <> "" then %><%=state12%><% end if %>>
              Zip: 
              <input name="zip" type="text" size="10" maxlength="10" value=<%=zip%>> 
            </td>
          </tr>
          <tr> 
            <td valign="top">
<div align="right">Born: </div></td>
            <td valign="top">
<input type="text" name="born" value=<%=born%>></td>
          </tr>
          <tr> 
            <td valign="top">
<div align="right">Email Address: 
              </div></td>
            <td valign="top">
<input name="email1" type="text" maxlength="255" value=<%=email1%>></td>
          </tr>

          <tr> 
            <td valign="top">
<div align="right">User Name: </div></td>
            <td valign="top">
<input name="username" type="text" maxlength="25" value=<%=username%>></td>
          </tr>
          <tr> 
            <td valign="top">
<div align="right">Password: </div></td>
            <td valign="top">
<input name="password1" type="text" maxlength="25" value=<%=password%>></td>
          </tr>
          <tr> 
            <td valign="top">
<div align="right"><font color="#FF0000">Admin?:</font></div></td>
            <td valign="top">
<select name="admin">
			<option <% if admin = 0 then %> selected> <% else %> > <% end if%>No</option>
			<option <% if admin = 1 then %> selected> <% else %> > <% end if%>Yes</option>
              </select></td>
          </tr>
          <tr> 
            <td valign="top">
<div align="right"> 
                <input type="reset" name="Reset" value="Reset">
              </div></td>
            <td valign="top">
<input type="submit" name="bsubmit" value="Submit"></td>
          </tr>
        </table>
		</fieldset>
      </form></td>
    <td valign="top"> <form name="form2" method="post" action="">
        <%
	Set recTmp2 = Server.CreateObject ("ADODB.Recordset")
	recTmp2.Open "SELECT * FROM users ORDER BY Lname ASC", SomeDB
  %>
          <fieldset><legend><strong>View/Change Current Items:</strong></legend>
        Fname Lname<br />
        <select name="managesel" size="7">
          <% do until recTmp2.eof %>
          <option value=<%=recTmp2("recno")%>> 
          <%=left(recTmp2("fname"),10) & " " & left(recTmp2("lname"),12)%> </option>
          <% recTmp2.movenext
			loop %>
        </select>
        <br />          
		<input type="submit" name="bsubmit" value="Delete" onClick='return confirm("Are you sure you want to delete this item?")'>
<input type="submit" name="bsubmit" value="Edit">
        <%
recTmp2.Close
Set recTmp2 = Nothing
SomeDB.Close
Set SomeDB = Nothing
%>
        </fieldset>
      </form></td>
  </tr>
</table>
<% 
else 
%>
You either do not have priveledges to this page or you have not logged in. <a href="http://stonegoddess.com/management/default.asp?logout=1">Click here to login.</a>

<%
end if
%>