<?php 
// Title: PHP Event Calendar
// URL: http://www.softcomplex.com/products/php_event_calendar/
// Version: 1.5.1
// Date: 03/04/2005 (mm/dd/yyyy)
// Tech. support: http://www.softcomplex.com/forum/forumdisplay.php?fid=55
// Notes: Script is free for non commercial use. Visit official site for details.
?>
<script language=JavaScript src="picker.js"></script>
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
<form name="formp" method="post" action="index.php">
<input type="hidden" name="action" value="s">
<input type="hidden" name="page" value="s">
<input type="hidden" name="Apply">
<tr><td class=header2>General Settings<?php echo help('general')?></td></tr>
<?php 
extract ($calendar->a_template);
extract ($calendar->a_look);
extract ($calendar->a_localization);
extract ($calendar->a_redirect);
?>
<tr> 
<td align="center">
<table width="400" border="0" align="center" cellpadding="4" cellspacing="1">
<tr> 
<td align="right" width="100">Show week numbers</td>
<td> 
<select name="weeks_location" size="1" class="inpt">
<option value="0"<?php if(!$weeks_location) echo " selected"?>>None</option>
<option value="1"<?php if($weeks_location==1) echo " selected"?>>Top/Left</option>
<option value="2"<?php if($weeks_location==2) echo " selected"?>>Bottom/Right</option>
</select></td>
<td width="20"><?php echo help('general')?></td> 
</td></tr>
<tr> 
<td align="right">Days location</td>
<td> 
<select name="days_location" size="1" class="inpt">
<option value="0"<?php if(!$days_location) echo " selected"?>>None</option>
<option value="1"<?php if($days_location==1) echo " selected"?>>Top/Left</option>
<option value="2"<?php if($days_location==2) echo " selected"?>>Bottom/Right</option>
</select></td>
<td><?php echo help('general')?></td> 
</td></tr>
<tr> 
<td align="right">Title format</td>
<td><input type="text" name="title_format" size="9" maxlength="10" value="<?php echo  $title_format?>" class="inpt"></td>
<td><?php echo help('general')?></td> 
</tr>
<tr> 
<td align="right">Time format</td>
<td>
<select name="time_format" size="1" class="inpt">
<option value="1"<?php if($time_format) echo " selected"?>>AM/PM</option>
<option value="0"<?php if(!$time_format) echo " selected"?>>24 H</option>
</select>

</td>
<td><?php echo help('general')?></td> 
</tr>
<tr> 
<td align="right">Show time gradation</td>
<td>
<select name="time_gradation" size="1" class="inpt">
<option value="1"<?php if($time_gradation) echo " selected"?>>Yes</option>
<option value="0"<?php if(!$time_gradation) echo " selected"?>>No</option>
</select>

</td>
<td><?php echo help('general')?></td> 
</tr>
<tr>
<td align="right">Time zone</td>
<td>
<select name="timezone" size="1" class="inpt">
<?php 
foreach($timezones as $k=>$v){?>
	<option value="<?php echo $k?>" <?php echo ($timezoneID==$k)?'selected':''?>><?php echo $v[1]?>,	(GMT <?php echo ($v[0]>0?'+'.$v[0]:$v[0])?>)</option>
<?php }?>
</select>
</td>
<td><?php echo help('general')?></td> 
</tr>
<tr> 
<td align="right">Start of the week</td>
<td>
<select name="is_american" size="1" class="inpt">
<option value="1"<?php if($is_american) echo " selected"?>>American (Sunday)</option>
<option value="0"<?php if(!$is_american) echo " selected"?>>European (Monday)</option>
</select></td>
<td><?php echo help('general')?></td> 
</td></tr>
<tr> 
<td align="right">Year arrows</td>
<td>
<select name="show_year" size="1" class="inpt">
<option value="0"<?php if(!$show_year) echo " selected"?>>Hide</option>
<option value="1"<?php if($show_year) echo " selected"?>>Show</option>
</select></td>
<td><?php echo help('general')?></td> 
</tr>
<tr> 
<td align="right">Geometry</td>
<td>
<select name="is_vertical" size="1" class="inpt">
<option value="1"<?php if($is_vertical) echo " selected"?>>Vertical</option>
<option value="0"<?php if(!$is_vertical) echo " selected"?>>Horizontal</option>
</select>
</td>
<td><?php echo help('general')?></td> 
</tr>
</table>
</td> 
</tr>
<tr><td><img src="/img/pixel.gif" width="1" height="5" border="0"></td></tr>
<!--
<tr><td class=header2>Users Settings<?php echo help('general')?></td></tr>
<tr> 
<td align="center">
<table width="400" border="0" align="center" cellpadding="4" cellspacing="1">
<tr>
<td align="right" width="100">Ability to add events</td>
<td>
<select name="is_user_add" size="1" class="inpt">
<option value="1"<?php if($is_user_add) echo " selected"?>>Can</option>
<option value="0"<?php if(!$is_user_add) echo " selected"?>>Can not</option>
</select>
</td>
<td width="20"><?php echo help('general')?></td> 
</tr>
<tr>
<td align="right">Events limit</td>
<td>
<input type="text" name="event_limit" value="<?php echo (int)$event_limit?>" class="inpt">
</td>
<td><?php echo help('general')?></td> 
</tr>

