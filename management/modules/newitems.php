<?PHP
if ($_SESSION["loginadminokay"] == 1 && ($_SESSION["admin"]== 1 || $_SESSION["admin"] == 2)) { ?>
<?PHP
if ($_POST["bsubmit"] == "Submit") {
if ($_SESSION["admin"] == 1) {

$itemname = trim(str_replace("'", "''", $_POST["StalkItem"]));
$descri =  trim(str_replace("'", "''",$_POST["descri"]));

if ($_POST["recno"] == "") {
$sql = "INSERT INTO `NewItems` ( `items` , `itemname`) ";
$sql .= "VALUES ('" . $descri . "', '" . $itemname . "');"; 
} else {
$sql = "UPDATE `NewItems` SET `dateposted` = NOW( ) ,";
$sql .= "`items` = '" . descri . "',";
$sql .= "`itemname` = '" . itemname . "' WHERE `recno` = '" . $_POST["recno"] . "' LIMIT 1 ;";
}

mysql_query($sql);

} else {
$marque="You do not have the privileges to update or post in this form.";
}
}

if ($_POST["bsubmit"] == "Delete") {
if ($_SESSION["admin"] == 1) {
$recno1 = $_POST["managesel"];

$sql3 = "DELETE FROM `NewItems` WHERE `recno` = " . $recno1;

mysql_query($sql3);

} else {
$marque="You do not have the privileges to update or post in this form.";
}
}

if ($_POST["bsubmit"] == "Edit") {

	$recno = $_POST["managesel"];
	if (!empty($recno)) {
	
	$sql4 = "SELECT * FROM NewItems WHERE recno = " . $recno;
	$result = mysql_query($sql4);
	$array = mysql_fetch_array($result);
	
	$stonerecno = $array["recno"];
	$stoneitem = $array["itemname"];
	$stonedescri = $array["items"];
	} else {
	$marque = "You have not chosen an item to edit";
	}
	
}
?>
<div align="center"> <strong><font color="#FF0000"><?=$marque?> </font></strong>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr> 
      <td rowspan="2" valign="top">
<form name="form1" method="post" action="">
          <fieldset>
          <legend><strong><font color="#FF0000">New Items Manager: 
          <?PHP if ($stonerecno != "") { ?>
          Editing 
          <?PHP } else { ?>
          New 
          <?PHP } ?>
          </font></strong></legend>
          <strong> 
          <input type=hidden name="recno" value=<?=$stonerecno?>>
          Add new item:</strong><br />
          Item Title: 
          <input name="StalkItem" type="text" size="75" maxlength="255" value=<?=$stoneitem?>>
          <br />
          Item listings:<br />
        <?PHP
		$oFCKeditor = new FCKeditor('descri') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;
		$oFCKeditor->Height = 400;
		$oFCKeditor->Value = $stonedescri;
		
		$oFCKeditor->Create();
		?>
          <br />
          <input type="submit" name="bsubmit" value="Submit">
          </fieldset>
        </form></td>
      <td valign="top" class="rightclm"> 
	 <form name="form2" method="post" action="">
          <fieldset><legend><strong>View/Change Current Items:</strong></legend>
          Name<br />
          <select name="managesel" size="10">
            <?PHP 
           $getlistingresult = mysql_query("SELECT * FROM NewItems ORDER BY dateposted DESC;");
		  while ($getlisting = @mysql_fetch_array($getlistingresult)) {
		   ?>
            <option value=<?=$getlisting["recno"]?>> 
            <?PHP echo $getlisting["itemname"]; ?> </option>
            <?PHP } ?>
          </select>
          <br />          <input type="submit" name="bsubmit" value="Delete" onClick='return confirm("Are you sure you want to delete this item?")'>
<input type="submit" name="bsubmit" value="Edit">
          </fieldset>
        </form>
 </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</div>
<?PHP
} else {
?>
You either do not have privileges to this page or you have not logged in. <a href="http://stonegoddess.com/management/?logout=1">Click
here to login.</a>
<?PHP
}
?>