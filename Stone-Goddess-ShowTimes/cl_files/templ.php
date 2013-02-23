<?php 
// Title: PHP Event Calendar
// URL: http://www.softcomplex.com/products/php_event_calendar/
// Version: 1.5.1
// Date: 03/04/2005 (mm/dd/yyyy)
// Tech. support: http://www.softcomplex.com/forum/forumdisplay.php?fid=55
// Notes: Script is free for non commercial use. Visit official site for details.

include 'auth.php';
extract ($calendar->a_template);
if(!$type)$type='list';
?>
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
<form name="formt" method="post" action="index.php">
<input type="hidden" name="action" value="t">
<input type="hidden" name="page" value="t">
<tr>
	<td class=header2 nowrap width="100%"><b>PHP codes for inserting into your page</b></td>
</tr>
<tr>
<td valign="top">
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>	
		<td width="15%" valign="top"><strong>Main include:</strong><br><small>You should write the following before call any calendar functions.<br>
		</small></td>
		<td width="85%">
		<textarea name="header_file" rows="7" cols="55" class="inpt">&lt;?
error_reporting (E_ALL ^ E_NOTICE);
extract($HTTP_POST_VARS);
extract($HTTP_GET_VARS);
include '<?php echo $calendar->s_FilesDir?>calendar.php';
?&gt;</textarea>
		</td>
	</tr>
	</table>
</td>
</tr>
<tr>
<td valign="top">
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>	
		<td width="15%" valign="top"><strong>Show current (<?php echo $calendar->s_calendar_index?>) calendar:</strong><br><small>You can write the following to dispaly calendar grid.<br>
		</small></td>
		<td width="85%">
		<textarea name="header_file" rows="4" cols="55" class="inpt">&lt;?
new calendar('<?php echo $calendar->s_calendar_index?>');
?&gt;</textarea>
		</td>
	</tr>
	</table>
</td>
</tr>
<tr>
<td valign="top">
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>	
		<td width="15%" valign="top"><strong>Show events list for current (<?php echo $calendar->s_calendar_index?>) calendar:</strong><br><small>You can write the following to display events list.<br>
		</small></td>
		<td width="85%">
		<textarea name="header_file" rows="5" cols="55" class="inpt">&lt;?
$calendar->init('<?php echo $calendar->s_calendar_index?>');
$calendar->show_event();
?&gt;</textarea>
		</td>
	</tr>
	</table>
</td>
</tr>
<tr>
	<td class=header2 nowrap width="100%"><b>Event List Header Template</b><?php echo help('browse_template')?>
	</td>
</tr>
<tr>
<td valign="top">
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>	
		<td width="15%" valign="top"><strong>Header :</strong><br><small>You can use the following variables in the tamplate:<br>
		$date - event date<br>
		</small></td>
		<td width="85%">
		<textarea name="header_file" rows="10" cols="55" class="inpt"><?php echo htmlentities($calendar->read_file('header','.html'));?>
		</textarea>
		</td>
	</tr>
	</table>
</td>
</tr>
<tr>
<td valign="top">
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>	
		<td width="15%" valign="top"><b>Event entry :</b><br><small>You can use the following variables in the tamplate:<br>
		$num - event number<br>
		$title - event title<br>
		$body - event body<br>
		$time - event time
		</small></td>
		<td width="85%">
		<textarea name="event_list_templ" rows="7" cols="55" class="inpt"><?php echo htmlentities($event_list_templ)?></textarea>
		</td>
	</tr>
	</table>
</td>
</tr>
<tr>
<td valign="top" width="100%">
	<table cellpadding="0" cellspacing="0" width="100%" border="0">
	<tr>	
		<td width="15%" valign="top"><strong>Footer :</strong></td>
		<td width="85%">
		<textarea name="footer_file" rows="5" cols="55" class="inpt"><?php echo  htmlentities($calendar->read_file('footer','.html'));?></textarea>
		</td>
	</tr>
	</table>
</td>
</tr>
<tr><td class="header2" align="right" style="padding:1px; text-align:right;"><input type="submit" name="Update" value=" Update " class="btn"></td>
</tr>

<input type="hidden" name="name" value="<?php echo  $name?>">
<input type="hidden" name="type" value="<?php echo  $type?>">
</form>
</table>