</table>
</td> 
</tr>
-->
<tr><td><img src="/img/pixel.gif" width="1" height="5" border="0"></td></tr>

<tr><td class="header2">Color Settings<?php echo help('color')?></td></tr>
<tr> 
<td align="right">
<table width="541" border="0" align="center" cellpadding="0" cellspacing="1">
<tr>
	<td width="50">Classes</td>
	<td rowspan="8" width="401"><img src="img/calendar.gif" width="400" height="300" border="0"></td>
	<td colspan="2">Colors</td>
	<td width="1"><img src="/img/pixel.gif" width="1" height="9" border="0"></td>
</tr>
<tr>
	<td><input type="text" name="header_font_color" size="7" value="<?php echo  $header_font_color?>" class="inpt"></td>
	<td width="40"><a href="javascript:TCP.popup(document.forms['formp'].elements['header_bg_color'])"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="img/sel.gif"></a></td>
	<td width="50"><input type="text" name="header_bg_color" size="7" maxlength="7" value="<?php echo  $header_bg_color?>" class="inpt"></td>
	<td width="1"><img src="/img/pixel.gif" width="1" height="20" border="0"></td>
</tr>
<tr>
	<td><input type="text" name="header2_font_color" size="7" value="<?php echo  $header2_font_color?>" class="inpt"></td>
	<td width="1"><a href="javascript:TCP.popup(document.forms['formp'].elements['header2_bg_color'])"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="img/sel.gif"></a></td>
	<td><input type="text" name="header2_bg_color" size="7" maxlength="7" value="<?php echo  $header2_bg_color?>" class="inpt"></td>
	<td width="1"><img src="/img/pixel.gif" width="1" height="20" border="0"></td>
</tr>
<tr>
	<td><input type="text" name="cur_font_color" size="7" value="<?php echo  $cur_font_color?>" class="inpt"></td>
	<td width="1"><a href="javascript:TCP.popup(document.forms['formp'].elements['cur_bg_color'])"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="img/sel.gif"></a></td>
	<td><input type="text" name="cur_bg_color" size="7" maxlength="7" value="<?php echo  $cur_bg_color?>" class="inpt"></td>
	<td width="1"><img src="/img/pixel.gif" width="1" height="20" border="0"></td>
</tr>
<tr>
	<td><input type="text" name="body_font_color" size="7" value="<?php echo  $body_font_color?>" class="inpt"></td>
	<td width="1"><a href="javascript:TCP.popup(document.forms['formp'].elements['body_bg_color'])"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="img/sel.gif"></a></td>
	<td><input type="text" name="body_bg_color" size="7" maxlength="7" value="<?php echo  $body_bg_color?>" class="inpt"></td>
	<td width="1"><img src="/img/pixel.gif" width="1" height="20" border="0"></td>
</tr>
<tr>
	<td><input type="text" name="we_font_color" size="7" value="<?php echo  $we_font_color?>" class="inpt"></td>
	<td width="1"><a href="javascript:TCP.popup(document.forms['formp'].elements['we_bg_color'])"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="img/sel.gif"></a></td>
	<td><input type="text" name="we_bg_color" size="7" maxlength="7" value="<?php echo  $we_bg_color?>" class="inpt"></td>
	<td width="1"><img src="/img/pixel.gif" width="1" height="20" border="0"></td>
</tr>
<tr>
	<td><input type="text" name="bodyh_font_color" size="7" value="<?php echo  $bodyh_font_color?>" class="inpt"></td>
	<td width="1"><a href="javascript:TCP.popup(document.forms['formp'].elements['bodyh_bg_color'])"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="img/sel.gif"></a></td>
	<td><input type="text" name="bodyh_bg_color" size="7" maxlength="7" value="<?php echo  $bodyh_bg_color?>" class="inpt"></td>
	<td width="1"><img src="/img/pixel.gif" width="1" height="20" border="0"></td>
