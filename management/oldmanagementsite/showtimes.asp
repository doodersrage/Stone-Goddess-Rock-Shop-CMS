<% 
if Session("loginadminokay") = True and (session("admin")= 1 or session("admin") = 2) then %>
<%
if Request.Form("bsubmit") = "Submit" then
if session("admin")= 1 then

itemname = replace(request.form("StalkItem"), "'", "''")
descri =  replace(request.form("descri"), "'", "''")
month22 = request.form("month11")
day2 = request.form("day11")
year3 = request.form("year11")

if request.form("recno") = "" then
sql = "INSERT INTO `shows` ( `showdate` , `detail` , `show`) "
sql = sql & "VALUES ('" & year3 & "-" & month22 & "-" & day2 & "', '" & descri & "', '" & itemname & "');" 
else
sql = "UPDATE `shows` SET `showdate` = NOW( ) ,"
sql = sql & "`detail` = '" & descri & "',`showdate` = '" & year3 & "-" & month22 & "-" & day2 & "',"
sql = sql & "`show` = '" & itemname & "' WHERE `recno` = '"
sql = sql & request.form("recno") & "' LIMIT 1 ;"
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

sql3 = "DELETE FROM `shows` WHERE `recno` = " & recno1

Set recTmp = Server.CreateObject ("ADODB.Recordset")
recTmp.Open sql3, SomeDB
else
marque="You do not have the privileges to update or post in this form."
end if
end if
if Request.Form("bsubmit") = "Edit" then

	recno = request.form("managesel")

	if recno <> "" then
	
	sql4 = "SELECT * FROM shows WHERE recno = " & recno
	Set recTmp3 = Server.CreateObject ("ADODB.Recordset")
	recTmp3.Open sql4 , SomeDB
	
	stonerecno = recTmp3("recno")
	stoneitem = "'" &  server.htmlencode(recTmp3("show")) & "'"
	stonedescri = recTmp3("detail")
	else
	Marque = "You have not chosen an item to edit"
	end if
	
end if
%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Shows Management</title>
<script language="javascript" type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas"
});
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<div align="center"><strong><font color="#FF0000"><%=Marque%> </font></strong>
  <table border="0" cellpadding="0" cellspacing="0">
    <tr> 
      <td rowspan="2" valign="top">
<form name="form1" method="post" action="">
          <fieldset>
          <legend><strong><font color="#FF0000">Show</font><font color="#FF0000"> 
          Manager: 
          <%if stonerecno <> "" then%>
          Editing 
          <% else %>
          New 
          <% end if %>
          </font></strong></legend>
          <strong> 
          <input type=hidden name="recno" value=<%=stonerecno%>>
          Add new item:</strong><br />
          Show Date: Month 
          <select name="month11" value=<%=month22%>>
            <option <% if datepart("m",date()) = 1 then %>selected<% end if %>>1</option>
            <option <% if datepart("m",date()) = 2 then %>selected<% end if %>>2</option>
            <option <% if datepart("m",date()) = 3 then %>selected<% end if %>>3</option>
            <option <% if datepart("m",date()) = 4 then %>selected<% end if %>>4</option>
            <option <% if datepart("m",date()) = 5 then %>selected<% end if %>>5</option>
            <option <% if datepart("m",date()) = 6 then %>selected<% end if %>>6</option>
            <option <% if datepart("m",date()) = 7 then %>selected<% end if %>>7</option>
            <option <% if datepart("m",date()) = 8 then %>selected<% end if %>>8</option>
            <option <% if datepart("m",date()) = 9 then %>selected<% end if %>>9</option>
            <option <% if datepart("m",date()) = 10 then %>selected<% end if %>>10</option>
            <option <% if datepart("m",date()) = 11 then %>selected<% end if %>>11</option>
            <option <% if datepart("m",date()) = 12 then %>selected<% end if %>>12</option>
          </select>
          / Day 
          <select name="day11">
            <% 
	   Day1 = 0
	   do until day1 = 31 
	   day1=day1 + 1%>
            <option <% if datepart("d",date()) = day1 then %>selected<% end if %>><%= day1 %></option>
            <% loop %>
          </select>
          /Year 
          <select name="year11">
            <% 
	   year1 = datepart("yyyy",date())
	   year2 = 0
	   do until year2 = 10
	   year2 = year2 + 1
	   %>
            <option <% if year3=year1 then %>selected<%end if%>><%= year1 %></option>
            <%year1=year1 + 1
		   loop %>
          </select>
          <br />
          Show: 
          <input name="StalkItem" type="text"  size="75" maxlength="255" value=<%=stoneitem%>>
          <br />
          Details:<br />
          <textarea name="Descri" cols="75" rows="12" ><%=stonedescri%></textarea>
          <br />
          <input type="submit" name="bsubmit" value="Submit">
          </fieldset>
        </form></td>
      <td valign="top"> <%
	Set recTmp2 = Server.CreateObject ("ADODB.Recordset")
	recTmp2.Open "SELECT * FROM shows ORDER BY showdate DESC", SomeDB
  %> <form name="form2" method="post" action="">
          <fieldset><legend><strong>View/Change Current Items:</strong></legend>
          Recno Added Name<br />
          <select name="managesel" size="10">
            <% do until recTmp2.eof %>
            <option value=<%=recTmp2("recno")%>> 
            <%=left(recTmp2("recno"),8) & " " & left(FormatDateTime(recTmp2("showdate"),2),10) & " " & left(recTmp2("show"),12)%> </option>
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
  
</div>
</body>
</html>
<% 
else 
%>
You either do not have priveledges to this page or you have not logged in. <a href="http://stonegoddess.com/management/default.asp?logout=1">Click here to login.</a>

<%
end if
%>