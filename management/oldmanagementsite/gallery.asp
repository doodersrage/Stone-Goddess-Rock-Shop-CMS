<% 
if Session("loginadminokay") = True and (session("admin")= 1 or session("admin") = 2) then %>
<%

if Request.QueryString("S") = 1 and session("admin")= 1 then

itemname = replace(request.form("StalkItem"), "'", "''")
thumbimg =  replace(request.form("thumbimg"), "'", "''")
image = replace(request.form("image"), "'", "''")

if request.form("recno") = "" then
sql = "INSERT INTO `gallery` ( `catagory` , `thumbimage` , `image`) "
sql = sql & "VALUES ('" & itemname & "', '" & thumbimg & "', '" & image & "');" 
else
sql = "UPDATE `gallery` SET `dateadded` = NOW( ) ,"
sql = sql & "`catagory` = '" & itemname & "',"
sql = sql & "`thumbimage` = '" & thumbimg & "',`image` = '" & image & "' WHERE `recno` = '" & request.form("recno") & "' LIMIT 1 ;"
end if

Set recTmp = Server.CreateObject ("ADODB.Recordset")
recTmp.Open sql, SomeDB, adModeReadWrite

'recTmp.addnew
'recTmp("itemname") = itemname
'recTmp("descri") = descri
'recTmp.update
'recTmp.Close
'Set recTmp = Nothing
elseif session("admin")= 2 then
marque="You do not have the privileges to update or post in this form."
end if
if Request.Form("bsubmit") = "Delete" and session("admin")= 1 then

recno1 = request.form("managesel")

sql3 = "DELETE FROM `gallery` WHERE `recno` = " & recno1

Set recTmp = Server.CreateObject ("ADODB.Recordset")
recTmp.Open sql3, SomeDB
elseif session("admin")= 2 then
marque="You do not have the privileges to update or post in this form."
end if
if Request.Form("bsubmit") = "Edit" then

	recno = request.form("managesel")
	
	if recno <> "" then

	sql4 = "SELECT * FROM gallery WHERE recno = " & recno
	Set recTmp3 = Server.CreateObject ("ADODB.Recordset")
	recTmp3.Open sql4 , SomeDB
	
	stonerecno = recTmp3("recno")
	stoneitem = "'" &  server.htmlencode(recTmp3("catagory")) & "'"
	thumbimg1 = recTmp3("thumbimage")
	image1 = recTmp3("image")
	
	else
	Marque = "You have not chosen an item to edit"
	end if
	
end if
%>
<div align="center"><strong><font color="#FF0000"><%=Marque%> </font></strong>
  <table border="0" cellpadding="0" cellspacing="0">
    <tr> 
      <td rowspan="2" valign="top">
<form action="http://stonegoddess.com/management/default.asp?P=7&S=1" method="post" name="form1">
          <fieldset>
          <legend><strong><font color="#FF0000">Gallery 
          Manager: </font><font color="#FF0000">
          <%if stonerecno <> "" then%>
          Editing 
          <% else %>
          New 
          <% end if %>
          </font></strong></legend>
          <strong> 
          <input type=hidden name="recno" value=<%=stonerecno%>>
          Add new item:</strong><br />
          Catagory: 
          <input name="StalkItem" type="text" maxlength="255" value=misc>
          <br />
          Thumbnail image:
          <% if thumbimg1 <> "" then %><input type="text" name="thumbimg" value=<%=thumbimg1%>><% end if %>
          <% if thumbimg1 = "" then %><input type="file" name="thumbimg"><% end if %>
          <br />
          Image:
          <% if image1 <> "" then %><input type="text" name="image" value=<%=image1%>><% end if %>
          <% if image1 = "" then %><input type="file" name="image"><% end if %>
          <br />
          <input type="submit" name="Submit" value="Submit">
          </fieldset>
        </form></td>
      <td valign="top"> 
        <%
	Set recTmp2 = Server.CreateObject ("ADODB.Recordset")
	recTmp2.Open "SELECT * FROM gallery ORDER BY dateadded DESC", SomeDB
  %> <form name="form2" method="post" action="http://stonegoddess.com/management/default.asp?P=7">
          <fieldset><legend><strong>View/Change Current Items:</strong></legend>
          Recno Added Name<br />
          <select name="managesel" size="10">
            <% do until recTmp2.eof %>
            <option value=<%=recTmp2("recno")%>> 
            <%=left(recTmp2("recno"),8) & " " & left(FormatDateTime(recTmp2("dateadded"),2),10) & " " & left(recTmp2("image"),12)%> </option>
            <% recTmp2.movenext
			loop %>
          </select>
          <input type="hidden" name="confirm" value="condel">
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
</div>
<% 
else 
%>
You either do not have priveledges to this page or you have not logged in. <a href="http://stonegoddess.com/management/default.asp?logout=1">Click here to login.</a>

<%
end if
%>