</tr>
<tr>
	<td width="1">&nbsp;</td>
	<td width="1"><a href="javascript:TCP.popup(document.forms['formp'].elements['table_bg_color'])"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="img/sel.gif"></a></td>
	<td><input type="text" name="table_bg_color" size="7" maxlength="7" value="<?php echo  $table_bg_color?>" class="inpt"></td>
	<td width="1"><img src="/img/pixel.gif" width="1" height="20" border="0"></td>
</tr>
</table>
</td>
</tr>
<tr>
	<td class=header2>Table settings</td>
</tr>
<tr> 
<td align="center">
<table border="0" align="center" cellpadding="3" cellspacing="1">
<tr>
	<td width="80" align="right">Cells width:</td>
	<td width="50"><input type="text" name="td_width" size="3" maxlength="3" value="<?php echo  $td_width?>" class="inpt"></td>
	<td width="80" align="right">Cells height:</td>
	<td width="50"><input type="text" name="td_height" size="3" maxlength="3" value="<?php echo  $td_height?>" class="inpt"></td>
	<td width="80" align="right">Cell background image:</td>
	<td width="50"><input type="text" name="def_nonevent_image" value="<?php echo  $def_nonevent_image?>" class="inpt"></td>
	<td width="80" align="right">Cell align:</td>
	<td width="50"><input type="text" name="def_align" value="<?php echo  $def_align?>" class="inpt"></td>
</tr>
<tr>
	<td width="80" align="right">Cell padding:</td>
	<td width="50"><input type="text" name="cell_padding" size="3" maxlength="3" value="<?php echo  $cell_padding?>" class="inpt"></td>
	<td width="80" align="right">Cell spacing:</td>
	<td width="50"><input type="text" name="cell_spacing" size="3" maxlength="3" value="<?php echo  $cell_spacing?>" class="inpt"></td>
	<td width="80" align="right">Cell border:</td>
	<td width="50"><input type="text" name="cell_border" size="3" maxlength="3" value="<?php echo  $cell_border?>" class="inpt"></td>
	<td width="80" align="right">Cell valign:</td>
	<td width="50"><input type="text" name="def_valign" value="<?php echo  $def_valign?>" class="inpt"></td>
</tr>
</table>
</td>
</tr>
<tr>
	<td class=header2>Default eventcell settings</td>
</tr>
<tr> 
<td align="center">
<table border="0" align="center" cellpadding="3" cellspacing="1">
<tr>
	<td width="150" align="right">Background color:</td>
	<td width="50"><input type="text" name="def_event_bgcolor" size="7" maxlength="7" value="<?php echo  $def_event_bgcolor?>" class="inpt"></td>
	<td width="50" align="right">Align:</td>
	<td width="50"><input type="text" name="def_event_align" value="<?php echo  $def_event_align?>" class="inpt"></td>
	<td colspan="2">&nbsp;</td>
</tr><tr>
	<td align="right">Background image:</td>
	<td ><input type="text" name="def_event_image" value="<?php echo  $def_event_image?>" class="inpt"></td>

	<td align="right">Valign:</td>
	<td><input type="text" name="def_event_valign" value="<?php echo  $def_event_valign?>" class="inpt"></td>
	<td align="right">Show title:</td>
	<td><input type="checkbox" name="is_show_title" value="1"<?php if($is_show_title)echo " checked"?>></td>
</tr><tr>
	<td align="right">Open event list at URL:</td>
	<td colspan="5"><input type="text" name="redirect_url" value="<?php echo  $redirect_url?>" class="inpt"></td>
</tr><tr>
	<td align="right">Open event list target:</td>
	<td colspan="5"><input type="text" name="redirect_target" value="<?php echo  $redirect_target?>" class="inpt"></td>
</tr>
</table>

