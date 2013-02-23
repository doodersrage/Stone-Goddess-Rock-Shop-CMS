<?PHP
echo $_POST["bsubmit"];
if ($_SESSION["loginadminokay"] == 1 && ($_SESSION["admin"]== 1 || $_SESSION["admin"] == 2)) { ?>
<?PHP

if ($_GET["S"] == 1 && $_SESSION["admin"]== 1) {

$itemname = str_replace("'", "''", $_POST["image"]);

if (empty($_POST["recno"])) {

$target = GALLERY_THUMB_IMAGE_DIR . basename( $_FILES['thumbimg']['name']) ;
$thumbimg = basename( $_FILES['thumbimg']['name']);
move_uploaded_file($_FILES['thumbimg']['tmp_name'], $target);

$target = GALLERY_IMAGE_DIR . basename( $_FILES['image']['name']) ;
$image = basename( $_FILES['image']['name']);
move_uploaded_file($_FILES['image']['tmp_name'], $target);

$sql = "INSERT INTO `gallery` ( `catagory` , `thumbimage` , `image`) ";
$sql .= "VALUES ('" . $image . "', '" . $thumbimg . "', '" . $image . "');";
} else {

$target = GALLERY_THUMB_IMAGE_DIR . basename( $_FILES['thumbimg']['name']) ;
$thumbimg = basename($_FILES['thumbimg']['name']);
move_uploaded_file($_FILES['thumbimg']['tmp_name'], $target);

$target = GALLERY_IMAGE_DIR . basename( $_FILES['image']['name']) ;
$image = basename( $_FILES['image']['name']);
move_uploaded_file($_FILES['image']['tmp_name'], $target);

$sql = "UPDATE `gallery` SET `dateadded` = NOW( ) ,";
$sql .= "`catagory` = '" . $image. "',";
$sql .= "`thumbimage` = '" . $thumbimg . "',`image` = '" . $image . "' WHERE `recno` = '" . $_POST["recno"] . "' LIMIT 1 ;";
}

mysql_query($sql);

} elseif ($_SESSION["admin"]== 2) {
$marque="You do not have the privileges to update or post in this form.";
}
if ($_POST["bsubmit"] == "Delete" && $_SESSION["admin"]== 1) {

$recno1 = $_POST["managesel"];

$sql3 = "DELETE FROM `gallery` WHERE `recno` = " . $recno1;

mysql_query($sql3);

} elseif ($_SESSION["admin"]== 2) {
$marque="You do not have the privileges to update or post in this form.";
}

if ($_POST["bsubmit"] === "Edit") {

	$recno = $_POST["managesel"];
	
	if (!empty($recno)) {

	$sql4 = "SELECT * FROM gallery WHERE recno = " . $recno;
	$gallery_query = mysql_query($sql4);
	$array = mysql_fetch_array($gallery_query);
	
	$stonerecno = $array["recno"];
	$stoneitem = $array["catagory"];
	$thumbimg1 = $array["thumbimage"];
	$image1 = $array["image"];
	
	} else {
	$marque = "You have not chosen an item to edit";
	}
	
}
?>
<div align="center"><strong><font color="#FF0000"><?PHP echo $marque; ?> </font></strong>
  <table border="0" cellpadding="0" cellspacing="0">
    <tr> 
      <td rowspan="2" valign="top">
<form enctype="multipart/form-data" action="http://www.stonegoddess.com/management/?P=7&S=1" method="post" name="form1">
          <fieldset>
          <legend><strong><font color="#FF0000">Gallery 
          Manager: </font><font color="#FF0000">
          <?PHP if (!empty($stonerecno)) { ?>
          Editing 
          <?PHP } else { ?>
          New 
          <?PHP } ?>
          </font></strong></legend>
          <strong> 
          <input type=hidden name="recno" value=<?PHP echo $stonerecno; ?>>
          Add new item:</strong><br />
<!--          Thumbnail image:
          <?PHP if (!empty($thumbimg1)) { ?><br>Current Image: <?PHP echo $thumbimg1; ?><br><?PHP } ?>
          <input type="file" name="thumbimg">         
          <br />--> 
          Image:
          <?PHP if (!empty($image1)) { ?><br>Current Image: <?PHP echo $image1; ?><br><?PHP } ?>
          <input type="file" name="image">
          <br />
          <input type="submit" name="Submit" value="Submit">
          </fieldset>
        </form></td>
      <td valign="top"> 
        <?PHP
	$gallery_list_query = mysql_query("SELECT * FROM gallery ORDER BY dateadded DESC");
  ?> <form name="form2" method="post" action="http://www.stonegoddess.com/management/?P=7">
          <fieldset><legend><strong>View/Change Current Items:</strong></legend>
          Recno Added Name<br />
          <select name="managesel" size="10">
            <?PHP while ($list_array = mysql_fetch_array($gallery_list_query)) { ?>
            <option value=<?PHP echo $list_array["recno"]; ?>> 
            <?PHP echo substr($list_array["recno"],0,8) . " " . substr($list_array["dateadded"],0,10) . " " . substr($list_array["image"],0,12); ?> </option>
            <?PHP } ?>
          </select>
          <input type="hidden" name="confirm" value="condel">
          <br />         
          <input type="submit" name="bsubmit" value="Delete" onClick='return confirm("Are you sure you want to delete this item?")'>
          </fieldset>
        </form>
         </td>
    </tr>
  </table>
</div>
<?PHP 
} else {
?>
You either do not have priveledges to this page or you have not logged in. <a href="http://stonegoddess.com/management/?logout=1">Click here to login.</a>

<?PHP
}
?>