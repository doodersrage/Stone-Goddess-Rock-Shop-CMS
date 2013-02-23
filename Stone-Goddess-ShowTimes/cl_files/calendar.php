<?php 
// Title: PHP Event Calendar
// URL: http://www.softcomplex.com/products/php_event_calendar/
// Version: 1.5.1
// Date: 03/04/2005 (mm/dd/yyyy)
// Tech. support: http://www.softcomplex.com/forum/forumdisplay.php?fid=55
// Notes: Script is free for non commercial use. Visit official site for details.

// a path to calendar files
// change if needed

$PATHS=array(
"path_to_calendar" => "/home/doode0/public_html/stonegoddess/Stone-Goddess-ShowTimes/cl_files/",
"path_to_calendar_img" => "/home/doode0/public_html/stonegoddess/Stone-Goddess-ShowTimes/cl_files/img/",
"WEB_path_to_calendar_img" => "http://www.stonegoddess.com/home/doode0/public_html/stonegoddess/Stone-Goddess-ShowTimes/cl_files/img/",
"path_to_data" => "/home/doode0/public_html/stonegoddess/Stone-Goddess-ShowTimes/cl_files/data/"
);


// Please, do not change anything below this line
// ----------------------------------------------
extract($_POST);
foreach($_POST as $k=>$v){
	if(!is_array($v))${urldecode($k)}=urldecode($v);
}
extract($_GET);
class calendar{
	var $s_ImgDir; //an image folder absolute path
	var $s_WebImgPath; //WEB path to the image folder (http://domain/calendar_files/img/)
	var $s_FilesDir; //a main files folder absolute path
	var $s_DataDir; //a data storage folder absolute path
	var $db; //a variable for DB class
	var $error; //a variable returns the error text message for previous calendar operation 
	var $is_admin; //is true if calendar is called from control panel
	var $is_created; //is true if current calendar name is just created
	var $a_template; //an array that contain templates information
	var $a_look; //an array that contains looks information
	var $a_localization; //an array that contains information about localization
	var $a_redirect; //an array that contains information about link redirect
	var $a_current_date; //an array that contains current date of the following structure 
		/*
			$a_current_date = Array(
				'm'=>month value,
				'd'=>day value,
				'y'=>year value
			)
		*/
	var $a_selected_date;//an array that contains selected date of the following structure 
		/*
			$a_selected_date = Array(
				'm'=>month value,
				'd'=>day value,
				'y'=>year value
			)
		*/
	var $s_calendar_index; //a string that contains current calendar name
	var $events_class;
	/*
	function calendar
	input parameters:
		$name - calendar name (please, use only characters allowed for file names)
	used parameters:
		$s_ImgDir, $s_WebImgPath, $s_FilesDir, $s_DataDir
	used methods:
		init,show_calendar
	action:
		constructor calendar class. Call initialization and show calendar by $name (if name is exists)
	output:
		none
	*/
	function calendar($name=''){
		global $PATHS;
		$this->s_ImgDir = $PATHS['path_to_calendar_img'];
		$this->s_WebImgPath = $PATHS['WEB_path_to_calendar_img'];
		$this->s_DataDir = $PATHS['path_to_data'];
		$this->s_FilesDir = $PATHS['path_to_calendar'];
		if($name && !$this->s_calendar_index) {
			$this->init($name);
			$this->show_calendar();
		}
	}
	/*
	function init
	input parameters:
		$index_calendar - calendar name (please, use only characters allowed for file names)
	used parameters:
		$a_template, $a_look, $a_localization, $a_redirect, $s_calendar_index, $a_current_date, $a_selected_date
	used methods:
		use_config, get_date
	action:
		initialize calendar parameters ($a_current_date, $a_selected_date, $events_class, $a_look, $a_localization, $a_template, $a_redirect)
	output:
		none
	*/
	function init($index_calendar){
		global $events;
		$this->s_calendar_index = $index_calendar;
		if(!$s = $this->use_config()) return false;
		$this->a_template = $s['TEMPLATE'];
		$events->events_file = $this->s_DataDir.'event'.$this->s_calendar_index.'.dat';
		$events->events_map_file = $this->s_DataDir.'event_map'.$this->s_calendar_index.'.dat';
		$this->events_class = $events;
		$this->a_look = $s['LOOK'];
		$this->a_localization = $s['LOCALIZATION'];
		$this->a_redirect = $s['REDIRECT'];
		$mp = "CLm".$this->s_calendar_index;
		$dp = "CLd".$this->s_calendar_index;
		$yp = "CLy".$this->s_calendar_index;
		global ${$mp},${$dp},${$yp},$CLm,$CLd,$CLy;
		$this->events_class->load_item();
		$this->a_current_date['m'] = $this->get_date('m');
		$this->a_current_date['d'] = $this->get_date('d');
		$this->a_current_date['y'] = $this->get_date('Y');
		$this->a_selected_date['m'] = isset(${$mp}) ? ${$mp} : ($CLm ? $CLm : $this->a_current_date['m']);
		$this->a_selected_date['d'] = ${$dp} ? ${$dp} : ($CLd ? $CLd : $this->a_current_date['d']);
		$this->a_selected_date['y'] = ${$yp} ? ${$yp} : ($CLy ? $CLy : $this->a_current_date['y']);
	}
	/*
	function create_new
	input parameters:
		$name - calendar name (please, use only characters allowed for file names)
	used parameters:
		$s_DataDir, $a_look, $a_localization, $a_redirect, $s_calendar_index, $a_current_date, $a_selected_date
	used methods:
		copy_data, init, $db->put_data
	external functions:
		read_data
	action:
		create a new calendar specified by $name (if name is exists) and initialize it
	output:
		none
	return:
		An array of calendar parameters
	*/
	function create_new($name){
		global $db;
		$name=str_replace(" ","_",$name);
		include $this->s_DataDir."config_def.php";
		$gl = read_data($this->s_DataDir.'global.txt');
		$settings['events_file'] = $settings['events_file'].$name.".dat";
		$settings['events_map_file'] = $settings['events_map_file'].$name.".dat";
		if(!$gl[$name]) {
			$db->put_data($settings,$this->s_DataDir."config$name.php");
			$this->copy_data($this->s_DataDir."event_def.php", $this->s_DataDir."event".$name.".dat");
			$this->copy_data($this->s_DataDir."event_def.php", $this->s_DataDir."event_map".$name.".dat");
			$gl[$name] = 1;
			$db->put_data($gl, $this->s_DataDir."global.txt");
			$this->init($name);
		}
		return $gl;
	}
	/*
	function drop
	input parameters:
		$name - calendar name (please, use only characters allowed for file names)
	used parameters:
		$s_DataDir, $a_look, $a_localization, $a_redirect, $s_calendar_index, $a_current_date, $a_selected_date
	used methods:
		drop_data, $db->put_data
	external functions:
		read_data
	action:
		delete a calendar specified by $name (if name is exists)
	output:
		none
	*/
	function drop($name){
		global $db;
		$gl = read_data($this->s_DataDir.'global.txt');
		unset($gl[$name]);
		$this->drop_data($this->s_DataDir."config".$name.".php");
		$this->drop_data($this->s_DataDir."event".$name.".dat");
		$this->drop_data($this->s_DataDir."event_map".$name.".dat");
		@unlink($this->s_ImgDir."p_".$name.".gif");
		@unlink($this->s_ImgDir."n_".$name.".gif");
		@unlink($this->s_ImgDir."py_".$name.".gif");
		@unlink($this->s_ImgDir."ny_".$name.".gif");
		$db->put_data($gl, $this->s_DataDir."global.txt");

	}
	/*
	function show_calendar
	input parameters:
		none
	used parameters:
		$dwf - (current date day of week ), $a_selected_date, $a_template
	used methods:
		show_h, show_v
	action:
		initialize calendar showing and select how calendar will be showed (vertical or horizontal)
	output:
		none
	*/
	function show_calendar() {
		$this->dwf = date('w', mktime(0, 0, 0, $this->a_selected_date['m'], $this->a_selected_date['d'], $this->a_selected_date['y']));
		$this->dwf or $this->dwf = 7;
		if(!$this->a_template['is_vertical'])$this->show_h();
		else $this->show_v();
	}
	/*
	function show_header
	input parameters:
		none
	used parameters:
		$a_look, $a_template, $a_selected_date
	used methods:
		style_bg, make_date, put_href, put_arrows
	action:
		show calendar header (the same for vertical and horizontal)
	output:
		HTML of the calendar header
	*/
	function show_header(){
		?>
		<table cellspacing="0" border="0">
		<tr><td <?php echo  $this->style_bg($this->a_look['table_bg_color'])?>>
		<table cellspacing="0" cellpadding="0" border="0" width="100%"><tr>
		<td <?php echo  $this->style_bg($this->a_look['header_bg_color'], 'left')?>>
		<table cellspacing="1" cellpadding="3" border="0" width="100%"><tr>
		<td <?php echo  $this->style_bg($this->a_look['header_bg_color'],'left')?> width="5%" nowrap><?php if($this->a_template['show_year']) echo $this->put_href("<img src=".$this->put_arrows('py')." border=0 alt='previous year'>",'','',"CLy".$this->s_calendar_index."=".($this->a_selected_date['y']-1)).'&nbsp;';echo $this->put_href("<img src=".$this->put_arrows('p')." border=0 alt='prev month'>",'','',($this->a_selected_date['m']-1<1?"CLm".$this->s_calendar_index."=12&CLy".$this->s_calendar_index."=".($this->a_selected_date['y']-1):"CLm".$this->s_calendar_index."=".($this->a_selected_date['m']-1)));?></td>
		<td <?php echo  $this->style_bg($this->a_look['header_bg_color'],'center')?> width="90%">
			<span class=<?php echo $this->a_look['header_font_color']?>><?php echo $this->make_date($this->a_selected_date['m'],$this->a_selected_date['y'],$this->a_template['title_format'])?></span>
		</td>
		<td align=right <?php echo $this->style_bg($this->a_look['header_bg_color'],'left')?> width="5%" nowrap><?php echo $this->put_href("<img src=".$this->put_arrows('n')." border=0 alt='next month'>",'','',($this->a_selected_date['m']+1>12?"CLm".$this->s_calendar_index."=1&CLy".$this->s_calendar_index."=".($this->a_selected_date['y']+1):"CLm".$this->s_calendar_index."=".($this->a_selected_date['m']+1)));if($this->a_template['show_year'])echo '&nbsp;'.$this->put_href("<img src=".$this->put_arrows('ny')." border=0 alt='next year'>",'','',"CLy".$this->s_calendar_index."=".($this->a_selected_date['y']+1));?></td></tr></table></td></tr><tr><td><?php 
	}
	/*
	function show_v
	input parameters:
		none
	used parameters:
		$a_look, $a_template, $a_selected_date, $a_current_date
	used methods:
		style_bg, show_header, put_day
	action:
		show vertical calendar body
	output:
		HTML for vertical calendar body
	*/
	function show_v() {
		$dwf=date('w', mktime(0, 0, 0, $this->a_selected_date['m'], 1, $this->a_selected_date['y']));
		$num=date('t', mktime(0, 0, 0, $this->a_selected_date['m'], 1, $this->a_selected_date['y']));
		if($this->a_selected_date['d'] > $num) $this->a_selected_date['d'] = $num;
		$rows=5;
		if($this->a_template['is_american'] != 1){
			$dwf or $dwf = 7;
		}
		if($num > 35+(!$this->a_template['is_american'])-$dwf ){
			 $rows++;
		}
		$this->show_header();
		?>
		<table cellspacing="<?php echo $this->a_look['cell_spacing']?(int)$this->a_look['cell_spacing']:1?>" cellpadding="<?php echo $this->a_look['cell_padding']?(int)$this->a_look['cell_padding']:4?>" border="<?php echo (int)$this->a_look['cell_border']?>" width="100%">
		<?php 
		$__s=(int)!$this->a_template['is_american'];
		$__e=7-(int)$this->a_template['is_american'];
		$__s2=!$__s * !($dwf-7);
		if($this->a_template['weeks_location'] == 1) {
			echo "<tr>";
			if($this->a_template['days_location'] == 1)
				echo "<td ".$this->style_bg($this->a_look['header2_bg_color']).">&nbsp;</td>";
			for($j = 0; $j < $rows; $j++) {
				$d = $j * 7 + 1 + $__s - $dwf;
				echo "<td align=center ".$this->style_bg($this->a_look['header2_bg_color']).">
					<span class=".$this->a_look['header2_font_color'].">".$this->W_N($d)."</span></td>";
			}
			if($this->a_template['days_location']==2)
				echo "<td ".$this->style_bg($this->a_look['header2_bg_color']).">&nbsp;</td>";
			echo "</tr>";
		}
		for($i = $__s; $i <= $__e; $i++) {
			echo "<tr>";
			if($this->a_template['days_location']==1)
				echo "<td ".$this->style_bg($this->a_look['header2_bg_color']).">
				<span class=".$this->a_look['header2_font_color'].">".$this->a_localization['days'][$i%7]."</span></td>";
			for($j = $__s2; $j < $rows + $__s2; $j++) {
				$d=$j*7+1+$i-$dwf;
				$class =($d == $this->a_current_date['d'] && $this->a_selected_date['m'] == $this->a_current_date['m'] ? 'cur' : ((($i + 1) % 7 && $i % 7) ? ($d <= 0 || $d > $num ? 'bodyh' : 'body') : 'we'));
				$cf= $d == $this->a_current_date['d'] && $this->a_selected_date['m'] == $this->a_current_date['m'] ?'cur' : (!(($i + 1) % 7 && $i % 7) && ($d > 0 && $d <= $num) ? 'we' : ($d <= 0 || $d > $num ? 'bodyh' : 'body'));
				$color = $this->style_bg($this->a_look[$class.'_bg_color']);
				$font = $this->a_look[$cf.'_font_color'];
				if($this->is_admin){
					$color = $d == $this->a_selected_date['d'] ? ' bgcolor="#FF0000"' : $color;
					$font = $d == $this->a_selected_date['d'] ? 'active' : $font;
				}
				echo $this->put_day($d, $font, $color);
			}
			if($this->a_template['days_location']==2)
				echo "<td ".$this->style_bg($this->a_look['header2_bg_color']).">
					<span class=".$this->a_look['header2_font_color'].">".$this->a_localization['days'][$i%7]."</span></td>";
			echo"</tr>";
		}
		if($this->a_template['weeks_location'] == 2) {
			echo "<tr>";
			for($j = 0; $j < $rows + 1; $j++) {
				$d = $j * 7 + 1 + $__s - $dwf;
				if((!$j && $this->a_template['days_location'] == 1) || ($j == $rows && $this->a_template['days_location'] == 2))
					echo "<td ".$this->style_bg($this->a_look['header2_bg_color']).">&nbsp;</td>";
				else echo "<td align=center ".$this->style_bg($this->a_look['header2_bg_color']).">
					<span class=$header2_font_color>".$this->W_N($d)."</span></td>";
			}
			echo "</tr>";
		}?>
		</table></td></tr></table></td></tr></table><?php 
	}
	/*
	function show_h
	input parameters:
		none
	used parameters:
		$a_look, $a_template, $a_selected_date, $a_current_date
	used methods:
		style_bg, show_header, put_day
	action:
		show horizontal calendar body
	output:
		HTML for horizontal calendar body
	*/
	function show_h() {
		$dwf = date('w', mktime(0, 0, 0, $this->a_selected_date['m'], 1, $this->a_selected_date['y']));
		$num=date('t', mktime(0, 0, 0, $this->a_selected_date['m'], 1, $this->a_selected_date['y']));
		if($this->a_selected_date['d']> $num) $this->a_selected_date['d'] = $num;
		$rows=5;
		if($this->a_template['is_american'] != 1){
			$dwf or $dwf = 7;
		}
		if($num > 35+(!$this->a_template['is_american'])-$dwf) $rows++;
		$this->show_header();
		?>
		<table cellspacing="<?php echo $this->a_look['cell_spacing']?(int)$this->a_look['cell_spacing']:1?>" cellpadding="<?php echo $this->a_look['cell_padding']?(int)$this->a_look['cell_padding']:4?>" border="<?php echo (int)$this->a_look['cell_border']?>" width="100%">
		<?php 
		$rows = $this->a_template['days_location'] && $this->a_template['days_location'] != 1 ? $rows+1 : $rows;
		$s_i=$this->a_template['days_location'] && $this->a_template['days_location'] == 1 ? -1 : 0;
		$__s = (int)!$this->a_template['is_american'];
		$__e= 7 - $this->a_template['is_american'];
		$__s2 = !$__s * !($dwf-7);
		$rows += $__s2;
		for($i = $s_i + $__s2; $i < $rows; $i++) {
			echo "<tr>";
			if($this->a_template['weeks_location'] == 1) {
				$d = $i * 7 + 1 + $__s - $dwf;
				if(($i == ($s_i + $__s2) && $this->a_template['days_location'] == 1) || ($i == $rows - 1 && $this->a_template['days_location'] == 2)) 
					echo "<td ".$this->style_bg($this->a_look['header2_bg_color']).">&nbsp;</td>";
				else echo "<td align=\"center\" ".$this->style_bg($this->a_look['header2_bg_color'])."><span class=\"".$this->a_look['header2_font_color']."\">".$this->W_N($d)."</span></td>";
			}
			for($j = $__s; $j <= $__e; $j++) {
				if(($this->a_template['days_location'] == 2 && $i == $rows - 1) || ($this->a_template['days_location'] == 1 && $i == ($s_i + $__s2))){
					echo "<td ".$this->style_bg($this->a_look['header2_bg_color'])." align=center><span class=\"".$this->a_look['header2_font_color']."\">".$this->a_localization['days'][$j%7]."</span></td>";
				}else{
					$d = $i * 7 + 1 + $j - $dwf;
					$class = ($d == $this->a_current_date['d'] && $this->a_selected_date['m'] == $this->a_current_date['m'] ? 'cur' : (!(($j + 1) % 7 && $j % 7) ? 'we' : ($d <= 0 || $d > $num ? 'bodyh' : 'body')));
					$cf = ($d == $this->a_current_date['d'] && $this->a_selected_date['m'] == $this->a_current_date['m'] ? 'cur' : (!(($j + 1) % 7 && $j % 7) && ($d > 0 && $d <= $num) ? 'we' : ($d <= 0 || $d > $num ? 'bodyh' : 'body')));
					$color = $this->style_bg($this->a_look[$class.'_bg_color']);
					$font = $this->a_look[$cf.'_font_color'];
					if($this->is_admin){
						$color = $d == $this->a_selected_date['d'] && $this->a_selected_date['d'] ? ' bgcolor="#FF0000"' : $color;
						$font = $d == $this->a_selected_date['d'] && $this->a_selected_date['d'] ? 'active' : $font;
					}
					echo $this->put_day($d, $font, $color);
				}
			}
			if($this->a_template['weeks_location'] == 2) {
				$d = $i * 7 + 1 + $__s - $dwf;
				if(($i == $s_i && $this->a_template['days_location'] == 1) || ($i == $rows - 1 && $this->a_template['days_location'] == 2)) echo "<td ".$this->style_bg($this->a_look['header2_bg_color']).">&nbsp;</td>";
				else echo "<td align=center ".$this->style_bg($this->a_look['header2_bg_color'])."><span class=".$this->a_look['header2_font_color'].">".$this->W_N($d)."</span></td>";
			}
			echo"</tr>\n";
		}?></table></td></tr></table></td></tr></table><?php 
	}
	/*
	function put_arrows
	input parameters:
		$name - arrows name from the list (n - next month, ny - next year, p - preview month,py - preview year)
	used parameters:
		$s_ImgDir, $s_calendar_index, $s_WebImgPath
	used methods:
		none
	action:
		choose and return path to corresponding arrow image
	return:
		path to corresponding arrow image
	*/
	function put_arrows($name){
		if(is_file($this->s_ImgDir.$name."_".$this->s_calendar_index.".gif")) {
			return $this->s_WebImgPath.$name."_".$this->s_calendar_index.".gif";
		}
		return $this->s_WebImgPath.$name.".gif";
	}
	/*
	function put_day
	input parameters:
		$d - day number, $font - CSS style name for current day text, $color - hex value for current day cell color
	used parameters:
		$a_selected_date, $a_look, $s_calendar_index, $a_template, $a_redirect
	used methods:
		put_href, events_class->short_item, events_class->get_cell_settings, events_class->read_item
	action:
		make and return HTML cell for given day
	return:
		HTML cell for certain day
	*/
	function put_day($d, $font = 0, $color) {
		$cur_time = mktime(0, 0, 0, $this->a_selected_date['m'], $d, $this->a_selected_date['y']);
		$d = date('j', $cur_time);
		$m = date('m', $cur_time);
		$y = date('Y', $cur_time);
		$ar = $this->events_class->short_item($d, $m, $y);
		$cset = $this->events_class->get_cell_settings($d, $m, $y);
		if(is_array($ar)) {
			$cbgc = $cset[0];
			$cbgi = $cset[1];
			$calign = $cset[2];
			foreach($ar as $k=>$v) $ar_v[]=$v->title;
			if(is_array($ar_v))$str = join($this->a_template['is_show_title']?"<br>":"\n", $ar_v);
		}
		$item_url = $this->events_class->read_item($d, $m, $y, 'url');
		if(!$this->is_admin) {
				if(!$this->a_redirect['redirect_url']) $this->a_redirect['redirect_url'] = 'show.php?CLm=%m&CLd=%d&CLy=%y';
				if(!$this->a_redirect['redirect_target']) $this->a_redirect['redirect_target'] = '_blank';
				$u = split('\?', $this->a_redirect['redirect_url']);
				$l = $u[0];
				$p = $u[1];
				if(!$p)$p = "CLm=%m&CLd=%d&CLy=%y&c_num=".$this->s_calendar_index;
				$p = str_replace(array('%d', '%m', '%y'), array($d, $m, $y), $p);
				if ($item_url) {
					$cont = $this->put_href("<b>$d</b>", (!stristr($item_url,"http://")?"http://".$item_url:$item_url), $this->events_class->read_item($d, $m, $y, 'title'), "", ' target='.$this->events_class->read_item($d, $m, $y, 'target'), 1, $font);
				}else {
					$cont = $str ? $this->put_href("<b>$d</b>".($this->a_template['is_show_title']?"<br>$str":''), $l, $str, $p, 'target="'.$this->a_redirect['redirect_target'].'"', 1, $font):"<span class=\"$font\">$d</span>";
				}
		}else {
			$cont = $this->put_href(($str || $item_url ? "<b>$d</b>".($this->a_template['is_show_title']?"<br>$str":'') : $d), 'index.php', $str ? $str : $this->events_class->read_item($d, $m, $y, 'title'), "CLm=$m&CLd=$d&CLy=$y&name=".$this->s_calendar_index."&action=e&page=e", '', 1, $font);
		}
		$cbgc = $str ? ($cbgc ? $cbgc : $this->a_look['def_event_bgcolor']):'';
		$cbgi = $str ? ($cbgi ? $cbgi : $this->a_look['def_event_image']):($this->a_look['def_nonevent_image']?$this->a_look['def_nonevent_image']:'');
		$calign = $str ? ($calign ? $calign : $this->a_look['def_event_align']):$this->a_look['def_align'];
		$cvalign = $str ? $this->a_look['def_event_valign'] : $this->a_look['def_valign'];
		return "<td width=\"".$this->a_look['td_width']."\" height=\"".$this->a_look['td_height']."\"".($cvalign?"valign=\"$cvalign\"":'')." align=\"".($calign? $calign:'center')."\" ".($cbgc?" bgcolor=\"$cbgc\"":"$color")." ".($cbgi?"background=\"$cbgi\"":'').">".$cont."</td>";
	}
	/*
	function put_href
	input parameters:
		$str - HTML link text, $link - HTML link reference, $title - HTML link title, $params - additional parameters for reference, $adds - some other additional parameters for HTML link tag, $only_this - show use or not current GET and POST parameters for link reference, $font - $font - CSS style name for current day text
	used parameters:
		$is_Admin, $a_look, $s_calendar_index, $a_template, $a_redirect
	used methods:
		none
	action:
		make and return HTML link tag for given parameters
	return:
		HTML link tag for certain parameters
	*/
	function put_href($str, $link, $title, $params, $adds = '', $only_this = 0, $font = '') {
		global $_GET, $_POST, $_SERVER;
		list($_GL) = split('\?', $_SERVER['REQUEST_URI']);
		$link = $link ? $link : $_GL;
		$_p = split("&", $params);
		foreach($_p as $k => $v) {
			list($ke, $va) = split("=", $v);
			$PAR[$ke] = $va;
		}
		if(!$this->is_Admin)$p = array_merge($_POST, $_GET, $PAR);
		else $p = array_merge($_GET, $PAR);
		foreach($p as $k =>$v)$vars[] = "$k=$v";
		$par[] = is_array($vars) ? join("&", $vars) : '';
		$params = $only_this ? $params : join("&", $par);
		$params=str_replace(" ",'',$params);
		$title = htmlspecialchars($title);
		ereg("name=([^&]+)",$params,$res);
		$name=urlencode($res[1]);
		$params=ereg_replace("name=([^&]+)","name=".$name,$params);
		return "<a href=\"$link".($params ? "?$params" : '')."\"".($title ? " title=\"$title\"" : '')."$adds>".($font?"<span class=\"$font\">":'').$str.($font?"</span>":"")."</a>";
	}
	/*
	function style_bg
	input parameters:
		$bgcolor - background color, $align - alignment station
	action:
		make and return HTML background color and alignment clause
	return:
		HTML background color and alignment clause for certain parameters
	*/
	function style_bg($bgcolor, $align = 'center') {
		return "bgcolor=\"$bgcolor\" align=\"$align\"";
	}
	/*
	function W_N
	input parameters:
		$d - day number
	used parameters:
		$a_selected_date
	used methods:
		none
	action:
		make and return week number for certain day
	return:
		week number for certain day
	*/
	function W_N($d){
		$w = date('W', mktime(0, 0, 1, $this->a_selected_date['m'], $d, $this->a_selected_date['y']));
		if($w>53) return 1;
		else return $w;
	}
	/*
	function make_date
	input parameters:
		$d - day number, $m - month number, $y - year number, $format - date format
	used parameters:
		$a_localization
	used methods:
		get_date
	action:
		make and return formatted date for certain date
	return:
		formatted date for certain date
	*/
	function make_date($m, $y, $format,$d=1){
		$m = date('m', mktime(0, 0, 0, $m, $d, $y));
		if(strstr($format, 'M')) {
			$date = date($format, mktime(0, 0, 0, $m, $d, $y));
			return str_replace($this->get_date('M', mktime(0, 0, 0, $m, $d, $y)), $this->a_localization['months'][(int)$m-1], $date);
		}else {
			return $this->get_date($format, mktime(0, 0, 0, $m, $d, $y));
		}
	}
	/*
	function get_date
	input parameters:
		$time - date info in unixtime format, $format - date format
	used parameters:
		$a_template
	used methods:
		none
	action:
		make and return formatted date for certain date taking into account's time zone
	return:
		formatted date for certain date taking into account's time zone
	*/
	function get_date($format,$time=0){
		$timezone = $this->a_template['timezone'];
		if(!$time)$time=time();
		if(!$timezone) $timezone=date('Z');
		else $timezone = $timezone*3600;
		return date($format,$time);
	}
	/*
	function cross_interval
	input parameters:
		$int_s_1 - start first interval, $int_e_1 - end first interval, $int_s_2 - start second interval, $int_e_2 - end second interval,
	used parameters:
		none
	used methods:
		none
	action:
		determine if these intervals are crossing (use for DIVs location)
	return:
		true if these intervals are crossing else return false
	*/
	function cross_interval($int_s_1,$int_e_1,$int_s_2,$int_e_2){
		if($int_s_1 >= $int_s_2 && $int_s_1 <= $int_e_2) return true;
		if($int_e_1 >= $int_s_2 && $int_e_1 <= $int_e_2) return true;
		if($int_s_2 >= $int_s_1 && $int_s_2 <= $int_e_1) return true;
		if($int_e_2 >= $int_s_1 && $int_e_2 <= $int_e_1) return true;
		return false;
	}
	/*
	function shift_right
	input parameters:
		$k current DIV parameters
	used parameters:
		$pos
	used methods:
		cross_interval, shift_right
	action:
		location DIVs on the page
	*/
	function shift_right($k){
		foreach($this->pos as $key=>$value){
			if($value['v']->id != $k['v']->id){
				if($this->cross_interval($k['y_s'], $k['y_e'], $value['y_s'], $value['y_e']) && $this->cross_interval($k['x_s'], $k['x_s'] + $k['width'], $value['x_s'], $value['x_s'] + $value['width']) && $value['set']){
					$k['x_s'] = $value['x_s'] + $value['width'] + 1;
					$k['set'] = true;
					return $this->shift_right($k);
				}
			}
		}
		$k['set'] = true;
		return $k;
	}
	/*
	function cmp
	input parameters:
		$a, $b - value arrays
	action:
		user's function for array sort
	return:
		sorted array
	*/
	function cmp ($a, $b) {
		if ($a['y_s'] == $b['y_s']) return 0;
		return ($a['y_s'] > $b['y_s']) ? -1 : 1;
	}
	/*
	function arr_sort
	input parameters:
		$_a, $_b - value arrays
	action:
		user's function for array sort
	return:
		sorted array
	*/
	function arr_sort ($_a, $_b) {
		$a = (int)count($_a);
		$b = (int)count($_b);
		if ($a == $b) return 0;
		return ($a > $b) ? -1 : 1;
	}
	/*
	function sort_cross
	input parameters:
		$_a, $_b - value arrays
	action:
		user's function for array sort
	return:
		sorted array
	*/
	function sort_cross($_a, $_b){
		$a = count($_a['at_line_data']);
		$b = count($_b['at_line_data']);
		if ($a == $b) return 0;
		return ($a > $b) ? -1 : 1;
	}
	/*
	function is_linear
	input parameters:
		$ar
	action:
		determine if DIVs (specified by array) are linear relatively x coordinate
	*/
	function is_linear($ar){
		foreach($ar as $k=>$v) if(count($ar) > count(array_intersect($ar,$this->pos[$v]['at_line_data']))) return false;
		return true;
	}
	/*
	function sort_by_time_start
	input parameters:
		$_a, $_b - value arrays
	action:
		user's function for array sort
	return:
		sorted by start time array
	*/
	function sort_by_time_start($_a,$_b){
		$a = $_a->time_start['h'] * 60 + $_a->time_start['m'];
		$b = $_b->time_start['h'] * 60 + $_b->time_start['m'];;
		if ($a == $b) return 0;
		return ($a < $b) ? -1 : 1;
	}
	/*
	function show_event
	input parameters:
		none
	used parameters:
		$a_selected_date, $a_template, $s_calendar_index
	used methods:
		events_class->read_items, read_file
	action:
		make and return to the browser formatted event list
	*/
	function show_event() {
		$items = $this->events_class->read_items($this->a_selected_date['d'], $this->a_selected_date['m'], $this->a_selected_date['y']);
		$head = $this->read_file('header');
		$head = str_replace('$date', date ('d M, Y',mktime(0,0,0,$this->a_selected_date['m'],$this->a_selected_date['d'],$this->a_selected_date['y'])), $head);
		echo $head;
		if(is_array($items)){
			uasort($items,array('calendar','sort_by_time_start'));
			foreach($items as $k => $v) {
				if($v->title){
					if($v->is_time){
						if($this->a_template['time_format'])
							$time = ($v->time_start['h']>11?($v->time_start['h']-12).':'.$v->time_start['m']." pm":$v->time_start['h'].':'.$v->time_start['m']." am").' - '.($v->time_end['h']>11?($v->time_end['h']-12).':'.$v->time_end['m']." pm":$v->time_end['h'].':'.$v->time_end['m']." am");
						else $time = $v->time_start['h'].':'.$v->time_start['m'].' - '.$v->time_end['h'].':'.$v->time_end['m'];
					}
					else $time = '&nbsp';
					$c = $this->a_template['event_list_templ'];
					$c = str_replace('$num', ++$i, $c);
					$c = str_replace('$time', $time, $c);
					$c = str_replace('$date',date ('d M, Y',mktime(0,0,0,$this->a_selected_date['m'],$v->day,$this->a_selected_date['y'])), $c);
					$c = str_replace('$title', $v->title, $c);
					echo str_replace('$body', $v->body, $c);
				}
			}
		}
		echo $this->read_file('footer','_'.$this->s_calendar_index.'.html');
	}
	function show_month_event() {
		$items = $this->events_class->read_items(0, $this->a_selected_date['m'], $this->a_selected_date['y']);
		$head = $this->read_file('header');
		$head = str_replace('$date', date ('M, Y',mktime(0,0,0,$this->a_selected_date['m'],1,$this->a_selected_date['y'])), $head);
		echo $head;
		if(is_array($items)){
			uasort($items,array('calendar','sort_by_time_start'));
			foreach($items as $k => $v) {
				if($v->title){
					if($v->is_time){
						if($this->a_template['time_format'])
							$time = ($v->time_start['h']>11?($v->time_start['h']-12).':'.$v->time_start['m']." pm":$v->time_start['h'].':'.$v->time_start['m']." am").' - '.($v->time_end['h']>11?($v->time_end['h']-12).':'.$v->time_end['m']." pm":$v->time_end['h'].':'.$v->time_end['m']." am");
						else $time = $v->time_start['h'].':'.$v->time_start['m'].' - '.$v->time_end['h'].':'.$v->time_end['m'];
					}
					else $time = '&nbsp';
					$c = $this->a_template['event_list_templ'];
					$c = str_replace('$num', ++$i, $c);
					$c = str_replace('$time', $time, $c);
					$c = str_replace('$date', date ('d M, Y',mktime(0,0,0,$this->a_selected_date['m'],$v->day,$this->a_selected_date['y'])), $c);
					$c = str_replace('$title', $v->title, $c);
					echo str_replace('$body', $v->body, $c);
				}
			}
		}
		echo $this->read_file('footer','_'.$this->s_calendar_index.'.html');
	}
	/*
	function show_day
	input parameters:
		none
	used parameters:
		$a_selected_date, $a_template, $s_calendar_index
	used methods:
		events_class->read_items, cross_interval, is_linear
	action:
		make and return to the browser formatted event list for selected day (used in Control panel)
	*/
	function show_day(){
		global $a_groups,$__SESSION__;
		$items = $this->events_class->read_items($this->a_selected_date['d'], $this->a_selected_date['m'], $this->a_selected_date['y']);
		if(is_array($items)){
			foreach($items as $k => $v){
				if(is_numeric($k)){
					if(!$v->is_time)$item1[$k] = $v;
					else $item[$k] = $v;
				}
			}
		}
		$items = $item1;
		if(is_array($items)){
			$j=0;
			foreach($items as $k => $v) {
					if(!$j) echo '<table border="0" cellpadding="3" cellspacing="1" width="100%">';
				?>
				<tr>
					<td><b><?php echo $v->title?></b></td>
					<td width="10"><?php if($a_groups[$__SESSION__['group']]['ev_edit'] || $__SESSION__['user'] == $v->owner){?>[<a href="javascript:document.doit.dele.value = <?php echo ($v->id + 1)?>;document.doit.submit()">delete</a>]<?php }else echo '&nbsp;'?></td>
					<td width="10"><?php if($a_groups[$__SESSION__['group']]['ev_edit'] || $__SESSION__['user'] == $v->owner){?>[<a href="javascript:document.doit.edit.value = <?php echo ($v->id + 1)?>;document.doit.submit()">edit</a>]<?php }else echo '&nbsp;'?></td>
					<td width="10"><?php if($j) {?>[<a href="javascript:document.doit.up.value=<?php echo ($k + 1)?>;document.doit.submit()">up</a>]<?php }else {echo "&nbsp;";}?></td>
					<td width="10"><?php if((count($items) - 1)>$j) {?>[<a href="javascript:document.doit.down.value=<?php echo ($k + 1)?>;document.doit.submit()">down</a>]<?php }else {echo "&nbsp;";}?></td>
				</tr>
				<?php 
					$j++;
			}
			if($j) echo '</table>';
		}
		if($this->a_template['time_gradation']){
		?><table cellpadding="0" cellspacing="0" width="100%" border="0">
				<tr>
				<td bgcolor="#4682B4">
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
		<?php 
		for($i=0;$i<24;$i++){
			if($this->a_template['time_format'] == 1){
				$_h = date("h:i A",mktime($i,0,0,1,1,1));
			}else{
				$_h = $i.":00";
			}
		?>
				<tr>
					<td align="center" valign="top" bgcolor="#DBEAF5" width="50" height="30"><?php echo $_h?></td>
					<td bgcolor="#ffffff"><img src="img/pixel.gif" height="30" width="1" border="0" id="et<?php echo $i?>" name="et<?php echo $i?>"></td>
				</tr>
		<?php 
		}?></table></td></tr></table><?php 
		$items = $item;
		if(is_array($items)) {
			foreach($items as $k => $v) {
				$this->pos[$v->id] = array(
					'y_s' => $v->time_start['h'] * 60 + $v->time_start['m'],
					'y_e' => $v->time_end['h'] * 60 + $v->time_end['m'],
					'x_s' => 0,
					'width' => 625,
					'v' => $v,
					'at_line_data' => array($v->id)
					);
			}
			
			foreach($this->pos as $k => $v) {
				foreach($this->pos as $key => $value) {
					if($key != $k){
						if($this->cross_interval($v['y_s'], $v['y_e'], $value['y_s'], $value['y_e'])){
							$this->pos[$k]['at_line_data'][] = $key;
						}
					}
				}
			}
			uasort($this->pos,array ("calendar", "sort_cross"));
			$set_data = array();
			foreach($this->pos as $k => $v) {
				if(count($v['at_line_data']) > 1) {
					$max = 0;
					$max_data = array();
					$diff_width = 0;
					$max_data2 = array();
					foreach($v['at_line_data'] as $key=>$value){
						if($k != $value){
							$at_line = $this->pos[$value]['at_line_data'];
							if($this->is_linear($at_line)){
								if(count($at_line)>$max){
									$max = count($at_line);
									$max_data = $at_line;
								}
							}
						}
					}
					if(!$max){
						$max = count($v['at_line_data']);
						$max_data = $v['at_line_data'];
					}
					foreach($max_data as $key=>$value){
						if(in_array($value,$set_data)) $diff_width += $this->pos[$value]['width'];
						else $max_data2[]=$value;
					}
					foreach($max_data2 as $key=>$value){
						$this->pos[$value]['width'] = ceil((625-$diff_width)/count($max_data2));
						$this->pos[$value]['set_width'] = true;
						$set_data[] = $value;
					}
				}else{
					$this->pos[$k]['width'] = 625;
				}
			}
			uasort ($this->pos,  array ("calendar", "cmp"));
			$i = 0;
			foreach($this->pos as $k => $v) {
				if($i > 0) {
					$this->pos[$k] = $this->shift_right($v);
				}else{
					$this->pos[$k]['set'] = true;
				}
				$i++;
			}
		}
		if(is_array($this->pos)) {
			foreach($this->pos as $k => $v) {
				$_s = $v['v']->time_start['h'] * 60 + $v['v']->time_start['m'];
				$_e = $v['v']->time_end['h'] * 60 + $v['v']->time_end['m'];
				$dur = $_e - $_s;
				$dur_m = $dur%60;
				$dur_h = ($dur - $dur_m)/60;
				if($this->a_template['time_format'] == 1){
					$start = date("h:i A",mktime($v['v']->time_start['h'],$v['v']->time_start['m'],0,1,1,1));
					$end =  date("h:i A",mktime($v['v']->time_end['h'],$v['v']->time_end['m'],0,1,1,1));
				}else{
					$start = $v['v']->time_start['h'].':'.$v['v']->time_start['m'];
					$end = $v['v']->time_end['h'].':'.$v['v']->time_end['m'];
				}
				?>
					<div id="event<?php echo $k?>" class = "event_leyer" style="position:absolute; width:250px; height: 20px; z-index:2; left: 268px; top: 10px;">
					<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td colspan="3"><a href="#" onclick="return false" title="<?php echo substr($v['v']->body,0,30)."\r Length: ".($dur_h ? $dur_h.'hr ' : '').($dur_m ? $dur_m.'min':'')?>"><b><?php echo substr($v['v']->title,0,16)?></b></a></td>
					</tr>
					<tr>
						<td><?php echo $start.' - '.$end?> </td>
						<td><?php if($a_groups[$__SESSION__['group']]['ev_edit'] || $__SESSION__['user'] == $v['v']->owner){?>[<a href="javascript:document.doit.dele.value = <?php echo ($v['v']->id + 1)?>;document.doit.submit()">delete</a>]<?php }else echo '&nbsp;'?></td>
						<td><?php if($a_groups[$__SESSION__['group']]['ev_edit'] || $__SESSION__['user'] == $v['v']->owner){?>[<a href="javascript:document.doit.edit.value = <?php echo ($v['v']->id + 1)?>;document.doit.submit()">edit</a>]<?php }else echo '&nbsp;'?></td>
					</tr>
					</table>
					</div>
				<?php 
$js_pos[] = "set_pos(".$v['v']->time_start['h'].",".$v['v']->time_start['m'].",".$v['v']->time_end['h'].",".$v['v']->time_end['m'].",'event".$v['v']->id."','et',".$v['x_s'].",".$v['width'].");";
			}
		}
		if(is_array($js_pos)){
			echo '<script language="JavaScript" type="text/javascript">var max_width = 625;function event_pos(){'.join("\n",$js_pos).'}</script>';
		}
		}
	}
	/*
	function show_week
	input parameters:
		none
	used parameters:
		$a_selected_date, $a_template, $s_calendar_index
	used methods:
		events_class->read_items, cross_interval, is_linear
	action:
		make and return to the browser formatted event list for selected week (used in Control panel)
	*/
	function show_week(){
		$cw = date('W',mktime(0, 0, 0, $this->a_selected_date['m'], $this->a_selected_date['d'], $this->a_selected_date['y']))+1;
		$dwf = date('w',mktime(0, 0, 0, 1, 1, $this->a_selected_date['y']));
		if($this->a_template['is_american'] != 1) $dwf or $dwf = 7;
		$cd = ($cw-1)*7 - $dwf + 1 + !$this->a_template['is_american'];
		echo '<table cellpadding="0" cellspacing="0" width="100%" border="0"><tr><td bgcolor="#4682B4"><table width="100%" border="0" cellpadding="0" cellspacing="1"><tr><td class="header2" width="20">&nbsp;</td>';
		$c = 0;
		for($i = $cd;$i < $cd+7;$i++){
			echo '<td class="header2" width="95">'.date('l, d',mktime(0, 0, 0, 1, $i, $this->a_selected_date['y']))."</td>";
			$dates[$c]['d'] = date('d',mktime(0, 0, 0, 1, $i, $this->a_selected_date['y']));
			$m = date('m',mktime(0, 0, 0, 1, $i, $this->a_selected_date['y']));
			$items[$c] = $this->events_class->read_items($dates[$c++]['d'], $m, $this->a_selected_date['y']);

		}
		echo '</tr><tr><td bgcolor="#dbeaf5">&nbsp;</td>';
		for($i=0;$i<7;$i++){
			$item = $items[$i];

			echo '<td bgcolor="'.((!$i && $this->a_template['is_american']) || $i == 6 || ($i == 5 && !$this->a_template['is_american'])?'#dbeaf5':'#ffffff').'">';
			if(is_array($item)) {
				?><table border="0" cellpadding="3" cellspacing="1" width="100%"><?php 
				foreach($item as $k => $v) {
					if(is_numeric($k) && !$v->is_time){?>
					<tr>
						<td><b><?php echo $v->title?></b></td>
					</tr>
					<?php 
					$j++;
					}
				}
				if(!$j)echo "<tr><td>&nbsp;</td></tr>";
				?></table><?php 
			}
			echo '</td>';
		}
		echo "</tr>";
		if($this->a_template['time_gradation']){
		for($i=0;$i<24;$i++){
			if($this->a_template['time_format'] == 1){
				$_h = date("h:i A",mktime($i,0,0,1,1,1));
			}else{
				$_h = $i.":00";
			}

		?>
		<tr>
			<td align="center"  bgcolor="#DBEAF5" valign="top" width="50" height="30"><?php echo $_h?></td>
			<td bgcolor="<?php echo ($this->a_template['is_american']?'#dbeaf5':'#ffffff')?>"><img src="img/pixel.gif" height="30" width="1" border="0" id="et<?php echo $dates[0]['d']."_".$i?>" name="et<?php echo $dates[0]['d']."_".$i?>"></td>
			<td bgcolor="#ffffff"><img src="img/pixel.gif" height="30" width="1" border="0" id="et<?php echo $dates[1]['d']."_".$i?>" name="et<?php echo $dates[1]['d']."_".$i?>"></td>
			<td bgcolor="#ffffff"><img src="img/pixel.gif" height="30" width="1" border="0" id="et<?php echo $dates[2]['d']."_".$i?>" name="et<?php echo $dates[2]['d']."_".$i?>"></td>
			<td bgcolor="#ffffff"><img src="img/pixel.gif" height="30" width="1" border="0" id="et<?php echo $dates[3]['d']."_".$i?>" name="et<?php echo $dates[3]['d']."_".$i?>"></td>
			<td bgcolor="#ffffff"><img src="img/pixel.gif" height="30" width="1" border="0" id="et<?php echo $dates[4]['d']."_".$i?>" name="et<?php echo $dates[4]['d']."_".$i?>"></td>
			<td bgcolor="<?php echo ($this->a_template['is_american']?'#ffffff':'#dbeaf5')?>"><img src="img/pixel.gif" height="30" width="1" border="0" id="et<?php echo $dates[5]['d']."_".$i?>" name="et<?php echo $dates[5]['d']."_".$i?>"></td>
			<td bgcolor="#dbeaf5"><img src="img/pixel.gif" height="30" width="1" border="0" id="et<?php echo $dates[6]['d']."_".$i?>" name="et<?php echo $dates[6]['d']."_".$i?>"></td>
		</tr>
		<?php 
		}
		echo '</table></td></tr></table>';
		for($i=0;$i<=6;$i++){
			$item = $items[$i];
			$this->pos = array();
			$max_width = 95;
			if(is_array($item)) {
				$this->pos=array();
				foreach($item as $k => $v) {
					$this->pos[$v->id] = array(
						'y_s' => $v->time_start['h'] * 60 + $v->time_start['m'],
						'y_e' => $v->time_end['h'] * 60 + $v->time_end['m'],
						'x_s' => 0,
						'width' => $max_width,
						'v' => $v,
						'at_line_data' => array($v->id)
						);
				}
				foreach($this->pos as $k => $v) {
					foreach($this->pos as $key => $value) {
						if($key != $k){
							if($this->cross_interval($v['y_s'], $v['y_e'], $value['y_s'], $value['y_e'])){
								$this->pos[$k]['at_line_data'][] = $key;
							}
						}
					}
				}
				uasort($this->pos,array ("calendar", "sort_cross"));
				$set_data = array();
				foreach($this->pos as $k => $v) {
					if(count($v['at_line_data']) > 1) {
						$max = 0;
						$max_data = array();
						$diff_width = 0;
						$max_data2 = array();
						foreach($v['at_line_data'] as $key=>$value){
							if($k != $value){
								$at_line = $this->pos[$value]['at_line_data'];
								if($this->is_linear($at_line)){
									if(count($at_line) > $max){
										$max = count($at_line);
										$max_data = $at_line;
									}
								}
							}
						}
						if(!$max){
							$max = count($v['at_line_data']);
							$max_data = $v['at_line_data'];
						}
						foreach($max_data as $key=>$value){
							if(in_array($value,$set_data)) $diff_width += $this->pos[$value]['width'];
							else $max_data2[]=$value;
						}
						foreach($max_data2 as $key=>$value){
							$this->pos[$value]['width'] = ceil(($max_width-$diff_width)/count($max_data2));
							$this->pos[$value]['set_width'] = true;
							$set_data[] = $value;
						}
					}else{
						$this->pos[$k]['width'] = $max_width;
					}
				}
				uasort ($this->pos,  array ("calendar", "cmp"));
				$j = 0;
				foreach($this->pos as $k => $v) {
					if($j > 0) {
						$this->pos[$k] = $this->shift_right($v);
					}else{
						$this->pos[$k]['set'] = true;
					}
					$j++;
				}
			}

		if(is_array($this->pos)) {
			foreach($this->pos as $k => $v) {
				$_s = $v['v']->time_start['h'] * 60 + $v['v']->time_start['m'];
				$_e = $v['v']->time_end['h'] * 60 + $v['v']->time_end['m'];
				$dur = $_e - $_s;
				$dur_m = $dur%60;
				$dur_h = ($dur - $dur_m)/60;
				if($this->a_template['time_format'] == 1){
					$start = date("h:i A",mktime($v['v']->time_start['h'],$v['v']->time_start['m'],0,1,1,1));
					$end =  date("h:i A",mktime($v['v']->time_end['h'],$v['v']->time_end['m'],0,1,1,1));
				}else{
					$start = $v['v']->time_start['h'].':'.$v['v']->time_start['m'];
					$end = $v['v']->time_end['h'].':'.$v['v']->time_end['m'];
				}
					if($v['v']->is_time){?>
						<div id="event<?php echo $k.'_'.$i?>" class = "event_leyer" style="position:absolute; width:250px; height: 20px; z-index:2; left: 268px; top: 10px;">
						<table border="0" cellpadding="3" cellspacing="1">
						<tr>
							<td>
							<a href="#" onclick="return false" title="<?php echo $v['v']->title."\n ".$start.' - '.$end."\nLength: ".($dur_h ? $dur_h.'hr ' : '').($dur_m ? $dur_m.'min':'')?>"><b><?php echo substr($v['v']->title,0,5)?></b></a></td>
						</tr>
						</table>
						</div>
					<?php 
					$js_pos[] =  "set_pos(".$v['v']->time_start['h'].",".$v['v']->time_start['m'].",".$v['v']->time_end['h'].",".$v['v']->time_end['m'].",'event".$v['v']->id.'_'.$i."','et".$dates[$i]['d']."_',".$v['x_s'].",".$v['width'].");";
					}
				}
			}
		}
		if(is_array($js_pos)){
			echo '<script language="JavaScript" type="text/javascript">var max_width = 95;function event_pos(){'.join("\n",$js_pos).'}</script>';
		}
		}else echo '</table></td></tr></table>';
	}
	/*
	function show_month
	input parameters:
		none
	used parameters:
		$a_template, $a_look
	used methods:
		show_calendar
	action:
		make and return to the browser formatted event list for selected mouth (used in Control panel)
	*/
	function show_month(){
		$this->a_template['is_show_title'] = 1;
		$this->a_look['td_width'] = 100;
		$this->a_look['td_height'] = 100;
		$this->a_look['def_align'] = 'left';
		$this->a_look['def_valign'] = 'top';
		$this->show_calendar();
	}
	/*
	function show_year
	input parameters:
		none
	used parameters:
		$a_selected_date, $a_template, $a_look
	used methods:
		show_h
	action:
		make and return to the browser formatted event list for selected year (used in Control panel)
	*/
	function show_year(){
		echo '<table width="100%" border="0" cellpadding="3" cellspacing="1">';
		for($i = 1;$i<=12;$i++){
			$this->a_template['is_show_title'] = 0;
			$this->a_template['show_year'] = 1;
			$this->a_look['td_width'] = 25;
			$this->a_look['td_height'] = 25;
			$this->a_look['def_align'] = 'center';
			$this->a_look['def_valign'] = 'midle';
			$this->a_selected_date['m'] = $i;
			$this->a_selected_date['d'] = 0;
			if($i == 1 || !(($i-1)%3)) echo "<tr>";
			echo '<td valign="top">';
			$this->show_h();
			echo "</td>";
			if(!($i%3)) echo "</tr>";
		}
		echo '</table>';
	}
	/*
	function show_admin
	input parameters:
		$type - showing what the views need to be show
	used parameters:
		none
	used methods:
		show_day, show_week, show_month, show_year
	action:
		choose and call corresponding function for calendar showing
	*/
	function show_admin($type) {
		switch($type){
			case 1:
			$this->show_day();
			break;
			case 2:
			$this->show_week();
			break;
			case 3:
			$this->show_month();
			break;
			case 4:
			$this->show_year();
			break;
		}
	}
	/*
	function use_config
	input parameters:
		$type - showing what the views need to be show
	used parameters:
		$s_DataDir, $is_admin, $is_created, $s_calendar_index
	used methods:
		exist, copy_data, show_month, read_data
	action:
		read from file data for current calendar
	return:
		data for current calendar
	*/
	function use_config(){
		$f = $this->s_DataDir."config".$this->s_calendar_index.".php";
		$fb = $this->s_DataDir."config".$this->s_calendar_index."_bak.php";
		if($this->is_admin && $this->exist($fb)) $file = $fb;
		else $file = $f;
		if(!$this->exist($fb) && $this->exist($f) && $this->is_created) {
			if(!$this->copy_data($f, $fb)) return false;
		}
		if(!$s = read_data($file)) return false;
		return is_array($s) ? $s : array();
	}
	/*
	function reset_default
	input parameters:
		none
	used parameters:
		$s_DataDir, $s_calendar_index
	used methods:
		db->put_data
	action:
		reset current calendar data to default values
	*/
	function reset_default() {
		global $db;
		include $path_to_data."config_def.php";
		$settings['events_file'] = $settings['events_file'].$this->s_calendar_index.".dat";
		$fb = $this->s_DataDir."config".$name."_bak.php";
		$db->put_data($settings, $fb);
	}
	/*
	function reset_conf
	input parameters:
		none
	used parameters:
		$s_DataDir, $s_calendar_index
	used methods:
		copy_data
	action:
		create backup copy for current calendar data file
	*/
	function reset_conf() {
		$f = $this->s_DataDir."config".$this->s_calendar_index.".php";
		$fb = $this->s_DataDir."config".$this->s_calendar_index."_bak.php";
		$this->copy_data($f, $fb);
	}
	/*
	function save_conf
	input parameters:
		none
	used parameters:
		$s_DataDir, $s_calendar_index
	used methods:
		copy_data
	action:
		restore backup copy for current calendar data file and delete backup
	*/
	function save_conf() {
		$f = $this->s_DataDir."config".$this->s_calendar_index.".php";
		$fb = $this->s_DataDir."config".$this->s_calendar_index."_bak.php";
		$this->copy_data($fb, $f);
		$this->drop_data($fb);
	}
	/*
	function save_conf
	input parameters:
		$name - filename
	used parameters:
		none
	used methods:
		none
	action:
		check if the file exists
	*/
	function exist($name){
		return is_file($name);
	}
	/*
	function copy_data
	input parameters:
		$form - filename
		$to - filename
	used parameters:
		none
	used methods:
		none
	action:
		copy data from $from file to $to file
	*/
	function copy_data($from, $to){
		@copy($from, $to);
	}
	/*
	function read_file
	input parameters:
		$file - filename
		$ext - file extension
	used parameters:
		$s_DataDir, $s_calendar_index
	used methods:
		none
	action:
		read data from certain file
	*/
	function read_file($file,$ext='.html',$all = 0){
		global $__SESSION__;
		if($all){
			$file = $this->s_DataDir.$file.$ext;
			if(is_file($file)) $__SESSION__[$file] = filemtime($file);
			if($fp = @fopen($file, 'r')) {
				while (!feof($fp)) {
					$c .= fgets($fp, 4096);
				}
				fclose($fp);
				return $c;
			}else {
				echo "Can't open $file file.<br>Please, check permissions. For more details see <a href='http://www.softcomplex.com/products/php_event_calendar/docs/index.html#installation'>Installation Instructions</a></b><br>";
			}
		}
		if(is_file($this->s_DataDir.$file."_".$this->s_calendar_index.$ext)){
			$file = $this->s_DataDir.$file."_".$this->s_calendar_index.$ext;
			if(is_file($file)) $__SESSION__[$file] = filemtime($file);
			if($fp = @fopen($file, 'r')) {
				while (!feof($fp)) {
					$c .= fgets($fp, 4096);
				}
				fclose($fp);
				return $c;
			}else {
				echo "Can't open $file file.<br>Please, check permissions. For more details see <a href='http://www.softcomplex.com/products/php_event_calendar/docs/index.html#installation'>Installation Instructions</a></b><br>";
			}
		}else{
			
			$file = $this->s_DataDir.$file."_def.html";
			if(is_file($file)) $__SESSION__[$file] = filemtime($file);
			if($fp = @fopen($file, 'r')) {
				while (!feof($fp)) {
					$c .= fgets($fp, 4096);
				}
				fclose($fp);
				return $c;
			}else {
				echo "Can't open $file file.<br>Please, check permissions. For more details see <a href='http://www.softcomplex.com/products/php_event_calendar/docs/index.html#installation'>Installation Instructions</a></b><br>";
			}
		}
		return false;
	}
	/*
	function put_config
	input parameters:
		none
	used parameters:
		$s_DataDir, $s_calendar_index, $a_redirect, $a_template, $a_localization, $a_look
	used methods:
		db->put_data
	action:
		make single array for calendar parameters and put it to file
	*/
	function put_config() {
		global $db;
		$file = $this->s_DataDir."config".$this->s_calendar_index.".php";
		$s = array(
		'REDIRECT' => $this->a_redirect,
		'TEMPLATE' => $this->a_template,
		'LOCALIZATION' => $this->a_localization,
		'LOOK' => $this->a_look
		);
		$db->put_data($s, $file);
	}
	/*
	function apply_put_config
	input parameters:
		none
	used parameters:
		$s_DataDir, $s_calendar_index, $a_redirect, $a_template, $a_localization, $a_look
	used methods:
		db->put_data
	action:
		make single array for calendar parameters and put it to backup file
	*/
	function apply_put_config() {
		global $db;
		$file = $this->s_DataDir."config".$this->s_calendar_index."_bak.php";
		$s = array(
		'REDIRECT' => $this->a_redirect,
		'TEMPLATE' => $this->a_template,
		'LOCALIZATION' => $this->a_localization,
		'LOOK' => $this->a_look
		);
		$db->put_data($s, $file);
	}
	/*

	/*
	function put_in_file
	input parameters:
		$file - filename, $data - calendar data array
	used parameters:
		$_GET, $_POST
	used methods:
		f_modify
	action:
		serialize array and put it into the certain file
	*/
	function put_in_file($file, $data){
		if($fp = @fopen($file, 'w+')) {
			fwrite($fp, stripslashes($data));
			fclose($fp);
		}else echo "Can't create $file file";
	}
	/*
	function drop_data
	input parameters:
		$name - filename
	action:
		delete certain file
	*/
	function drop_data($name){
		@unlink($name);
	}
}
/*
function drop_data
input parameters:
	$from - filename
action:
	read data from certain file and unserialize it
*/
function read_data($from){
	if(!$from){
		user_error("Event calendar :: read_data() - Failed to open file:".$from,E_USER_ERROR);
		return false;
	}
	if($fp = @fopen($from, 'r')) {
		while (!feof($fp)) {
			$c .= fgets($fp, 4096);
		}
		$s = unserialize($c);
		fclose($fp);
	}else{
		echo "Can't open $from file.<br>Please, check permissions. For more details see <a href='http://www.softcomplex.com/products/php_event_calendar/docs/index.html#installation'>Installation Instructions</a></b><br>";
	}
	return $s;
}

$calendar = new calendar();
include $calendar->s_FilesDir."db.php";
include $calendar->s_FilesDir."events.php";


?>