</td>
</tr>
<tr><td class=header2>Localization<?php echo help('localization')?></td></tr>
<tr> 
<td align="center">
<table width="400" border="0" align="center" cellpadding="3" cellspacing="1">
<tr><td colspan="2" align="center">Monthes</td><td colspan="2" align="center">Weekday</td></tr>
<tr>
<td>January</td><td><input type="text" name=months[0] value="<?php echo $months[0]?>" tabindex="10"></td>
<td>Monday</td><td><input type="text" name=days[1] value="<?php echo $days[1]?>" tabindex="22"></td>
</tr>
<tr>
<td>February</td><td><input type="text" name=months[1] value="<?php echo $months[1]?>" tabindex="11"></td>
<td>Tuesday</td><td><input type="text" name=days[2] value="<?php echo $days[2]?>"tabindex="23"></td>
</tr>
<tr>
<td>March</td><td><input type="text" name=months[2] value="<?php echo $months[2]?>" tabindex="12"></td>
<td>Wednesday</td><td><input type="text" name=days[3] value="<?php echo $days[3]?>" tabindex="24"></td>
</tr>
<tr>
<td>April</td><td><input type="text" name=months[3] value="<?php echo $months[3]?>" tabindex="13"></td>
<td>Thursday</td><td><input type="text" name=days[4] value="<?php echo $days[4]?>" tabindex="25"></td>
</tr>
<tr>
<td>May</td><td><input type="text" name=months[4] value="<?php echo $months[4]?>" tabindex="14"></td>
<td>Friday</td><td><input type="text" name=days[5] value="<?php echo $days[5]?>" tabindex="26"></td>
</tr>
<tr>
<td>June</td><td><input type="text" name=months[5] value="<?php echo $months[5]?>" tabindex="15"></td>
<td>Saturday</td><td><input type="text" name=days[6] value="<?php echo $days[6]?>" tabindex="27"></td>
</tr>
<tr>
<td>July</td><td><input type="text" name=months[6] value="<?php echo $months[6]?>" tabindex="16"></td>
<td>Sunday</td><td><input type="text" name=days[0] value="<?php echo $days[0]?>" tabindex="28"></td>
</tr>
<tr>
<td>August</td><td><input type="text" name=months[7] value="<?php echo $months[7]?>" tabindex="17"></td>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td>September</td><td><input type="text" name=months[8] value="<?php echo $months[8]?>" tabindex="18"></td>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td>October</td><td><input type="text" name=months[9] value="<?php echo $months[9]?>" tabindex="19"></td>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td>November</td><td><input type="text" name=months[10] value="<?php echo $months[10]?>" tabindex="20"></td>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td>December</td><td><input type="text" name=months[11] value="<?php echo $months[11]?>" tabindex="21"></td>
<td colspan="2">&nbsp;</td>
</tr>
</table>
</td> 
</tr>
<tr>
<td class="header2" style="padding:1px; text-align:right;">
<input class="btn" type="button" value="Delete Calendar" onclick="dropcalendar('<?php echo  $name?>');" style="color:red">&nbsp;
<input class="btn" type="submit" name="Apply" value="Apply" tabindex="29">&nbsp;
<input class="btn" type="submit" name="Update" value="Save" tabindex="30">&nbsp;
<input class="btn" type="submit" name="Reset_to_save" value="Reset to saved" tabindex="31">&nbsp;
<input class="btn" type="submit" name="Reset_to_default" value="Reset to defaults" tabindex="32">
<input type="hidden" name="name" value="<?php echo  $name?>">
<?php echo help('settings')?>&nbsp;</td>
</tr></form>
<tr><td><img src="/img/pixel.gif" width="1" height="5" border="0"></td></tr>
<form action="index.php" enctype="multipart/form-data" method="post" name="iupload">
<input type="hidden" name="action" value="s">
<input type="hidden" name="page" value="s">
<tr><td class=header2>Arrows settings<?php echo help('arrows')?></td></tr>
<tr> 
<td align="center">
<table width="400" border="0" align="center" cellpadding="3" cellspacing="1">
	<tr>
		<td bgcolor="<?php echo  $header_bg_color?>"><img src="<?php echo $calendar->put_arrows('p')?>" border=0 alt="Previous month" name="pm" id="pm"></td>
		<td>Previous month</td>
		<td><input type="file" name="p" onChange="document.pm.src=document.iupload.p.value"></td>
	</tr>
	<tr>
		<td bgcolor="<?php echo  $header_bg_color?>"><img src="<?php echo $calendar->put_arrows('n')?>" border=0 alt="Next month" name="nm" id="nm"></td>
		<td>Next month</td>
		<td><input type="file" name="n" onChange="document.nm.src=document.iupload.n.value"></td>
	</tr>
	<tr>
		<td bgcolor="<?php echo  $header_bg_color?>"><img src="<?php echo $calendar->put_arrows('py')?>" border=0 alt="Previous year" name="py" id="py"></td>
		<td>Previous year</td>
		<td><input type="file" name="py" onChange="document.py.src=document.iupload.py.value"></td>
	</tr>
	<tr>
		<td bgcolor="<?php echo  $header_bg_color?>"><img src="<?php echo $calendar->put_arrows('ny')?>" border=0 alt="Next year" name="ny" id="ny"></td>
		<td>Next year</td>
		<td><input type="file" name="ny" onChange="document.ny.src=document.iupload.ny.value"></td>
	</tr>
</table>
</td> 
</tr>
<tr>
<td class="header2" style="padding:1px; text-align:right;">
<input class="btn" type="submit" name="upload" value=" Upload ">
<input type="hidden" name="name" value="<?php echo  $name?>">
&nbsp;</td>
</tr>
</form>
</table>
