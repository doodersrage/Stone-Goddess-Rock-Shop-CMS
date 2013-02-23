	<table border="0" align="center" cellpadding="4" cellspacing="0" width="100%"><?php 
	$g_text = $calendar->read_file("groups",".php",1);
	$g_text = str_replace("<?php ","",$g_text);
	$g_text = str_replace("?>","",$g_text);
	$a_groups = unserialize($g_text);

	$u_text = $calendar->read_file("users",".php",1);
	$u_text = str_replace("<?php ","",$u_text);
	$u_text = str_replace("?>","",$u_text);
	$a_users = unserialize($u_text);
	if($add_user){
		if($l && $p && $p2) {
			if($p == $p2){
				if(is_array($a_users[$l])) {
						$error = "This login is already use in the system, please choose other login.";
					}else{
					$a_users[$l]['pwd'] = $p;
					$a_users[$l]['group'] = $group;
					$a_users[$l]['access'] = 1;
				}
				if(!$error){
					$calendar->put_in_file($calendar->s_DataDir."users.php","<?php ".serialize($a_users)."?>");
				}
				header("Location: index.php?CLd=$CLd&CLm=$CLm&CLy=$CLy&name=$name&action=$action&page=admin&error_user=$error");
				exit;
			}else{
				header("Location: index.php?CLd=$CLd&CLm=$CLm&CLy=$CLy&name=$name&type=$type&action=$action&page=admin&error_user=Please check that the two passwords matched");
				exit;
			}
		}else{
			
		}
	}
	if($edit_user){
		foreach($a_users as $k=>$v){
			$a_users[$k]['access'] = (int)$access_user[$k];
			$a_users[$k]['group'] = $group_edit[$k];
			if($delete_user[$k] && $__SESSION__['user']!=$k) unset($a_users[$k]);
		}
		$a_users[$__SESSION__['user']]['access'] = 1;
		$calendar->put_in_file($calendar->s_DataDir."users.php","<?php ".serialize($a_users)."?>");
		header("Location: index.php?CLd=$CLd&CLm=$CLm&CLy=$CLy&name=$name&action=$action&page=admin&error_user=$error");
		exit;
	}
	if($add_group && $gr_name_new){
		if(!is_array($a_groups[$gr_name_new])){
			$a_groups[$gr_name_new]['ev_add'] = (int)$ev_add_new;
			$a_groups[$gr_name_new]['ev_edit'] = (int)$ev_edit_new;
			$a_groups[$gr_name_new]['cal_cfg'] = (int)$cal_cfg_new;
			$a_groups[$gr_name_new]['tem_cfg'] = (int)$tem_cfg_new;
		}else $error = "This group is already use in the system, please choose other group name.";
		print_r($a_groups);
		//exit;
		$calendar->put_in_file($calendar->s_DataDir."groups.php","<?php ".serialize($a_groups)."?>");
		header("Location: index.php?CLd=$CLd&CLm=$CLm&CLy=$CLy&name=$name&action=$action&page=admin&error_group=$error");
		exit;
	}
	if($edit_group){
		foreach($a_groups as $k=>$v){
			$a_groups[$k]['ev_add'] = (int)$ev_add[$k];
			$a_groups[$k]['ev_edit'] = (int)$ev_edit[$k];
			$a_groups[$k]['cal_cfg'] = (int)$cal_cfg[$k];
			$a_groups[$k]['tem_cfg'] = (int)$tem_cfg[$k];
			if($is_admin == $k) $a_groups[$k]['is_admin'] = 1;
			else  $a_groups[$k]['is_admin'] = 0;
			if($delete_group[$k] && $__SESSION__['group']!=$k) unset($a_groups[$k]);
		}
		print_r($a_groups);
		//exit;
		$calendar->put_in_file($calendar->s_DataDir."groups.php","<?php ".serialize($a_groups)."?>");
		header("Location: index.php?CLd=$CLd&CLm=$CLm&CLy=$CLy&name=$name&action=$action&page=admin&error_group=$error");
		exit;
	}
	?>
	<tr><td class="header2">Group list<?php echo help('secure')?></td></tr>
	<tr><td>
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
		<tr><td bgcolor="#4682B4">
		<table width="100%" border="0" cellspacing="1" cellpadding="2">
		<form name=user method=post action="index.php">
		<input type="hidden" name="page" value="admin">
		<input type="hidden" name="name" value="<?php echo $calendar->s_calendar_index?>">
			<tr> 
			<td width="46%" rowspan="3" class="list" align="center" bgcolor="#ffffff">Title</td>
			<td width="4%" rowspan="3" class="list" align="center" bgcolor="#ffffff">Is Admin</td>
			<td width="40%" colspan="4" class="list" align="center" bgcolor="#ffffff">Permissions</td>
			<td width="10%" rowspan="3" class="list" align="center" bgcolor="#ffffff">Delete</td>
			</tr>
			<tr> 
			<td width="21%" colspan="2" class="list" align="center" bgcolor="#ffffff">Events editor</td>
			<td width="9%" rowspan="2" class="list" align="center" bgcolor="#ffffff">Calendars config</td>
			<td width="10%" rowspan="2" class="list" align="center" bgcolor="#ffffff">Templates Config</td>
			</tr>
			<tr> 
			<td width="10%" class="list" align="center" bgcolor="#ffffff">Add events</td>
			<td width="11%" class="list" align="center" bgcolor="#ffffff">Edit other's events</td>
			</tr>
			<?php foreach($a_groups as $k=>$v){?>
			<tr>
			<td align="center" bgcolor="#ffffff"><input type="text" name="gr_name[<?php echo $k?>]" value="<?php echo $k?>" class=inpt></td>
			<td align="center" bgcolor="#ffffff"><input type="Radio" name="is_admin" value="<?php echo $k?>"<?php if($v['is_admin'])echo " checked";?>></td>
			<td align="center" bgcolor="#ffffff"><input type="Checkbox" name="ev_add[<?php echo $k?>]"<?php if($v['ev_add'])echo " checked";?> value="1" class=inpt></td>
			<td align="center" bgcolor="#ffffff"><input type="Checkbox" name="ev_edit[<?php echo $k?>]"<?php if($v['ev_edit'])echo " checked";?> value="1" class=inpt></td>
			<td align="center" bgcolor="#ffffff"><input type="Checkbox" name="cal_cfg[<?php echo $k?>]"<?php if($v['cal_cfg'])echo " checked";?> value="1" class=inpt></td>
			<td align="center" bgcolor="#ffffff"><input type="Checkbox" name="tem_cfg[<?php echo $k?>]"<?php if($v['tem_cfg'])echo " checked";?> value="1" class=inpt></td>
			<td align="center" bgcolor="#ffffff">
			<?php if($__SESSION__['group']!=$k){?>
				<input type="Checkbox" name="delete_group[<?php echo $k?>]" value="1" class=inpt>
			<?php }else echo "&nbsp;"?>
			</td>
			</tr>
			<?php }?>
			<tr><td colspan="7" bgcolor="#ffffff">&nbsp;</td></tr>
			<tr><td align="right" colspan="7" bgcolor="#ffffff"><input type="submit" name="edit_group" value="Update groups info"></td></tr>
			<tr><td colspan="7" bgcolor="#ffffff">&nbsp;</td></tr>
			<?php if($error_group){?><tr><td colspan=6 align=center bgcolor="#ffffff"><font color=red><b><?php echo $error_group?></b></font></td></tr><?php }?>
			<tr>
			<td align="center" colspan="2" bgcolor="#ffffff"><input type="text" name="gr_name_new" value="" class=inpt></td>
			<td align="center" bgcolor="#ffffff"><input type="Checkbox" name="ev_add_new" value="1" class=inpt></td>
			<td align="center" bgcolor="#ffffff"><input type="Checkbox" name="ev_edit_new" value="1" class=inpt></td>
			<td align="center" bgcolor="#ffffff"><input type="Checkbox" name="cal_cfg_new" value="1" class=inpt></td>
			<td align="center" bgcolor="#ffffff"><input type="Checkbox" name="tem_cfg_new" value="1" class=inpt></td>
			<td bgcolor="#ffffff"><input type="submit" name="add_group" value="Add new"></td>
			</tr></form>
		</table>
		
		</td></tr></table>
	</td></tr>
	<tr><td class="header2">Users list<?php echo help('secure')?></td></tr>
	<tr><td>
	<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr><td bgcolor="#4682B4">
	<table width="100%" border="0" cellspacing="1" cellpadding="2">
	<form name=user method=post action="index.php">
	<input type="hidden" name="page" value="admin">
	<input type="hidden" name="name" value="<?php echo $calendar->s_calendar_index?>">
	<tr>
		<td align="center" width="50%" class="list" bgcolor="#ffffff" colspan="2">Username</td>
		<td align="center" width="30%" class="list" bgcolor="#ffffff">Group</td>
		<td align="center" width="10%" class="list" bgcolor="#ffffff">Access</td>
		<td align="center" width="10%" class="list" bgcolor="#ffffff">Delete</td>
	</tr>
	<?php foreach($a_users as $k=>$v){?>
	<tr>
		<td bgcolor="#ffffff" colspan="2"><?php echo $k?></td>
		<td align="center" bgcolor="#ffffff"> 
		<select name="group_edit[<?php echo $k?>]" class=inpt>
		<?php foreach($a_groups as $k1=>$v1){?>
		<option value="<?php echo $k1?>"<?php echo ($k1==$v['group']?' selected':'')?>><?php echo $k1?></option>
		<?php }?>
		</select>
		</td>
		<td align="center" bgcolor="#ffffff">
		<?php if($__SESSION__['user']!=$k){?>
			<input type="Checkbox" name="access_user[<?php echo $k?>]"<?php if($v['access'])echo ' checked'?> value="1" class=inpt>
		<?php }else echo "&nbsp;"?>
		</td>
		<td align="center" bgcolor="#ffffff">
		<?php if($__SESSION__['user']!=$k){?>
			<input type="Checkbox" name="delete_user[<?php echo $k?>]" value="1" class=inpt>
		<?php }else echo "&nbsp;"?>
		</td>
	</tr>
	<?php }?>
	<tr><td colspan="5" bgcolor="#ffffff">&nbsp;</td></tr>
	<tr><td align="right" colspan="7" bgcolor="#ffffff"><input type="submit" name="edit_user" value="Update users info"></td></tr>
	<tr><td colspan="7" bgcolor="#ffffff">&nbsp;</td></tr>
	<?php if($error_user){?><tr><td colspan=5 align=center bgcolor="#ffffff"><font color=red><b><?php echo $error_user?></b></font></td></tr><?php }?>
	<tr>
		<td colspan="2" bgcolor="#ffffff">Username: <input type=text name=l size=5 class=inpt></td>
		<td rowspan="2" bgcolor="#ffffff">
		<select name="group" class=inpt>
		<?php foreach($a_groups as $k1=>$v1){?>
		<option value="<?php echo $k1?>"><?php echo $k1?></option>
		<?php }?>
		</select>
		</td>
		<td colspan=2 rowspan="2" bgcolor="#ffffff" align="center"><input type="submit" name="add_user" value="Add new"></td>
	</tr>
	<tr>
		<td bgcolor="#ffffff">Password:<input type=password name=p size=6 class=inpt></td>
		<td bgcolor="#ffffff">Confirm password:<input type=password name=p2 size=6 class=inpt></td>
	</tr>
	<tr><td colspan="5" bgcolor="#ffffff">&nbsp;</td>
	</tr>
	</form>
	</table></td></tr>
	</table>
	</td></tr>
	</table>
