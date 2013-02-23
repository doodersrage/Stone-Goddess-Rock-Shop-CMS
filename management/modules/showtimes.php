<?PHP
if ($_SESSION["loginadminokay"] == 1 && ($_SESSION["admin"]== 1 || $_SESSION["admin"] == 2)) { ?>
<?PHP
if ($_POST["bsubmit"] === "Submit") {
if ($_SESSION["admin"] == 1) {

$itemname = trim(str_replace("'", "''", $_POST["StalkItem"]));
$descri =  trim(str_replace("'", "''", $_POST["descri"]));
$month22 = $_POST["month11"];
$day2 = $_POST["day11"];
$year3 = $_POST["year11"];

if (empty($_POST["recno"])) {
$sql = "INSERT INTO `shows` ( `showdate` , `detail` , `show`) ";
$sql .= "VALUES ('" . $year3 . "-" . $month22 . "-" . $day2 . "', '" . $descri . "', '" . $itemname . "');";
} else {
$sql = "UPDATE `shows` SET `showdate` = NOW( ) ,";
$sql .= "`detail` = '" . $descri . "',`showdate` = '" . $year3 . "-" . $month22 . "-" . $day2 . "',";
$sql .= "`show` = '" . $itemname . "' WHERE `recno` = '";
$sql .= $_POST["recno"] . "' LIMIT 1 ;";
}

mysql_query($sql);

} else {
$marque="You do not have the privileges to update or post in this form.";
}
}

if ($_POST["bsubmit"] === "Delete") {
if ($_SESSION["admin"] == 1) {
$recno1 = $_POST["managesel"];

$sql3 = "DELETE FROM `shows` WHERE `recno` = " . $recno1;

mysql_query($sql3);

} else {
$marque="You do not have the privileges to update or post in this form.";
}
}

if ($_POST["bsubmit"] === "Edit") {

	$recno = $_POST["managesel"];
	if (!empty($recno)) {
	
	$sql4 = "SELECT * FROM shows WHERE recno = " . $recno;
	$result = mysql_query($sql4);
	$array = mysql_fetch_array($result);
	
	$stonerecno = $array["recno"];
	$stoneitem = $array["show"];
	$stonedescri = $array["detail"];
	} else {
	$marque = "You have not chosen an item to edit";
	}
	
}
?>
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
<div align="center"><strong><font color="#FF0000"><?PHP echo $marque; ?> </font></strong>
  <table border="0" cellpadding="0" cellspacing="0">
    <tr> 
      <td rowspan="2" valign="top">
<form name="form1" method="post" action="">
          <fieldset>
          <legend><strong><font color="#FF0000">Show</font><font color="#FF0000"> 
          Manager: 
          <?PHP if (!empty($stonerecno)) { ?>
          Editing 
          <?PHP } else { ?>
          New 
          <?PHP } ?>
          </font></strong></legend>
          <strong> 
          <input type=hidden name="recno" value=<?PHP echo $stonerecno; ?>>
          Add new item:</strong><br />
          Show Date: Month 
          <select name="month11" value=<?PHP echo $month22; ?>>
            <option <?PHP if (date("m") == 1) { ?>selected<?PHP } ?>>1</option>
            <option <?PHP if (date("m") == 2) { ?>selected<?PHP } ?>>2</option>
            <option <?PHP if (date("m") == 3) { ?>selected<?PHP } ?>>3</option>
            <option <?PHP if (date("m") == 4) { ?>selected<?PHP } ?>>4</option>
            <option <?PHP if (date("m") == 5) { ?>selected<?PHP } ?>>5</option>
            <option <?PHP if (date("m") == 6) { ?>selected<?PHP } ?>>6</option>
            <option <?PHP if (date("m") == 7) { ?>selected<?PHP } ?>>7</option>
            <option <?PHP if (date("m") == 8) { ?>selected<?PHP } ?>>8</option>
            <option <?PHP if (date("m") == 9) { ?>selected<?PHP } ?>>9</option>
            <option <?PHP if (date("m") == 10) { ?>selected<?PHP } ?>>10</option>
            <option <?PHP if (date("m") == 11) { ?>selected<?PHP } ?>>11</option>
            <option <?PHP if (date("m") == 12) { ?>selected<?PHP } ?>>12</option>
          </select>
          / Day 
          <select name="day11">
            <?
	   for ($day1 = 0; $day1 <= 31; $day1++) { ?>
           <option <?PHP if (date("d") == $day1) { ?>selected<?PHP } ?>><?PHP echo $day1; ?></option>
            <?PHP } ?>
          </select>
          /Year 
          <select name="year11">
            <?PHP
	   $year1 = date("Y");
	   for ($year2 = 0;$year2 <= 10; $year2++) {
	   $year1 = date("Y") + $year2;
	   ?>
            <option <?PHP if ($year3==$year1) { ?>selected<?PHP } ?>><?PHP echo $year1; ?></option>
            <?PHP } ?>
          </select>
          <br />
          Show: 
          <input name="StalkItem" type="text"  size="75" maxlength="255" value=<?PHP echo $stoneitem; ?>>
          <br />
          Details:<br />
          <textarea name="Descri" cols="75" rows="12" ><?PHP echo $stonedescri; ?></textarea>
          <br />
          <input type="submit" name="bsubmit" value="Submit">
          </fieldset>
        </form></td>
      <td valign="top"> 
      <form name="form2" method="post" action="">
          <fieldset><legend><strong>View/Change Current Items:</strong></legend>
          Recno Added Name<br />
          <select name="managesel" size="10">
		  <?PHP $show_query = mysql_query("SELECT * FROM shows ORDER BY showdate DESC"); ?> 
		  <?PHP while ($getlisting = @mysql_fetch_array($show_query)) { ?>
            <option value=<?PHP echo $getlisting["recno"]; ?>>
            <?PHP echo substr($getlisting["recno"],0,8) . " " . substr($getlisting["showdate"],0,10) . " " . substr($getlisting["show"],0,12); ?> </option>
            <?PHP } ?>
          </select>
          <br />          <input type="submit" name="bsubmit" value="Delete" onClick='return confirm("Are you sure you want to delete this item?")'>
<input type="submit" name="bsubmit" value="Edit">
          </fieldset>
        </form>
 </td>
    </tr>
  </table>
  
</div>
</body>
</html>
<?PHP
} else {
?>
You either do not have privileges to this page or you have not logged in. <a href="http://stonegoddess.com/management/?logout=1">Click
here to login.</a>
<?PHP
}
?>