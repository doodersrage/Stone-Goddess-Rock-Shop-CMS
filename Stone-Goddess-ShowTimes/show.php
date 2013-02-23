<?php 
extract($HTTP_POST_VARS);
extract($HTTP_GET_VARS);
include 'cl_files/calendar.php';
$calendar->init($c_num);
$calendar->show_event();
?>