<?php 
// Title: PHP Event Calendar
// URL: http://www.softcomplex.com/products/php_event_calendar/
// Version: 1.5.1
// Date: 03/04/2005 (mm/dd/yyyy)
// Tech. support: http://www.softcomplex.com/forum/forumdisplay.php?fid=55
// Notes: Script is free for non commercial use. Visit official site for details.

include 'auth.php';?>
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1">
<tr><td><?php 
if($Update&&$type == 'list'){
	$to=$path_to_data."header_".$calendar->s_calendar_index.".html";
	$calendar->put_in_file($to,$header_file);
	$to=$path_to_data."footer_".$calendar->s_calendar_index.".html";
	$calendar->put_in_file($to,$footer_file);
}
if($Update) {
	foreach($calendar->a_template as $k => $v){
		if(is_array(${$k})) {
			$calendar->a_template[$k] = ${$k};
		}
		else if(isset(${$k})) {
			$calendar->a_template[$k] = stripslashes(${$k});
		}
	}
	foreach($calendar->a_look as $k => $v){
		if(is_array(${$k})) {
			$calendar->a_look[$k] = ${$k};
		}
		else if(isset(${$k})) {
			$calendar->a_look[$k] = stripslashes(${$k});
		}
	}
	foreach($calendar->a_redirect as $k => $v){
		if(is_array(${$k})) {
			$calendar->a_redirect[$k] = ${$k};
		}
		else if(isset(${$k})) {
			$calendar->a_redirect[$k] = stripslashes(${$k});
		}
	}
	foreach($calendar->a_localization as $k => $v){
		if(is_array(${$k})) {
			$calendar->a_localization[$k] = ${$k};
		}
		else if(isset(${$k})) {
			$calendar->a_localization[$k] = stripslashes(${$k});
		}
	}
	$calendar->a_template['timezone'] = $timezones[$timezone][0];
	$calendar->a_template['timezoneID'] = $timezone;
	if(!$is_american) {
		$calendar->a_template['is_american'] = 0;
	}
	if(!$is_vertical) {
		$calendar->a_template['is_vertical'] = 0;
	}
	if(!$show_year) {
		$calendar->a_template['show_year'] = 0;
	}
	if(!$is_show_title) {
		$calendar->a_template['is_show_title'] = 0;
	}
	$calendar->put_config();
	$calendar->save_conf();
	header("Location: index.php?CLd=$CLd&CLm=$CLm&CLy=$CLy&name=$name&type=$type&action=$action&page=$page");
	exit;
}
if($Preview) {
	$s = array_merge($calendar->a_template,$calendar->a_look,$calendar->a_localization);
	foreach($s as $k => $v){
		if(is_array(${$k})) {
			$s[$k] = ${$k};
		}
		else if(isset(${$k})) {
			$s[$k] = stripslashes(${$k});
		}
	}
	$calendar->put_config($s);
	header("Location: index.php?CLd=$CLd&CLm=$CLm&CLy=$CLy&name=$name&type=$type&action=$action&page=$page");
	exit;
}
if($Reset_to_default) {
	$calendar->is_created = true;
	$calendar->reset_default();
	header("Location: index.php?CLd=$CLd&CLm=$CLm&CLy=$CLy&name=$name&type=$type&action=s&page=s&__Created=1");
	exit;
}
if($Reset_to_save) {
	$calendar->is_created = true;
	$calendar->reset_conf($name);
	header("Location: index.php?CLd=$CLd&CLm=$CLm&CLy=$CLy&name=$name&type=$type&action=s&page=s&__Created=1");
	exit;
}
if($Apply) {
	$calendar->is_created = 1;
	foreach($calendar->a_template as $k => $v){
		if(is_array(${$k})) {
			$calendar->a_template[$k] = ${$k};
		}
		else if(isset(${$k})) {
			$calendar->a_template[$k] = stripslashes(${$k});
		}
	}
	foreach($calendar->a_redirect as $k => $v){
		if(is_array(${$k})) {
			$calendar->a_redirect[$k] = ${$k};
		}
		else if(isset(${$k})) {
			$calendar->a_redirect[$k] = stripslashes(${$k});
		}
	}
	foreach($calendar->a_look as $k => $v){
		if(is_array(${$k})) {
			$calendar->a_look[$k] = ${$k};
		}
		else if(isset(${$k})) {
			$calendar->a_look[$k] = stripslashes(${$k});
		}
	}
	foreach($calendar->a_localization as $k => $v){
		if(is_array(${$k})) {
			$calendar->a_localization[$k] = ${$k};
		}
		else if(isset(${$k})) {
			$calendar->a_localization[$k] = stripslashes(${$k});
		}
	}
	$calendar->a_template['timezone'] = $timezones[$timezone][0];
	$calendar->a_template['timezoneID'] = $timezone;
	if(!$is_american) {
		$calendar->a_template['is_american'] = 0;
	}
	if(!$is_show_title) {
		$calendar->a_template['is_show_title'] = 0;
	}
	if(!$is_vertical) {
		$calendar->a_template['is_vertical'] = 0;
	}
	if(!$show_year) {
		$calendar->a_template['show_year'] = 0;
	}
	$calendar->apply_put_config();
	header("Location: index.php?CLd=$CLd&CLm=$CLm&CLy=$CLy&name=$name&type=$type&action=s&page=s&__Created=1");
	exit;
}
$calendar->show_calendar();
?></td></tr></table>