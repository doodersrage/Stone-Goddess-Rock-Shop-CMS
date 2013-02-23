<?php 
// Title: PHP Event Calendar
// URL: http://www.softcomplex.com/products/php_event_calendar/
// Version: 1.5.1
// Date: 03/04/2005 (mm/dd/yyyy)
// Tech. support: http://www.softcomplex.com/forum/forumdisplay.php?fid=55
// Notes: Script is free for non commercial use. Visit official site for details.

$events->load_item();
if($up) {
	$events->item_up($CLd, $CLm, $CLy, ($up-1));
	header("Location: index.php?CLd=$CLd&CLm=$CLm&CLy=$CLy&name=$name&type=$type&action=$action");
	exit;
}
if($down) {
	$events->item_down($CLd, $CLm, $CLy, ($down-1));
	header("Location: index.php?CLd=$CLd&CLm=$CLm&CLy=$CLy&name=$name&type=$type&action=$action");
	exit;
}
if($cane) {
	unset($edit);
	header("Location: index.php?CLd=$CLd&CLm=$CLm&CLy=$CLy&name=$name&type=$type&action=$action&err='Field Title and Body must be have value'");
	exit;
}
?>
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
<form name="choosetype" method="get" action="index.php">
<input type="hidden" name="page" value=<?php echo  $page?>>
<input type="hidden" name="action" value=<?php echo  $action?>>
<input type="hidden" name="CLd" value="<?php echo  $CLd?>">
<input type="hidden" name="CLm" value="<?php echo  $CLm?>">
<input type="hidden" name="CLy" value="<?php echo  $CLy?>">
<tr>
	<th class="header2" width="100%" colspan="2">Choose action on date click<?php echo help('events')?>
	</th>
</tr>
<?php if(!$type&&$events->read_item($CLd,$CLm,$CLy,'url')) {
	$type='url';
}?>
<tr>
	<td valign="top" colspan="2">
	<select name="type" class="inpt" onchange="document.choosetype.submit();">
	<option value="list" <?php echo ($type == 'list' ? " selected" : '')?>>Event list</option>
	<option value="url" <?php echo ($type == 'url' ? " selected" : '')?>>Redirect to custom URL</option>
	</select>
	</td>
</tr>
<tr><td colspan=2><img src="/img/pixel.gif" width="1" height="5" border="0"></td></tr>
<input type="hidden" name="name" value="<?php echo  $name?>">
</form>
</table>
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
<?php 

