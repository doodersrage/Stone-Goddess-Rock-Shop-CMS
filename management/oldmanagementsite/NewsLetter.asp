<% 
if Session("loginadminokay") = True and (session("admin")= 1 or session("admin") = 2) then %>
<%
if Request.Form("bsubmit") = "Submit" then
if session("admin")= 1 then
itemname = replace(request.form("StalkItem"), "'", "''")
descri =  replace(request.form("descri"), "'", "''")

if request.form("recno") = "" then
sql = "INSERT INTO `NewsLetter` ( `dateposted` , `letter` , `lettertitle`) "
sql = sql & "VALUES ( NOW(),'" & descri & "', '" & itemname & "');" 
else
sql = "UPDATE `NewsLetter` SET `dateposted` = NOW( ) ,"
sql = sql & "`letter` = '" & descri & "',"
sql = sql & "`lettertitle` = '" & itemname & "' WHERE `recno` = '" & request.form("recno") & "' LIMIT 1 ;"
end if

Set recTmp = Server.CreateObject ("ADODB.Recordset")
recTmp.Open sql, SomeDB
'recTmp.Close
'Set recTmp = Nothing
else
marque="You do not have the privileges to update or post in this form."
end if
end if

if Request.Form("bsubmit") = "Delete" then
if session("admin")= 1 then
recno1 = request.form("managesel")

sql3 = "DELETE FROM `NewsLetter` WHERE `recno` = " & recno1

Set recTmp = Server.CreateObject ("ADODB.Recordset")
recTmp.Open sql3, SomeDB
else
marque="You do not have the privileges to update or post in this form."
end if
end if
if Request.Form("bsubmit") = "Edit" then

	recno = request.form("managesel")

	if recno <> "" then

	sql4 = "SELECT * FROM NewsLetter WHERE recno = " & recno
	Set recTmp3 = Server.CreateObject ("ADODB.Recordset")
	recTmp3.Open sql4 , SomeDB
	
	stonerecno = recTmp3("recno")
	stoneitem = "'" &  server.htmlencode(recTmp3("lettertitle")) & "'"
	stonedescri = recTmp3("letter")
	else
	Marque = "You have not chosen an item to edit"
	end if
	
end if
%>
<style type="text/css">
<!--
.style1 {
	color: #CC3300;
	font-weight: bold;
}
-->
</style>
<div align="center"><strong><font color="#FF0000"><%=Marque%> </font></strong>
  <table border="0" cellpadding="0" cellspacing="0">
    <tr> 
      <td rowspan="3" valign="top"> <form name="form1" method="post" action="">
          <fieldset>
          <legend><strong><font color="#FF0000"> NewsLetter Manager: 
          <%if stonerecno <> "" then%>
          Editing 
          <% else %>
          New 
          <% end if %>
          </font></strong></legend>
          <strong> 
          <input type=hidden name="recno" value=<%=stonerecno%>>
          Add new item:</strong><br>
          Letter Title: 
          <input name="StalkItem" type="text" size="75" maxlength="255" value=<%=stoneitem%>>
          <br>
          Letter:<br>
          <textarea name="Descri" cols="75" rows="12" ><%=stonedescri%></textarea>
          <br>
          <input type="submit" name="bsubmit" value="Submit">
          </fieldset>
        </form></td>
      <td valign="top"> <%
	Set recTmp2 = Server.CreateObject ("ADODB.Recordset")
	recTmp2.Open "SELECT * FROM NewsLetter ORDER BY dateposted DESC", SomeDB
  %> <form name="form2" method="post" action="">
          <fieldset>
          <legend><strong>View/Change Current Items:</strong></legend>
          Recno Added Name<br>
          <select name="managesel" size="10">
            <% do until recTmp2.eof %>
            <option value=<%=recTmp2("recno")%>> 
            <%=left(recTmp2("recno"),8) & " " & left(FormatDateTime(recTmp2("dateposted"),2),10) & " " & left(recTmp2("lettertitle"),12)%> </option>
            <% recTmp2.movenext
			loop %>
          </select>
          <br>          <input type="submit" name="bsubmit" value="Delete" onClick='return confirm("Are you sure you want to delete this item?")'>
<input type="submit" name="bsubmit" value="Edit">
          </fieldset>
        </form>
        <%
recTmp2.Close
Set recTmp2 = Nothing
%> </td>
    </tr>
    <tr>
      <td valign="top"><fieldset>
        <legend><strong> 
        <%
	Set recTmp9 = Server.CreateObject ("ADODB.Recordset")
	recTmp9.Open "SELECT * FROM NewsLetter ORDER BY views DESC LIMIT 0,10;", SomeDB
  %>
        Top 10 Viewed</strong></legend>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #000000">
          <tr style="background:#CCCCCC"> 
            <td style="border-bottom:1px solid #000000" align="center"><span class="style1">#</span></td>
            <td style="border-bottom:1px solid #000000" align="center"><span class="style1">Item</span></td>
            <td style="border-bottom:1px solid #000000" align="center"><span class="style1">Cnt</span></td>
          </tr>
          <%
		  Num1 = 0
		  do until recTmp9.eof 
		  Num1 = Num1 + 1
		  %>
          <tr> 
            <td style="border-left:1px solid #000000; padding-left:5px;"><div align="left"><%=Num1%>.</div></td>
            <td style="border-left:1px solid #000000; padding-left:5px; padding-right:5px;"><%=recTmp9("lettertitle")%></td>
            <td style="border-left:1px solid #000000; border-right:1px solid #000000; padding-left:5px; padding-right:5px;"><div align="center"><%=recTmp9("views")%></div></td>
          </tr>
          <% recTmp9.movenext
Loop%>
        </table>
        </fieldset>
        <%
recTmp9.Close
Set recTmp9 = Nothing
SomeDB.Close
Set SomeDB = Nothing
%>
      </td>
    </tr>
  </table>
  
</div>
<% 
else 
%>
You either do not have priveledges to this page or you have not logged in. <a href="http://stonegoddess.com/management/index.asp?logout=1">Click here to login.</a>

<%
end if
%>