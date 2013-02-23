<?php
// database login info
define('HOST_ADDRESS','localhost');
define('DB_USERNAME','doode0_stonegodd');
define('DB_NAME','doode0_stonegoddess');
define('DB_PASSWORD','shitface'); 

$connect = mysql_connect(HOST_ADDRESS,DB_USERNAME,DB_PASSWORD) or die("Error connecting to Database! " . mysql_error());
mysql_select_db(DB_NAME, $connect) or die("Cannot select database! " . mysql_error());

// sets store location
define('STORE_DIRECTORY','/home/doode0/public_html/stonegoddess/');

// google analytics account code
define('GOOGLE_ANALYTICS_ACC','UA-622084-1');

?>