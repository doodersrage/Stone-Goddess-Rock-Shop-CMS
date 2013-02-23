<% 
if Session("loginadminokay") = True and (session("admin")= 1 or session("admin") = 2) then %>
<%
if Request.Form("bsubmit") = "Submit" then
if session("admin")= 1 then

itemname = replace(request.form("StalkItem"), "'", "''")
descri =  replace(request.form("descri"), "'", "''")

if request.form("recno") = "" then
sql = "INSERT INTO `NewItems` ( `items` , `itemname`) "
sql = sql & "VALUES ('" & descri & "', '" & itemname & "');" 
else
sql = "UPDATE `NewItems` SET `dateposted` = NOW( ) ,"
sql = sql & "`items` = '" & descri & "',"
sql = sql & "`itemname` = '" & itemname & "' WHERE `recno` = '" & request.form("recno") & "' LIMIT 1 ;"
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

sql3 = "DELETE FROM `NewItems` WHERE `recno` = " & recno1

Set recTmp = Server.CreateObject ("ADODB.Recordset")
recTmp.Open sql3, SomeDB
else
marque="You do not have the privileges to update or post in this form."
end if
end if
if Request.Form("bsubmit") = "Edit" then

	recno = request.form("managesel")

	if recno <> "" then
	
	sql4 = "SELECT * FROM NewItems WHERE recno = " & recno
	Set recTmp3 = Server.CreateObject ("ADODB.Recordset")
	recTmp3.Open sql4 , SomeDB
	
	stonerecno = recTmp3("recno")
	stoneitem = "'" &  server.htmlencode(recTmp3("itemname")) & "'"
	stonedescri = recTmp3("items")
	else
	Marque = "You have not chosen an item to edit"
	end if
	
end if
%>
<div align="center"> <strong><font color="#FF0000"><%=Marque%> </font></strong>
  <table border="0" cellpadding="0" cellspacing="0">
    <tr> 
      <td rowspan="2" valign="top">
<form name="form1" method="post" action="">
          <fieldset>
          <legend><strong><font color="#FF0000">New Items Manager: 
          <%if stonerecno <> "" then%>
          Editing 
          <% else %>
          New 
          <% end if %>
          </font></strong></legend>
          <strong> 
          <input type=hidden name="recno" value=<%=stonerecno%>>
          Add new item:</strong><br />
          Item Title: 
          <input name="StalkItem" type="text" size="75" maxlength="255" value=<%=stoneitem%>>
          <br />
          Item listings:<br />
          <textarea name="Descri" cols="75" rows="12" ><%=stonedescri%></textarea>
          <br />
          <input type="submit" name="bsubmit" value="Submit">
          </fieldset>
        </form></td>
      <td valign="top"> 
        <%
	Set recTmp2 = Server.CreateObject ("ADODB.Recordset")
	recTmp2.Open "SELECT * FROM NewItems ORDER BY dateposted DESC", SomeDB
  %> <form name="form2" method="post" action="">
          <fieldset><legend><strong>View/Change Current Items:</strong></legend>
          Recno Added Name<br />
          <select name="managesel" size="10">
            <% do until recTmp2.eof %>
            <option value=<%=recTmp2("recno")%>> 
            <%=left(recTmp2("recno"),8) & " " & left(FormatDateTime(recTmp2("dateposted"),2),10) & " " & left(recTmp2("itemname"),12)%> </option>
            <% recTmp2.movenext
			loop %>
          </select>
          <br />          <input type="submit" name="bsubmit" value="Delete" onClick='return confirm("Are you sure you want to delete this item?")'>
<input type="submit" name="bsubmit" value="Edit">
          </fieldset>
        </form>
        <%
recTmp2.Close
Set recTmp2 = Nothing
SomeDB.Close
Set SomeDB = Nothing
%> </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</div>
<% 
else 
%>
You either do not have priveledges to this page or you have not logged in. <a href="http://stonegoddess.com/management/default.asp?logout=1">Click here to login.</a>

<%
end if
%>