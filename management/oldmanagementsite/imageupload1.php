<html>
<head><title>Upload images to StoneGoddess.com.</title></head>
<body>

<?php
// code that will be executed if the form has been submitted:

if ($submit) {

    // connect to the database
    // (you may have to adjust the hostname,username or password)

    MYSQL_CONNECT("stonegoddess.com","dbadmin","hxznfw12");
    mysql_select_db("stonegoddess_com");

    $data = addslashes(fread(fopen($form_data, "r"), filesize($form_data)));

    $result=MYSQL_QUERY("INSERT INTO binary_data (description,bin_data,filename,filesize,filetype) ".
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
    <br />File to upload/store in database:<br />
    <input type="file" name="form_data"  size="40">
    <p><input type="submit" name="submit" value="submit">
    </form>

<?php

}

?>

</body>
</html>