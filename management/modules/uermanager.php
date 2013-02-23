<?PHP
if ($_SESSION["loginadminokay"] == 1 && ($_SESSION["admin"]== 1)) { ?>
<?PHP
if ($_POST["bsubmit"] === "Submit") {

if (!empty($_POST["recno"])) {

	$fname = $_POST["fname"];
	$mi = $_POST["mi"];
	$lname = $_POST["lname"];
	$address1 = $_POST["address1"];
	$address2 = $_POST["address2"];
	$city = $_POST["city"];
	$state12 = $_POST["state"];
	$zip = $_POST["zip"];
	
	$born = date("Y",$_POST["born"]) . "-" . date("m",$_POST["born"]) . "-" . date("d",$_POST["born"]);
	
	$email1 = $_POST["email1"];
	$username = $_POST["username"];
	$password = $_POST["password1"];
	$admin = $_POST["admin"];
	
if ($admin == "Yes") $admin = 1;
if ($admin == "No") $admin = 0;

$sql = "UPDATE `users` SET ";
$sql .= "`fname` = '" . $fname . "',`mi` = '" . $mi . "',`lname` = '" . $lname . "',`address1` = '" . $address1 . "',";
$sql .= "`address2` = '" . $address2 . "',`city` = '" . $city . "',`state1` = '" . $state12 . "',";
$sql .= "`zip` = '" . $zip . "',`born` = '" . $born . "',`emailaddr` = '" . $email1 . "',";
$sql .= "`username` = '" . $username . "',`password` = '" . $password . "',`admin` = '" . $admin . "'";
$sql .= " WHERE `recno` = '" . $_POST["recno"] . "' LIMIT 1 ;";

mysql_query($sql);

	$fname = "";
	$mi = "";
	$lname = "";
	$address1 = "";
	$address2 = "";
	$city = "";
	$state12 = "";
	$zip = "";
	$born = "";
	$email1 = "";
	$username = "";
	$password = "";
	$admin = 0;

$marque = "Account has been updated";
} else {
$marque = "you have not selected an account to edit yet";
}

}
if ($_POST["bsubmit"] === "Delete") {

$recno1 = $_POST["managesel"];

$sql3 = "DELETE FROM `users` WHERE `recno` = " . $recno1;

mysql_query($sql3);
}
if ($_POST["bsubmit"] === "Edit") {

	$recno = $_POST["managesel"];

	if (!empty($recno)) {

	$sql4 = "SELECT * FROM users WHERE recno = " . $recno;
	$result = mysql_query($sql4);
	$array = mysql_fetch_array($result);
	
	$stonerecno = $array["recno"];
	$fname = $array["fname"];
	$mi = $array["mi"];
	$lname = $array["lname"];
	$address1 = $array["address1"];
	$address2 = $array["address2"];
	$city = $array["city"];
	$state12 = $array["state1"];
	$zip = $array["zip"];
	$born = $array["born"];
	$email1 = $array["emailaddr"];
	$username = $array["username"];
	$password = $array["password"];
	$admin = $array["admin"];
	} else {
	$marque = "You have not chosen an item to edit";
	}
	
}
?>
<div align="center"></div>
<div align="center"><?PHP echo $marque; ?></div>
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
                <input type=hidden name="recno" value=<?PHP echo $stonerecno; ?>>
                </strong> <br />
              </div></td>
            <td valign="top"> First: 
              <input name="fname" type="text" size="15" maxlength="25" value=<?PHP echo $fname; ?>>
              MI: 
              <input name="mi" type="text" size="2" maxlength="2" value=<?PHP echo $mi; ?>>
              Last: 
              <input name="lname" type="text" size="15" maxlength="25" value=<?PHP echo $lname; ?>> 
            </td>
          </tr>
          <tr> 
            <td valign="top">
<div align="right">Address1: </div></td>
            <td valign="top">
<input name="address1" type="text" maxlength="50" value=<?PHP echo $address1; ?>></td>
          </tr>
          <tr> 
            <td valign="top">
<div align="right">Address2: </div></td>
            <td valign="top">
<input name="address2" type="text" maxlength="50" value=<?PHP echo $address2; ?>></td>
          </tr>
          <tr> 
            <td valign="top">
<div align="right">City: </div></td>
            <td valign="top">
<input name="city" type="text" size="15" maxlength="25" value=<?PHP echo $city; ?>>
              State: 
              <input name="state" type="text" size="2" maxlength="2" value=<?PHP if (!empty($state12)) echo $state12; ?>>
              Zip: 
              <input name="zip" type="text" size="10" maxlength="10" value=<?PHP echo $zip; ?>> 
            </td>
          </tr>
          <tr> 
            <td valign="top">
<div align="right">Born: </div></td>
            <td valign="top">
<input type="text" name="born" value=<?PHP echo $born; ?>></td>
          </tr>
          <tr> 
            <td valign="top">
<div align="right">Email Address: 
              </div></td>
            <td valign="top">
<input name="email1" type="text" maxlength="255" value=<?PHP echo $email1; ?>></td>
          </tr>

          <tr> 
            <td valign="top">
<div align="right">User Name: </div></td>
            <td valign="top">
<input name="username" type="text" maxlength="25" value=<?PHP echo $username; ?>></td>
          </tr>
          <tr> 
            <td valign="top">
<div align="right">Password: </div></td>
            <td valign="top">
<input name="password1" type="text" maxlength="25" value=<?PHP echo $password; ?>></td>
          </tr>
          <tr> 
            <td valign="top">
<div align="right"><font color="#FF0000">Admin?:</font></div></td>
            <td valign="top">
<select name="admin">
			<option <?PHP if ($admin == 0) { ?> selected> <?PHP } else { ?> > <?PHP } ?>No</option>
			<option <?PHP if ($admin == 1) { ?> selected> <?PHP } else { ?> > <?PHP } ?>Yes</option>
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
          <fieldset><legend><strong>View/Change Current Items:</strong></legend>
        Fname Lname<br />
        <select name="managesel" size="7">
          <?PHP	
          $list_sql = mysql_query("SELECT * FROM users ORDER BY Lname ASC");
		  while ($getlisting = @mysql_fetch_array($list_sql)) { ?>
          <option value=<?PHP echo $getlisting["recno"]; ?>> 
          <?PHP echo substr($getlisting["fname"],0,10) . " " . substr($getlisting["lname"],0,12); ?> </option>
          <?PHP } ?>
        </select>
        <br />          
		<input type="submit" name="bsubmit" value="Delete" onClick='return confirm("Are you sure you want to delete this item?")'>
<input type="submit" name="bsubmit" value="Edit">
        </fieldset>
      </form></td>
  </tr>
</table>
<?PHP
} else {
?>
You either do not have privileges to this page or you have not logged in. <a href="http://stonegoddess.com/management/?logout=1">Click
here to login.</a>
<?PHP
}
?>