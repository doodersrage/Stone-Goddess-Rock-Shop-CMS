<% 
if Session("loginadminokay") = True and session("admin")= 1 then %>
<%
if Request.Form("bsubmit") = "Submit" then
if session("admin")= 1 then
itemname = replace(request.form("StalkItem"), "'", "''")
descri =  replace(request.form("Descri"), "'", "''")

if request.form("recno") = "" then
sql = "INSERT INTO `storeitems` ( `itemname` , `descri` , `price` , `quantity` , `weight` , `image` , `catagory` ) "
sql = sql & "VALUES ('" & itemname & "', '" & descri & "','" & request.form("price")
sql = sql & "','" & request.form("quantity") & "','" & request.form("weight") & "','" & request.form("image")
sql = sql & "','" & request.form("catagory") & "');" 
else
sql = "UPDATE `storeitems` SET `dateadded` = NOW( ) ,"
sql = sql & "itemname = '" & itemname & "', descri = '" & descri & "', price = '" & request.form("price")
sql = sql & "', quantity = '" & request.form("quantity") & "', weight = '" & request.form("weight") & "', image = '" & request.form("image")
sql = sql & "', catagory = '" & request.form("catagory") & "' WHERE `recno` = '" & request.form("recno") & "' LIMIT 1 ;" 
end if

Set recTmp = Server.CreateObject ("ADODB.Recordset")
recTmp.Open sql, SomeDB, adModeReadWrite

else
marque="You do not have the privileges to update or post in this form."
end if 
end if
if Request.Form("bsubmit") = "Delete" then
if session("admin")= 1 then
recno1 = request.form("managesel")

sql3 = "DELETE FROM `storeitems` WHERE `recno` = " & recno1

Set recTmp = Server.CreateObject ("ADODB.Recordset")
recTmp.Open sql3, SomeDB
else
marque="You do not have the privileges to update or post in this form."
end if
end if
if Request.Form("bsubmit") = "Edit" then

	recno = request.form("managesel")
	
	if recno <> "" then

	sql4 = "SELECT * FROM storeitems WHERE recno = " & recno
	Set recTmp3 = Server.CreateObject ("ADODB.Recordset")
	recTmp3.Open sql4 , SomeDB
	
	stonerecno = recTmp3("recno")
	stoneitem = "'" &  server.htmlencode(recTmp3("itemname")) & "'"
	stonedescri = recTmp3("descri")
	file1str = recTmp3("file1")
	else
	Marque = "You have not chosen an item to edit"
	end if
	
end if
%>
<div align="center">
 <div align="center"><strong><font color="#FF0000"><%=Marque%> </font></strong>
  <table border="0" cellpadding="0" cellspacing="0">
    <tr> 
      <td rowspan="2" valign="top">
<form action="" method="post" name="form1">
          <fieldset>
          <legend><strong><font color="#FF0000">Store Items Manager:
          <%if stonerecno <> "" then%>
Editing
<% else %>
New
<% end if %>
          </font></strong></legend>
          <strong>
          <input type=hidden name="recno" value=<%=stonerecno%>>
          Add new item:</strong><br />
          Item Name: 
          <input type="text" name="StalkItem">
          <br />
          Description:<br />
          <textarea name="Descri" cols="75" rows="10"></textarea>
          <br />
          Price: 
          <input name="price" type="text" size="10" maxlength="10">
          <br />
          Quantity:
          <input name="quantity" type="text" size="10" maxlength="10"><br />
          Weight: 
          <input name="weight" type="text" size="10" maxlength="10">
          <br />
          Upload Image: 
          <input type="file" name="file">
          <br />
          Item Catagory: 
          <select name="catagory">
            <option>miscellaneous</option>
            <option>minerals</option>
            <option>carvings</option>
            <option>jewelry</option>
            <option>fossils</option>
            <option>gallery</option>
            <option>specials</option>
          </select>
          <br />
          <input type="submit" name="bsubmit" value="Submit">
          </fieldset>
        </form></td>
      <td valign="top"> 
                  <%
	Set recTmp2 = Server.CreateObject ("ADODB.Recordset")
	recTmp2.Open "SELECT * FROM storeitems ORDER BY itemname ASC", SomeDB
  %>
		<form name="form2" method="post" action="">
          <fieldset><legend><strong>
          View/Change Current Items:</strong></legend>
          <select name="select" size="10">
		              <% do until recTmp2.eof %>
            <option value=<%=recTmp2("recno")%>> 
            <%=left(recTmp2("recno"),8) & " " & left(FormatDateTime(recTmp2("dateadded"),2),10) & " " & left(recTmp2("itemname"),12)%> </option>
            <% recTmp2.movenext
			loop %>
          </select>
          <br />
          <input type="submit" name="Submit2" value="Delete">
          <input type="submit" name="Submit3" value="Edit">
        </fieldset>
		</form>
		        <%
recTmp2.Close
Set recTmp2 = Nothing
SomeDB.Close
Set SomeDB = Nothing
%>
</td>
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