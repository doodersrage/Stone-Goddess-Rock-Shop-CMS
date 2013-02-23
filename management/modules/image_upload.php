<?PHP
if ($_SESSION["loginadminokay"] == 1 && ($_SESSION["admin"]== 1 || $_SESSION["admin"] == 2)) { ?>
<?php

if (!empty($_POST['delete'])) {
mysql_query("DELETE FROM binary_data WHERE id = '".$_POST['current_images']."';");
}

// code that will be executed if the form has been submitted:

if (!empty($_POST['new_image'])) {

    // connect to the database
    // (you may have to adjust the hostname,username or password)

//    MYSQL_CONNECT("stonegoddess.com","dbadmin","hxznfw12");
//    mysql_select_db("stonegoddess_com");

    $data = addslashes(fread(fopen($form_data, "r"), filesize($form_data)));

    $result=mysql_query("INSERT INTO binary_data (description,bin_data,filename,filesize,filetype) ".
        "VALUES ('$form_description','$data','$form_data_name','$form_data_size','$form_data_type')");

    $id= mysql_insert_id();
    print "Image has been uploaded.";

    MYSQL_CLOSE();

} else {

    // else show the form to submit new data:
?>

<form method="post" action="<?php echo $PHP_SELF; ?>" enctype="multipart/form-data">
  Website Section:
  <select name="form_description">
    <option>Stone Talk</option>
    <option>NewsLetter</option>
    <option>New Items</option>
    <option>Show Times</option>
    <option>Store Items</option>
    <option>Gallery</option>
  </select>
  <br />
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
    <input type="hidden" name="new_image" value="1">
    <br />File to upload/store in database:<br />
    <input type="file" name="form_data"  size="40">
    <p><input type="submit" name="submit" value="submit">
</form>

<?php

}

?>
<form action="<?php echo $PHP_SELF; ?>" method="post" name="delete_form">
Delete existing images?
<input type="hidden" name="delete" id="delete" value="1" />
<br />
<select name="current_images" size="10">
<?PHP 		
$getlistingresult = mysql_query("SELECT id, filename, filesize, filetype FROM binary_data ORDER BY filename ASC;");
while ($getlisting = @mysql_fetch_array($getlistingresult)) {
echo '<option value="'.$getlisting['id'].'">'.$getlisting['filename'].'</option>';
}
?>
</select><br />
<input name="Delete" type="button" value="Delete" />
</form>
<?PHP
} else {
?>
You either do not have privileges to this page or you have not logged in. <a href="http://stonegoddess.com/management/?logout=1">Click
here to login.</a>
<?PHP
}
?>