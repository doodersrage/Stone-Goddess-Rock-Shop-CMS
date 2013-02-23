	<table border="0" align="center" cellpadding="4" cellspacing="0" width="100%"><?php 
	if($l && $p && $p2) {
echo $p;
		if($p == $p2){
			$u_text = $calendar->read_file("users",".php",1);
			$u_text = str_replace("<?php ","",$u_text);
			$u_text = str_replace("?>","",$u_text);
			$a_users = unserialize($u_text);
			if(is_array($a_users[$l])) {
				if($__SESSION__['user']!=$l)$error = "This login is already use in the system, please choose other login.";
				else{
					$a_users[$l]['pwd'] = $p;
				}
			}else{
				$a_users[$l] = $a_users[$__SESSION__['user']];
				$a_users[$l]['pwd'] = $p;
				unset($a_users[$__SESSION__['user']]);
			}
			if(!$error) $calendar->put_in_file($calendar->s_DataDir."users.php","<?php ".serialize($a_users)."?>");
			header("Location: index.php?CLd=$CLd&CLm=$CLm&CLy=$CLy&name=$name&action=$action&page=a".($error?"&error=$error":"&logoff=1"));
			exit;
		}else{
			header("Location: index.php?CLd=$CLd&CLm=$CLm&CLy=$CLy&name=$name&type=$type&action=$action&page=a&error=Please check that the two passwords matched");
			exit;
		}
	}
	?>
	<form name=user method=post action="index.php">
	<input type="hidden" name="page" value="a">
	<tr><td colspan=4 class="header2">User info<?php echo help('secure')?></td></tr>
	<?php if($error){?><tr><td colspan=4 align=center><font color=red><b><?php echo $error?></b></font></td></tr><?php }?>
	<?php if($logoff){?>
			<tr><td colspan=4 align=center><font color=green><b>Password has been chanhes, please login again.</b></font></td></tr>
			<tr><td colspan=4 align=center><a href="index.php">Login</a></td></tr>
			<?php $__SESSION__ = array();
		}else{?>
	<tr>
	<td width="30%">&nbsp;</td><td colspan="2">Username: <input type=text name=l size=5 class=inpt></td><td width="30%">&nbsp;</td></tr>
	<tr>
	<td width="30%">&nbsp;</td>
	<td width="20%">Password: <input type=password name=p size=6 class=inpt></td>
	<td width="20%">Confirm password: <input type=password name=p2 size=6 class=inpt></td>
	<td width="30%">&nbsp;</td></tr>
	<tr><td colspan=4 class="header2" align="right" style="padding:1px; text-align:right;"><input type=submit value="change" size="6"></td></tr>
	<?php }?>
	</form>
	</table>
