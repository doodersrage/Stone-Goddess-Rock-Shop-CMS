<?PHP
if ($_SESSION["loginadminokay"] == 1 && ($_SESSION["admin"]== 1 || $_SESSION["admin"] == 2)) { ?>
<?PHP
if ($_POST["bsubmit"] == "Submit") {
if ($_SESSION["admin"] == 1) {
$itemname = trim(str_replace("'", "''",$_POST["StalkItem"]));
$descri =  trim(str_replace("'", "''",$_POST["Descri"]));
$linkname = trim($_POST["linkname"]);

if ($_POST["recno"] == "") {
$sql = "INSERT INTO `StoneTalk` ( `descri` , `itemname` , `file1` , `linkname` ) ";
$sql .= "VALUES ('" . $descri . "', '" . $itemname . "','" . $_POST["file1"] . "', '" . $linkname . "');";
$linkname = "";
} else {
$sql = "UPDATE `StoneTalk` SET `dateadded` = NOW( ) ,";
$sql .= "`descri` = '" . $descri . "',";
$sql .= "`itemname` = '" . $itemname . "', `file1` = '" . $_POST["file1"] . "', `linkname` = '" . $linkname . "' WHERE `recno` = '" . $_POST["recno"] . "' LIMIT 1 ;";
$linkname = "";
}

mysql_query($sql);

} else {
$marque="You do not have proper privileges to update or post in this section.";
} 
}

if ($_POST["bsubmit"] == "Delete") {
if ($_SESSION["admin"] == 1) {
$recno1 = $_POST["managesel"];

$sql3 = "DELETE FROM `StoneTalk` WHERE `recno` = " . $recno1;
mysql_query($sql3);

} else {
$marque="You do not have the privileges to update or post in this form.";
}
}

if ($_POST["bsubmit"] == "Edit") {

	$recno = $_POST["managesel"];
	if (!empty($recno)) {

	$sql4 = "SELECT * FROM StoneTalk WHERE recno = " . $recno;
	$result = mysql_query($sql4);
	$array = mysql_fetch_array($result);
	
	$stonerecno = $array["recno"];
	$stoneitem = $array["itemname"];
	$stonedescri = $array["descri"];
	$linkname = $array["linkname"];
	$file1str = $array["file1"];
	} else {
	$Marque = "You have not chosen an item to edit";
	}
	
}
?>
<style type="text/css">
<!--
.style1 {
	color: #CC3300;
	font-weight: bold;
}
-->
</style>

<div align="center"><strong><font color="#FF0000"><?=$Marque?> </font></strong>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr> 
      <td rowspan="3" valign="top"> <form name="form1" action="" method="post">
          <fieldset>
          <legend><strong><font color="#FF0000">Stone Talk Manager: 
          <?PHP if ($stonerecno != "") { ?>
          Editing 
          <?PHP } else { ?>
          New 
          <?PHP } ?>
          </font></strong></legend>
          <strong> 
          <input type=hidden name="recno" value=<?=$stonerecno?>>
          Add new item:</strong><br />
          Item Name: 
          <input name="StalkItem" type="text" size="75" maxlength="255" value=<?=$stoneitem?>>
          <br />
          <label>Link Name:
          <input type="text" name="linkname" value=<?=$linkname?>>
          </label><br />
          Description:<br />
        <?PHP
		$oFCKeditor = new FCKeditor('Descri') ;
		$oFCKeditor->BasePath = 'fckeditor/' ;
		$oFCKeditor->Height = 400;
		$oFCKeditor->Value = $stonedescri;
		
		$oFCKeditor->Create();
		?>
          <br />
          Image: <strong>
          </strong>
<select name="file1">
            <option></option>
            <?PHP
		$getlistingresult = mysql_query("SELECT * FROM binary_data WHERE description = 'Stone Talk' ORDER BY filename ASC;");
		  while ($getlisting = @mysql_fetch_array($getlistingresult)) {
		  ?>
            <option <?PHP if ($getlisting["filename"] == $file1str) { ?>selected <?PHP } ?>><?=$getlisting["filename"];?></option>
            <?PHP
			 }
			 ?>
          </select>
          <br />
          <input type="submit" name="bsubmit" value="Submit">
          </fieldset>
        </form></td>
      <td valign="top" class="rightclm"> 
   <form name="form2" method="post" action="">
          <fieldset>
          <legend><strong>View/Change Current Items:</strong></legend>
          <table width="100%" border="0" cellpadding="2" cellspacing="0">
            <tr style="background:#CCCCCC">
              <td><span class="style1">Name</span></td>
            </tr>
          </table>
          <select name="managesel" id="managesel" size="12">
            <?PHP 		
			$getlistingresult = mysql_query("SELECT * FROM StoneTalk ORDER BY itemname ASC;");
		    while ($getlisting = @mysql_fetch_array($getlistingresult)) {
 ?>
            <option value=<?=$getlisting{"recno"}?>> 
            <?PHP echo $getlisting["itemname"]; ?> </option>
            <?PHP } ?>
          </select>
          <br />          
		<input type="submit" name="bsubmit" value="Delete" onClick='return confirm("Are you sure you want to delete this item?")'>
		  <input type="submit" name="bsubmit" value="Edit">
          </fieldset>
        </form>
<fieldset>
        <legend><strong>
        Top 10 Viewed</strong></legend>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #000000">
          <tr style="background:#CCCCCC"> 
            <td style="border-bottom:1px solid #000000" align="center"><span class="style1">#</span></td>
            <td style="border-bottom:1px solid #000000" align="center"><span class="style1">Item</span></td>
            <td style="border-bottom:1px solid #000000" align="center"><span class="style1">Views</span></td>
          </tr>
          <?PHP
		$getlistingresult = mysql_query("SELECT * FROM StoneTalk ORDER BY views DESC LIMIT 0,10;");
		  while ($getlisting = @mysql_fetch_array($getlistingresult)) {
		  $Num1 += 1;
		  ?>
		  <tr> 
            <td style="border-left:1px solid #000000; padding-left:5px;"><div align="left"><?=$Num1?>.</div></td>
            <td style="border-left:1px solid #000000; padding-left:5px; padding-right:5px;" ><?=$getlisting["itemname"]?></td>
            <td style="border-left:1px solid #000000; border-right:1px solid #000000; padding-left:5px; padding-right:5px;"><div align="center"><?=$getlisting["views"]?></div></td>
          </tr>
		  <?PHP } ?>
        </table>
</fieldset>      </td>
    </tr>
  </table>
</div>
<?PHP
} else {
?>
You either do not have privileges to this page or you have not logged in. <a href="http://stonegoddess.com/management/?logout=1">Click
here to login.</a>
<?PHP
}
?>