if($type != 'url'){?>
<form method="post" action="index.php" name="doit">
<input type="hidden" name="CLd" value="<?php echo  $CLd?>">
<input type="hidden" name="CLm" value="<?php echo  $CLm?>">
<input type="hidden" name="CLy" value="<?php echo  $CLy?>">
<input type="hidden" name="id" value="<?php echo  $id?>">
<input type="hidden" name="show_type" value="<?php echo  $show_type?>">
<input type="hidden" name="name" value="<?php echo  $name?>">
<input type="hidden" name="action" value="e">
<input type="hidden" name="edit">
<input type="hidden" name="dele">
<input type="hidden" name="up">
<input type="hidden" name="down">
<tr>
<td class="header2" colspan=5 bgcolor="#dbeaf5"><b>Event List</b><?php echo help('events_editor')?></td>
</tr>
<tr><td>
<?php 
$types = array('Day','Week','Month','Year');
$show_type = (int)$show_type;
if(!$show_type || $show_type < 0)$show_type = 1;
if($show_type > 4)$show_type = 4;
foreach($types as $k=>$v){
	if(($k + 1) != $show_type) $t_nav[] = '<a href="#" onclick="javascript:document.doit.show_type.value = '.($k+1).';document.doit.submit();return false">'.$v.'</a>';
	else $t_nav[] = $v;
}
echo join(" | ",$t_nav);
?>
</td></tr>
<tr><td>
<?php $calendar->show_admin($show_type)?>
</td></tr>
</form>
</table><br>
<?php if($show_type == 1){?>
<script language="JavaScript">
<!--
var n_x,n_y;

function show_bar(n_id){
	document.forms['up'].repeat.value = n_id;
	var a_e_bar=[],a_e_control=[],bars = ['none','day','week','month','year'];
	for(i in bars){
		a_e_bar[i] = get_element(bars[i]);
		a_e_control[i] = get_element('control_'+bars[i]);
	}
	var c;
	if(a_e_bar[n_id].style){
		for(i in a_e_bar) a_e_bar[i].style.visibility = 'hidden';
		for(i in a_e_control) a_e_control[i].style.background = '#ffffff';
		a_e_bar[n_id].style.left = n_x;
		a_e_bar[n_id].style.top = n_y;
		a_e_bar[n_id].style.visibility= 'visible';
		a_e_control[n_id].style.backgroundColor = '#DBEAF5';
	}else{
		for(i in a_e_bar) a_e_bar[i].visibility = 'hide';
		a_e_bar[n_id].left = n_x;
		a_e_bar[n_id].top = n_y;
		a_e_bar[n_id].visibility = 'show';
	}
return false;
}
function check (obj,v){
	var o_f,c = '',o = obj.value*1;
	if(isNaN(o) || o < 0) obj.value = 0;
	else if(o > v) obj.value = v;
	else obj.value = o;
	var o_form = document.forms['up']
	var o_ = o_form.elements['is_time'];
	for(i = 0;i < o_.length;i++){
		c+=o_[i]+'<-'+i+"\n";
		if(o_[i].value==1) o_[i].checked=true;
	}
}
// -->
</script>
<table width="100%" border="0" cellpadding="4" cellspacing="1">
<script language="JavaScript">
	function include_data(o){
		switch(o.elements['repeat'].value*1){
			case 1:
				var o_form = document.forms['form_day'];
				o.elements['every_day'].value = o_form.elements['every_day'].value;
				o.elements['e_date'].value = o_form.elements['e_date'].value;
				break;
			case 2:
				var o_form = document.forms['form_week'];
				o.elements['every_week'].value = o_form.elements['every_week'].value;
				o.elements['e_date'].value = o_form.elements['e_date'].value;
				o.elements['week_days_csv'].value = o_form.elements['week_days_csv'].value;
				o.elements['week_days_txt'].value = o_form.elements['week_days_txt'].value;
				break;
			case 3:
				alert(3);
				var o_form = document.forms['form_month'];
				o.elements['every_month'].value = o_form.elements['every_month'].value;
				o.elements['e_date'].value = o_form.elements['e_date'].value;
				break;
			case 4:
				var o_form = document.forms['form_year'];
				o.elements['every_year'].value = o_form.elements['every_year'].value;
				o.elements['e_date'].value = o_form.elements['e_date'].value;
				break;
		}
		return true;
	}
</script>
<?php if(($a_groups[$__SESSION__['group']]['ev_edit'] && $edit) || $a_groups[$__SESSION__['group']]['ev_add']){?>
<form method="post" action="index.php" name="up" onsubmit="return include_data(this);">
<?php 
if($edit) {
	$o_e = $events->read_item($CLd, $CLm, $CLy, (int)($edit-1));
	if(!$a_groups[$__SESSION__['group']]['ev_edit'] && !$__SESSION__['user'] == $o_e->owner) $o_e = array();
	$id = (int)$edit;
	$C_S = $events->get_cell_settings($CLd, $CLm, $CLy);
?>
	<input type="hidden" name="edit" value="1"><?php 
}?>
<input type="hidden" name="CLd" value="<?php echo  $CLd?>">
<input type="hidden" name="name" value="<?php echo  $name?>">
<input type="hidden" name="CLm" value="<?php echo  $CLm?>">
<input type="hidden" name="CLy" value="<?php echo  $CLy?>">
<input type="hidden" name="id" value="<?php echo  $id?>">
<input type="hidden" name="action" value="e">
<input type="hidden" name="repeat" value="<?php echo $o_e->repeat?>">
<input type="hidden" name="every_day" value="1">
<input type="hidden" name="every_week" value="1">
<input type="hidden" name="every_month" value="1">
<input type="hidden" name="every_year" value="1">
<input type="hidden" name="e_date" value="1">
<input type="hidden" name="week_days_csv" value="1">
<input type="hidden" name="week_days_txt" value="1">

<tr><td colspan="2" class="header2"><?php echo  isset($edit) ? 'Edit' : 'New'?> Event</td></tr>
<tr>
	<td width="5%">Title: </td>
	<td width="95%"><input type="text" name="ti" value="<?php echo  stripslashes($o_e->title)?>" class="inpt"></td>
</tr>
<tr><td colspan="2" class="header2">Body</td></tr>
<tr>
	<td colspan="2"><textarea name="bi" rows="5" cols="60" class="inpt"><?php echo  stripslashes($o_e->body)?></textarea></td>
</tr>
<tr><td colspan="2" class="header2">Cell sittings</td></tr>
<tr>
	<td colspan="2">
	<table border="0" cellpadding="1" cellspacing="2">
	<tr>
	<td align="right">Background color:</td><td width="100"><input type="text" name="cbgc" value="<?php echo  $C_S[0]?>" class="inpt" ></td>
	<td align="right">Background image:</td><td width="100"><input type="text" name="cbgi" value="<?php echo  $C_S[1]?>" class="inpt" ></td>
	<td align="right">Align:</td><td width="100"><input type="text" name="calign" value="<?php echo  $C_S[2]?>" class="inpt" ></td></tr>
	</table>
	</td>
</tr>
<tr>
	<td colspan="2">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<?php if($calendar->a_template['time_gradation']){?>
<tr>
	<td colspan="5" align="center">
	<?php 
$start = $o_e->time_start['h'] < 12 ? $o_e->time_start['h'] : ($o_e->time_start['h']==12?"12":($o_e->time_start['h']-12));
$end = $o_e->time_end['h']<12?$o_e->time_end['h']:($o_e->time_end['h']==12?"12":($o_e->time_end['h']-12));
	?>
	<table border="0" cellspacing="0" cellpadding="3" align="center">
	<tr>
	<td align="right">Time</td>
	<td><input type="radio" name="is_time" value="1" <?php if($o_e->is_time)echo "checked"?>></td>
	<td nowrap>
		<input type="text" name="s_time_hour" value="<?php echo $start?>" size="2" maxlength="2" onblur="check(this,<?php echo $calendar->a_template['time_format'] == 1?'12':'23'?>)" class="inptbar">:<input type="text" name="s_time_min" value="<?php echo $o_e->time_start['m']?>" size="2" maxlength="2" onblur="check(this,59)" class="inptbar">
		<?php if($calendar->a_template['time_format'] == 1){?>
			<select name="s_time_type" class="inptbar">
				<option value="0" <?php if(12>$o_e->time_start['h'])echo " selected"?>>AM</option>
				<option value="1" <?php if($o_e->time_start['h']>=12)echo " selected"?>>PM</option>
			</select>
		<?php }?>
	</td>
	<td>to</td>
	<td nowrap>
		<input type="text" name="e_time_hour" value="<?php echo $end?>" size="2" maxlength="2" onblur="check(this,<?php echo $calendar->a_template['time_format'] == 1?'12':'23'?>)" class="inptbar">:<input type="text" name="e_time_min" value="<?php echo $o_e->time_end['m']?>" size="2" maxlength="2" onblur="check(this,59)" class="inptbar">
		<?php if($calendar->a_template['time_format'] == 1){?>
			<select name="e_time_type" class="inptbar">
				<option value="0" <?php if(12>$o_e->time_end['h'])echo " selected"?>>AM</option>
				<option value="1" <?php if($o_e->time_end['h']>=12)echo " selected"?>>PM</option>
			</select>
		<?php }?>
	</td>
	</tr>
	<tr>
		<td align="right">No time</td>
		<td colspan="4">
			<input type="radio" name="is_time" value="0" <?php if(!$o_e->is_time)echo "checked"?>>
		</td>
	</tr>
	</table>
	</td>
</tr>
<?php }?>
<tr>
	<td colspan="5" align="center">Select how often this event should repeat:</td>
</tr>
<tr>
	<td colspan="5" align="center">
	<table border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td bgcolor="#4682B4">
		<table border="0" cellspacing="1" cellpadding="3" align="center">
		<tr>
			<td id="control_none" class="header2"><a href="#" onclick="return show_bar(0);">None</a></td>
			<td id="control_day" class="header2"><a href="#" onclick="return show_bar(1);">Day</a></td>
			<td id="control_week" class="header2"><a href="#" onclick="return show_bar(2);">Week</a></td>
			<td id="control_month" class="header2"><a href="#" onclick="return show_bar(3);">Month</a></td>
			<td id="control_year" class="header2"><a href="#" onclick="return show_bar(4);">Year</a></td>
		</tr>
		</table>
	</td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td colspan=5 align="center">
		<img src="img/pixel.gif" width="500" height="200" border="0" id="bar_position" name="bar_position">
	</td>
</tr>
</table>
	
	</td>
</tr>
<tr><td colspan="2" class="header2" align="right" style="padding:1px; text-align:right;">
	<?php 
	if($edit) {
	?>
	<input type="submit" name="cane" value=" Cancel " class="btn">
	<input type="submit" name="adde" value=" Update event " class="btn">
	<?php if($o_e->repeat){?>
	<input type="Hidden" name="adde" value=1>
	<input type="Hidden" name="all_fut">
	<input type="button" onclick="document.forms['up'].elements['all_fut'].value = 1; include_data(document.forms['up']); document.forms['up'].submit()" name="adde" value=" Update this and all future occurrences" class="btn"><?php }?>
	</td>
	<?php 
	}else{
	?>
	<input type="submit" name="adde" value=" Add event " class="btn"></td>
	<?php 
	}
	?>
</tr>
</form>
<?php }
}//end if ($show_type == 1)?>
<tr><td colspan="2"><img src="/img/pixel.gif" width="1" height="5" border="0"></td></tr>
<?php }else{?>
<form method="post" action="index.php" name="up">
<input type="hidden" name="CLd" value="<?php echo  $CLd?>">
<input type="hidden" name="name" value="<?php echo  $name?>">
<input type="hidden" name="CLm" value="<?php echo  $CLm?>">
<input type="hidden" name="CLy" value="<?php echo  $CLy?>">
<input type="hidden" name="id" value="<?php echo  $id?>">
<input type="hidden" name="action" value="e">
<input type="hidden" name="type" value="url">
<tr><td colspan="3" class="header2">Event's URL<?php echo help('custom_url')?></td></tr>
<tr>
	<td width="10%">URL: </td>
	<td><input type="text" name="itemurl" value="<?php echo  $events->read_item($CLd, $CLm, $CLy, 'url')?>" class="inpt"></td>
	<td width="2%"><?php echo help('custom_url')?></td>
</tr>
<tr>
	<td width="10%">Target:</td>
	<td><input type="text" name="itemtarget" value="<?php echo  $events->read_item($CLd, $CLm, $CLy, 'target')?>" class="inpt"></td>
	<td width="2%"><?php echo help('custom_url')?></td>
</tr>
<tr>
	<td width="10%">Title:</td>
	<td><input type="text" name="itemtitle" value="<?php echo  $events->read_item($CLd, $CLm, $CLy, 'title')?>" class="inpt"></td>
	<td width="2%"><?php echo help('custom_url')?></td>
</tr>
<tr><td colspan="3" class="header2" align="right" style="padding:1px; text-align:right;"><input type="submit" name="addu" value=" Update URL " class="btn"></td>
</tr>
</form>
<?php }
?>

