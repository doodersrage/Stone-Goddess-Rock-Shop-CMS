<?php 
class db_access {
	var $items=array();
	var $events_file;
	var $events_map_file;
	function put_data($data, $to){
		if($fp = @fopen($to, 'w+')) {
			fwrite($fp, serialize($data));
			fclose($fp);
		}
		else echo "Can't create $to file.<br>Please, check permissions. For more details see <a href='http://www.softcomplex.com/products/php_event_calendar/http://www.softcomplex.com/products/php_event_calendar/docs/index.html#installation'>Installation Instructions</a></b><br>";
	}
}
$db = new db_access();
?>