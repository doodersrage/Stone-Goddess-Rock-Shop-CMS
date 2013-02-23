<?php
define('HOST_ADDRESS','localhost');
define('DB_USERNAME','doode0_stonegodd');
define('DB_NAME','doode0_stonegoddess');
define('DB_PASSWORD','shitface'); 

$connect = mysql_connect(HOST_ADDRESS,DB_USERNAME,DB_PASSWORD) or die("Error connecting to Database! " . mysql_error());
mysql_select_db(DB_NAME, $connect) or die("Cannot select database! " . mysql_error());

// sets store location
define('STORE_DIRECTORY','/home/doode0/public_html/stonegoddess/management/');

define('GALLERY_THUMB_IMAGE_DIR','/home/doode0/public_html/stonegoddess/Stone-Goddess-Gallery/photogallery/photo2477/');
define('GALLERY_IMAGE_DIR','/home/doode0/public_html/stonegoddess/Stone-Goddess-Gallery/images/');

// upload files
function upload_file($directory,$filename) {
$target = $directory . basename( $_FILES[$filename]['name']) ;
move_uploaded_file($_FILES[$filename]['tmp_name'], $directory);

return $_FILES[$filename]['name'];
}

?>