</table>
<?php if($show_type == 1){?>
	<div id="none" style="position:absolute; width:500px; height:200px; z-index:1; visibility:hidden; left: -590px; top : -250px; border:3px #ff0000">
		<br><p align="center">Click on one the selections above to set the repeat interval</p>
	</div>
	<div id="day" style="position:absolute; width:500px; height:200px; z-index:1; visibility:hidden; left: -590px; top : -250px; border: none #000000">
	<!-- Day bar -->
	<script language="JavaScript">
		function day_set_caption(){
			var obj = document.forms['form_day'];
			if(obj.elements['every_day'].value==2) obj.elements['comment'].value='Every other day';
			else if(obj.elements['every_day'].value==1) obj.elements['comment'].value='Every day';
			else obj.elements['comment'].value='Every '+obj.elements['every_day'].value+'th days';
		}
		function day_bar_check (obj){
			var o_f,c = '',o = obj.value*1;
			var o_form = document.forms['form_day'];
		}
	</script>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<form name="form_day" method="post" action="">
	<tr> 
	<td align="right" width="45%">Every:</td>
	<td width="5%"> 
		<select name="every_day" onchange="day_set_caption()">
			<?php for($i=1;$i<=30;$i++)echo '<option value="'.$i.'" '.($o_e->frequency == $i?" selected":'').'>'.$i.'</option>';?>
		</select>
	</td>
	<td width="50%">Days</td>
	</tr>
	<tr><td align="right">End on:</td>
	<td nowrap>
		<input type="text" name="e_date" size="10" maxlength="10" class="inptbar" value="<?php echo $o_e->e_date?$o_e->e_date:date('d-m-Y',time()+30*86400)?>" onchange="day_bar_check(this)">
		<a href="javascript:cal_day.popup();"><img src="<?php  echo $calendar->s_WebImgPath?>cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
	</td>
	</tr>
	<tr> 
	<td align="center" colspan="3"> 
		<input type="text" name="comment" size="50" value="Every day" class="inptbar" style="border:0px;background:#ffffff">
	</td>
	</tr>
</form>
</table>
<script language="JavaScript">
	var cal_day = new calendar(document.forms['form_day'].elements['e_date']);
	cal_day.time_comp = false;
</script>
	</div>
	<div id="week" style="position:absolute; width:500px; height:200px; z-index:1; visibility:hidden; left: -590px; top : -250px; border: 1px none #000000">
	<!-- week bar -->
	<script language="JavaScript">
		var a_dow_control = [];
		var a_shot_week_day = ['Mo','Tu','We','Th','Fr','Sa','Su'];
		var a_selected_wd = [];
		var a_wd_txt = [];
		function week_init(){
			if(a_dow_control.length < 6){
				a_selected_wd = document.forms['form_week'].elements['week_days_csv'].value.split(",");
				a_wd_txt = document.forms['form_week'].elements['week_days_txt'].value.split(",");
				for(i=1;i<=7;i++){
					a_dow_control[i] = get_element('DayOfWeek'+i);
					if(a_selected_wd[(i -1)] == 1){
						a_dow_control[i]['selected'] = true;
						if(a_dow_control[i].style) a_dow_control[i].style.backgroundColor = '#DBEAF5';
					}
				}
			}
			week_set_caption();
		}
		function week_set_caption(n_id){
			if(a_dow_control.length < 6)for(i=1;i<=7;i++) a_dow_control[i] = get_element('DayOfWeek'+i);
			if(n_id){
				if(a_dow_control[n_id].style){
					if(a_dow_control[n_id]['selected']){
						if(a_selected_wd.join("").indexOf("1")!=n_id-1 || a_selected_wd.join("").match(/1/g).length>1){
							a_dow_control[n_id].style.backgroundColor = '#ffffff';
							a_dow_control[n_id]['selected'] = false;
						}
					}else{
						a_dow_control[n_id].style.backgroundColor = '#DBEAF5';
						a_dow_control[n_id]['selected'] = true;
					}
				}
			}
			var obj = document.forms['form_week'];
			var e_wd_csv = document.forms['form_week'].elements['week_days_csv'];
			var e_wd_txt = document.forms['form_week'].elements['week_days_txt'];
			var i = 0,c = 0;
			a_wd_txt = [];
			if(a_selected_wd.join("").indexOf("1")!=n_id-1 || a_selected_wd.join("").match(/1/g).length>1){
				for(i=0;i < a_shot_week_day.length;i++) if((n_id - 1) == i) a_selected_wd[i] = a_selected_wd[i]==1?0:1;
			}
			for(i in a_selected_wd) if(a_selected_wd[i]==1)a_wd_txt[c++]=a_shot_week_day[i];
			e_wd_csv.value = a_selected_wd.join(',');
			e_wd_txt.value = a_wd_txt.join(',');
			if(obj.elements['every_week'].value==2) obj.elements['comment'].value='Every other week on '+e_wd_txt.value;
			else if(obj.elements['every_week'].value==1) obj.elements['comment'].value='Every week on '+e_wd_txt.value;
			else obj.elements['comment'].value='Every '+obj.elements['every_week'].value+'th weeks on '+e_wd_txt.value;
			return false;
		}
		function week_bar_check (obj){
			var o_f,c = '',o = obj.value*1;
			var o_form = document.forms['form_week'];
		}
	</script>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<?php 
$a_cur_day = array(0,0,0,0,0,0,0);
$a_cur_day[$calendar->dwf - 1] = 1;
?>
<form name="form_week" method="post" action="">
	<input type="hidden" name="week_days_csv" value="<?php echo $o_e->repeat_days ? $o_e->repeat_days : join(",",$a_cur_day)?>">
	<input type="hidden" name="week_days_txt" value="<?php echo $o_e->repeat_days_txt ? $o_e->repeat_days : $calendar->a_localization[$calendar->dwf]?>">
	<tr> 
	<td align="right" width="45%">Every:</td>
	<td width="5%"> 
		<select name="every_week" onchange="week_set_caption()">
		<?php for($i=1;$i<=30;$i++)echo '<option value="'.$i.'" '.($o_e->frequency==$i?" selected":'').'>'.$i.'</option>';?>
		</select>
	</td>
	<td width="50%">Week</td>
	</tr>
	<tr> 
	<td align="right">End on:</td>
	<td nowrap>
		<input type="text" name="e_date" size="10" maxlength="10" class="inptbar" value="<?php echo $o_e->e_date?$o_e->e_date:date('d-m-Y',time()+30*86400)?>" onblur="week_bar_check(this)">
		<a href="javascript:cal_week.popup();"><img src="<?php  echo $calendar->s_WebImgPath?>cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
	</td>
	</tr>
	<tr> 
	<td align="right">Repeat on:</td>
	<td colspan="2" >
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td bgcolor="#4682B4">
			<table border="0" cellspacing="1" cellpadding="2">
				<tr>
				<td bgcolor="#ffffff" id="DayOfWeek1"><a href="#" onclick="return week_set_caption(1);">Mo</a></td>
				<td bgcolor="#ffffff" id="DayOfWeek2"><a href="#" onclick="return week_set_caption(2);">Tu</a></td>
				<td bgcolor="#ffffff" id="DayOfWeek3"><a href="#" onclick="return week_set_caption(3);">We</a></td>
				<td bgcolor="#ffffff" id="DayOfWeek4"><a href="#" onclick="return week_set_caption(4);">Th</a></td>
				<td bgcolor="#ffffff" id="DayOfWeek5"><a href="#" onclick="return week_set_caption(5);">Fr</a></td>
				<td bgcolor="#ffffff" id="DayOfWeek6"><a href="#" onclick="return week_set_caption(6);">Sa</a></td>
				<td bgcolor="#ffffff" id="DayOfWeek7"><a href="#" onclick="return week_set_caption(7);">Su</a></td>
				</tr>
			</table>
			</td>
		</tr>
		</table>
	</td>
	</tr>
	<tr> 
	<td align="center" colspan="3"> 
		<input type="text" name="comment" size="50" value="Every week" class="inptbar" style="border:0px;background:#ffffff">
	</td>
	</tr>
</form>
</table>
<script language="JavaScript">
	var cal_week = new calendar(document.forms['form_week'].elements['e_date']);
	cal_week.time_comp = false;
</script>
	</div>
	<div id="month" style="position:absolute; width:500px; height:200px; z-index:1; visibility:hidden; left: -590px; top : -250px; border: 1px none #000000">
	<!-- Month bar -->
	<script language="JavaScript">
		function month_set_caption(){
			var obj = document.forms['form_month'];
			if(obj.elements['every_month'].value==2) obj.elements['comment'].value='The <?php echo $CLd?>th of every other month';
			else if(obj.elements['every_month'].value==1) obj.elements['comment'].value='The <?php echo $CLd?>th of every month';
			else obj.elements['comment'].value='The <?php echo $CLd?>th of every '+obj.elements['every_month'].value+'th months';
		}
		function month_bar_check (obj){
			var o_f,c = '',o = obj.value*1;
			var o_form = document.forms['form_month'];
		}
	</script>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<form name="form_month" method="post" action="">
	<tr> 
	<td align="right" width="45%">Every:</td>
	<td width="5%"> 
		<select name="every_month" onchange="month_set_caption()">
			<?php for($i=1;$i<=10;$i++)echo '<option value="'.$i.'" '.($o_e->frequency==$i?" selected":'').'>'.$i.'</option>';?>
		</select>
	</td>
	<td width="50%">Months</td>
	</tr>
	<tr> 
	<td align="right">End on:</td>
	<td nowrap>
		<input type="text" name="e_date" size="10" maxlength="10" class="inptbar" value="<?php echo $o_e->e_date?$o_e->e_date:date('d-m-Y',time()+30*86400)?>" onblur="month_bar_check(this)">
		<a href="javascript:cal_month.popup();"><img src="<?php  echo $calendar->s_WebImgPath?>cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
	</td>
	</tr>
	<tr> 
	<td align="center" colspan="3"> 
		<input type="text" name="comment" size="50" value="The <?php echo $CLd?>th of every month" class="inptbar" style="border:0px;background:#ffffff">
	</td>
	</tr>
</form>
</table>
<script language="JavaScript">
	var cal_month = new calendar(document.forms['form_month'].elements['e_date']);
	cal_month.time_comp = false;
</script>
	</div>
	<div id="year" style="position:absolute; width:500px; height:200px; z-index:1; visibility:hidden; left: -590px; top : -250px; border: 1px none #000000">
	<!-- Year bar -->
	<script language="JavaScript">
		function year_set_caption(){
			var obj = document.forms['form_year'];
			if(obj.elements['every_year'].value==2) obj.elements['comment'].value='<?php echo $calendar->a_localization['months'][$CLm-1].', '.$CLd.' '?>every other year';
			else if(obj.elements['every_year'].value==1) obj.elements['comment'].value='<?php echo $calendar->a_localization['months'][$CLm-1].', '.$CLd.' '?>every year';
			else obj.elements['comment'].value='<?php echo $calendar->a_localization['months'][$CLm-1].', '.$CLd.' '?>every '+obj.elements['every_year'].value+'th years';
		}
		function year_bar_check (obj){
			var o_f,c = '',o = obj.value*1;
			var o_form = document.forms['form_year'];
		}
	</script>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<form name="form_year" method="post" action="">
	<tr> 
	<td align="right" width="45%">Every:</td>
	<td width="5%"> 
		<select name="every_year" onchange="year_set_caption()">
			<?php for($i=1;$i<=5;$i++)echo '<option value="'.$i.'" '.($o_e->frequency == $i?" selected":'').'>'.$i.'</option>';?>
		</select>
	</td>
	<td width="50%">Years</td>
	</tr>
	<tr> 
	<td align="right">End on:</td>
	<td nowrap>
		<input type="text" name="e_date" size="10" maxlength="10" class="inptbar" value="<?php echo $o_e->e_date ? $o_e->e_date:date('d-m-Y',time()+30*86400)?>" onblur="year_bar_check(this)">
		<a href="javascript:cal_year.popup();"><img src="<?php  echo $calendar->s_WebImgPath?>cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"></a>
	</td>
	</tr>
	<tr> 
	<td align="center" colspan="3"> 
		<input type="text" name="comment" size="50" value="<?php echo $calendar->a_localization['months'][$CLm-1].', '.$CLd.' '?>every year" class="inptbar" style="border:0px;background:#ffffff">
	</td>
	</tr>
</form>
</table>
<script language="JavaScript">
	var cal_year = new calendar(document.forms['form_year'].elements['e_date']);
	cal_year.time_comp = false;
</script>
	</div>
<?php }?>
