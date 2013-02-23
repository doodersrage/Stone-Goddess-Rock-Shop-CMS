<?php 
// Title: PHP Event Calendar
// URL: http://www.softcomplex.com/products/php_event_calendar/
// Version: 1.5.1
// Date: 03/04/2005 (mm/dd/yyyy)
// Tech. support: http://www.softcomplex.com/forum/forumdisplay.php?fid=55
// Notes: Script is free for non commercial use. Visit official site for details.

class event{
	var $id; //event ID
	var $title; //event title
	var $body; //event body
	var $time_start; //event start time
	var $time_end; //event finish time
	var $is_time; //show if time gradation is exists for current event
	var $repeat; //show if current event is recurrent event
	var $e_date; //event date
	var $frequency; //event recurrent frequency
	var $start_date; //event start date
	var $finish_date; //event finish date
	var $owner; //event owner
	var $align; //alignment for current event cell
	var $bg_color; //background color for current event cell
	var $bg_image; //background image for current event cell
	/*
	function event
	input parameters:
		$argv - event parameters array
	used parameters:
		all
	used methods:
		none
	action:
		constructor event class.
	*/
	function event($argv){
		global $__SESSION__;
		foreach($argv as $k=>$v){
			$this->$k = $v;
		}
		$this->owner = $__SESSION__['user'];
	}
	/*
	function set_param
	input parameters:
		$title - parameter name, $value - parameter value
	used parameters:
		all
	used methods:
		none
	action:
		set corresponding parameter to certain value
	*/
	function set_param($title,$value){
		$this->$title = $value;
	}
}

class events{
	var $db_class; //variable for DB class
	var $events_file; 
	var $events_map_file;
	var $items;
	var $items_map;

	/*
	function events
	input parameters:
		none
	used parameters:
		db_class
	used methods:
		none
	action:
		 events class constructor.
	*/
	function events(){
		global $db;
		$this->db_class = $db;
	}
	/*
	function load_item
	input parameters:
		none
	used parameters:
		items, events_file, events_map_file, items_map
	used methods:
		read_data, 
	action:
		make data arrays for current calendar
	*/
	function load_item() {
		$this->items = read_data($this->events_file);
		$this->items_map = read_data($this->events_map_file);
	}
	function str_p($str) {
		$str = eregi_replace("<script","",$str);
		$str = eregi_replace("<\/script>","",$str);
		return $str;
	}
	/*
	function read_items
	input parameters:
		$d - day, $m - month, $y - year
	used parameters:
		items, items_map
	action:
		make data array for given date
	*/
	function read_items($d,$m,$y) {
		$d=sprintf('%02.0f',$d);
		$m=sprintf('%02.0f',$m);
		$y=sprintf('%04.0f',$y);
		if($d=='00'){
			foreach($this->items_map[$y][$m] as $d=>$v){
				if(is_array($this->items_map[$y][$m][$d]))
					foreach($this->items_map[$y][$m][$d] as $k=>$v)
						if(is_numeric($k)){
							$this->items[$v]->day=$d;
							$res[]=$this->items[$v];
						}
						else $res[$k] = $v;
			}
		}else{
			if(is_array($this->items_map[$y][$m][$d]))
				foreach($this->items_map[$y][$m][$d] as $k=>$v)
					if(is_numeric($k)){
						$this->items[$v]->day=$d;
						$res[]=$this->items[$v];
					}
					else $res[$k] = $v;
		}
		return $res;
	}
	/*
	function read_item
	input parameters:
		$d - day, $m - month, $y - year, $id - event ID
	used parameters:
		items
	action:
		return data object for event specified by date and ID
	*/
	function read_item($d,$m,$y,$id) {
		$d=sprintf('%02.0f',$d);
		$m=sprintf('%02.0f',$m);
		$y=sprintf('%04.0f',$y);
		if(is_int($id)) return $this->items[$id];
		else return $this->items_map[$y][$m][$d][$id];
	}
	/*
	function get_cell_settings
	input parameters:
		$d - day, $m - month, $y - year
	used parameters:
		items, items_map
	action:
		return cell settings for event specified by date
	*/
	function get_cell_settings($d,$m,$y){
		$d=sprintf('%02.0f',$d);
		$m=sprintf('%02.0f',$m);
		$y=sprintf('%04.0f',$y);
		return array($this->items_map[$y][$m][$d]['bg_color'],$this->items_map[$y][$m][$d]['bg_image'],$this->items_map[$y][$m][$d]['align']);
	}
	/*
	function short_item
	input parameters:
		$d - day, $m - month, $y - year
	used parameters:
		items, items_map
	action:
		return event simple data array for given date
	*/
	function short_item($d,$m,$y) {
		$d=sprintf('%02.0f',$d);
		$m=sprintf('%02.0f',$m);
		$y=sprintf('%04.0f',$y);
		$ar=$this->read_items($d,$m,$y);
		if(is_array($ar))
			foreach($ar as $k=>$v){
				if(is_numeric($k)||$k===0)$res[$k]=$v;
			}
		else $res=array();
		return $res;
	}
	/*
	function save_item
	input parameters:
		none
	used parameters:
		items, items_map, events_file, events_map_file
	used methods:
		db->put_data
	action:
		put data arrays into the corresponding files
	*/
	function save_item() {
		global $db;
		$db->put_data($this->items,$this->events_file);
		$db->put_data($this->items_map,$this->events_map_file);
	}
	/*
	function add_item
	input parameters:
		$d - day, $m - month, $y - year
	action:
		add new event
	*/
	function add_item($d,$m,$y) {
		global $_POST,$calendar;
		extract($_POST);
		$d=sprintf('%02.0f',$d);
		$m=sprintf('%02.0f',$m);
		$y=sprintf('%04.0f',$y);
		$cur = mktime(0,0,0,$m,$d,$y);
		$t = (int)$t;
		$ti = $this->str_p($ti);
		$bi = $this->str_p($bi);
		if($is_time){
			if($calendar->a_template['time_format'] == 1){
				$s_time_hour = $s_time_hour==12 && $s_time_type ? 12:($s_time_hour==12 && !$s_time_type ? 0:($s_time_type? 12 + $s_time_hour : $s_time_hour));
				$e_time_hour = $e_time_hour==12 && $e_time_type ? 12:($e_time_hour==12 && !$e_time_type ? 0:($e_time_type? 12 + $e_time_hour : $e_time_hour));
			}
			if((int)$s_time_hour > 23) $s_time_hour = 23;
			if((int)$s_time_hour < 0) $s_time_hour = 0;
			if((int)$e_time_hour > 23) $e_time_hour = 23;
			if((int)$e_time_hour < 0) $e_time_hour = 0;
			if((int)$s_time_min > 59) $s_time_min = 59;
			if((int)$s_time_min < 0) $s_time_min = 0;
			if((int)$e_time_min > 59) $e_time_min = 59;
			if((int)$e_time_min < 0) $e_time_min = 0;
			if($e_time_hour.$e_time_min < $s_time_hour.$s_time_min) $e_time_hour = $s_time_hour+1;
			$add_par = array('is_time' => 1,'time_start'=>array('h'=>$s_time_hour,'m'=>sprintf('%02.0f',$s_time_min)),'time_end'=>array('h'=>$e_time_hour,'m'=>sprintf('%02.0f',$e_time_min)));
		}else $add_par = array('is_time' => 0);
		$max_date = mktime(0,0,0,substr($e_date,3,2),substr($e_date,0,2),substr($e_date,6,4));
		$add_par = array_merge($add_par,array('start_date' => $cur,'finish_date'=>$max_date));
		switch($repeat){
			case 1:
				$rep_data=array('e_date'=>$e_date,'frequency'=>$every_day);
				while(($date = mktime(0,0,0,$m,$d+$i*$every_day,$y)) <= $max_date){
					$i++;
					$map[$i] = $date;
				}
			break;
			case 2:
				$rep_data=array('e_date'=>$e_date,'frequency'=>$every_week, 'repeat_days'=>$week_days_csv, 'repeat_days_txt'=>$week_days_txt);
				$week_days_csv_a = split(",",$week_days_csv);
				$wn_cur = date('W',mktime(0,0,0,$m,$d,$y));
				
				do{
					$time = mktime(0,0,0,$m,$d+$i,$y);
					$dw = date('w',$time);
					$dw or $dw = 7;
					$Wn = date('W',$time);
					if($week_days_csv_a[$dw-1] == 1 && (!(($Wn-$wn_cur)% $every_week) || $Wn==$wn_cur) && $time <= $max_date){
						$map[] = $time;
					}
					$i++;
				}while($time < $max_date);
			break;
			case 3:
				$rep_data=array('e_date'=>$e_date,'frequency'=>$every_month);
				while(($date = mktime(0,0,0,$m+$i*$every_month,$d,$y)) <= $max_date){
					$i++;
					$map[$i] = $date;
				}
			break;
			case 4:
				$rep_data=array('e_date'=>$e_date,'frequency'=>$every_year);
				while(($date= mktime(0,0,0,$m,$d,$y+$i*$every_year)) <= $max_date){
					$i++;
					$map[$i] = $date;
				}
			break;
			default :
				$rep_data=array();
		}
		$this->items[]= new event(array_merge(array('title'=>$ti,'body'=>$bi,'repeat'=>$repeat), $add_par, $rep_data));
		end($this->items);
		list($id)=each($this->items);
		$this->items[$id]->id = $id;
		if(!$map){
			$this->items_map[$y][$m][$d][]=$id;
			$this->items_map[$y][$m][$d]['bg_color'] = $cbgc;
			$this->items_map[$y][$m][$d]['bg_image'] = $cbgi;
			$this->items_map[$y][$m][$d]['align'] = $calign;
		}
		else{
			foreach($map as $k=>$v){
				$_d=date('d',$v);
				$_m=date('m',$v);
				$_y=date('Y',$v);
				$this->items_map[$_y][$_m][$_d][]=$id;
				$this->items_map[$_y][$_m][$_d]['bg_color'] = $cbgc;
				$this->items_map[$_y][$_m][$_d]['bg_image'] = $cbgi;
				$this->items_map[$_y][$_m][$_d]['align'] = $calign;
			}
		}
		$this->save_item();
	}
	/*
	function del_item
	input parameters:
		$d - day, $m - month, $y - year
	action:
		delete event specified by date and ID
	*/
	function del_item($d,$m,$y,$id) {
		$d=sprintf('%02.0f',$d);
		$m=sprintf('%02.0f',$m);
		$y=sprintf('%04.0f',$y);
		$id=(int)$id;
		echo "<pre>";
		print_r($this->items[$id]);
		if(!$this->items[$id]) return false;
		$max_date = $this->items[$id]->finish_date;
		$s_d = date('d',$this->items[$id]->start_date);
		$s_m = date('m',$this->items[$id]->start_date);
		$s_y = date('Y',$this->items[$id]->start_date);
		switch($this->items[$id]->repeat){
			case 1:
				if(!$this->items[$id]->frequency) break;
				while(($date = mktime(0,0,0,$s_m,$s_d+$i*$this->items[$id]->frequency,$s_y)) <= $max_date){
					$i++;
					$map[$i] = $date;
				}

			break;
			case 2:
				if(!$this->items[$id]->frequency) break;
				$week_days_csv_a = split(",",$this->items[$id]->repeat_days);
				$wn_cur = date('W',mktime(0,0,0,$s_m,$s_d,$s_y));
				do{
					$time = mktime(0,0,0,$s_m,$s_d+$i,$s_y);
					$dw = date('w',$time);
					$dw or $dw = 7;
					$Wn = date('W',$time);
					if($week_days_csv_a[$dw-1] == 1 && (!(($Wn-$wn_cur)% $this->items[$id]->frequency) || $Wn==$wn_cur) && $time <= $max_date){
						$map[] = $time;
					}
					//echo "I = $i ".date("Y-m-d",$time)."Max date=".date("Y-m-d",$max_date)."<br>";
					$i++;
				}while($time < $max_date);
				echo "MAp<br>";
				print_r($map);
				echo "MAp<br>";
			break;
			case 3:
				if(!$this->items[$id]->frequency) break;
				while(($date = mktime(0,0,0,$s_m+$i*$this->items[$id]->frequency,$s_d,$s_y)) <= $max_date){
					$i++;
					$map[$i] = $date;
				}
			break;
			case 4:
				if(!$this->items[$id]->frequency) break;
				while(($date= mktime(0,0,0,$s_m,$s_d,$s_y+$i*$this->items[$id]->frequency)) <= $max_date){
					$i++;
					$map[$i] = $date;
				}
			break;
		}
		if($map){
			foreach($map as $k=>$v){
				$_d=date('d',$v);
				$_m=date('m',$v);
				$_y=date('Y',$v);
				foreach($this->items_map[$_y][$_m][$_d] as $k=>$v) if($v===$id) unset($this->items_map[$_y][$_m][$_d][$k]);
				if(count($this->items_map[$_y][$_m][$_d]) <= 3) unset($this->items_map[$_y][$_m][$_d]);
				if(!count($this->items_map[$_y][$_m])) unset($this->items_map[$_y][$_m]);
				if(!count($this->items_map[$_y])) unset($this->items_map[$_y]);
			}
		}else if(is_array($this->items_map[$y][$m][$d])){
			foreach($this->items_map[$y][$m][$d] as $k=>$v) if(is_numeric($k) && $v == $id)unset($this->items_map[$y][$m][$d][$k]);
			unset($this->items_map[$y][$m][$d][$k[$id]]);
			if(count($this->items_map[$y][$m][$d]) <= 3) unset($this->items_map[$y][$m][$d]);
			if(!count($this->items_map[$y][$m])) unset($this->items_map[$y][$m]);
			if(!count($this->items_map[$y])) unset($this->items_map[$y]);
		}
		if(is_array($this->items_map[$y][$m][$d])){
			foreach($this->items_map[$y][$m][$d] as $k1=>$v1){
				if(is_numeric($k1))$res[] = $v1;
				else $res[$k1] = $v1;
			}
			$this->items_map[$y][$m][$d] = $res;
		}
		unset($this->items[$id]);
		$this->save_item();
	}
	/*
	function update_item
	input parameters:
		$d - day, $m - month, $y - year
	action:
		update event specified by date and ID
	*/
	function update_item($d,$m,$y,$id) {
		global $_POST,$calendar;
		extract($_POST);
		print_r($_POST);
		$d=sprintf('%02.0f',$d);
		$m=sprintf('%02.0f',$m);
		$y=sprintf('%04.0f',$y);
		$cur = mktime(0,0,0,$m,$d,$y);
		$t=(int)$t;
		$ti=$this->str_p($ti);
		$bi=$this->str_p($bi);
		$id--;
		if($is_time){
			if($calendar->a_template['time_format'] == 1){
				$s_time_hour = $s_time_hour==12 && $s_time_type ? 12:($s_time_hour==12 && !$s_time_type ? 0:($s_time_type? 12 + $s_time_hour : $s_time_hour));
				$e_time_hour = $e_time_hour==12 && $e_time_type ? 12:($e_time_hour==12 && !$e_time_type ? 0:($e_time_type? 12 + $e_time_hour : $e_time_hour));
			}
			if((int)$s_time_hour > 23) $s_time_hour = 23;
			if((int)$s_time_hour < 0) $s_time_hour = 0;
			if((int)$e_time_hour > 23) $e_time_hour = 23;
			if((int)$e_time_hour < 0) $e_time_hour = 0;
			if((int)$s_time_min > 59) $s_time_min = 59;
			if((int)$s_time_min < 0) $s_time_min = 0;
			if((int)$e_time_min > 59) $e_time_min = 59;
			if((int)$e_time_min < 0) $e_time_min = 0;
			if($e_time_hour.$e_time_min < $s_time_hour.$s_time_min) $e_time_hour = $s_time_hour+1;
			$add_par = array('is_time' => 1,'time_start'=>array('h'=>$s_time_hour,'m'=>sprintf('%02.0f',$s_time_min)),'time_end'=>array('h'=>$e_time_hour,'m'=>sprintf('%02.0f',$e_time_min)));
		}else $add_par = array('is_time' => 0);
		$max_date = mktime(0,0,0,substr($e_date,3,2),substr($e_date,0,2),substr($e_date,6,4));
		$add_par = array_merge($add_par,array('start_date' => $this->items[$id]->start_date,'finish_date'=>$max_date));
		echo "$e_date Max date=".date("Y-m-d",$max_date)."<br>";
		echo "<pre>";
		print_r($this->items[$id]);
		
		if(($this->items[$id]->repeat != $repeat || $this->items[$id]->e_date != $e_date) && $this->items[$id]->repeat || $all_fut) $new_item = 1;
		switch($repeat){
			case 1:
				if($this->items[$id]->frequency != $every_day && $this->items[$id]->repeat) $new_item = 1;
				$rep_data=array('e_date'=>$e_date,'frequency'=>$every_day);
				while(($date = mktime(0,0,0,$m,$d+$i*$every_day,$y)) <= $max_date){
					$i++;
					$map[$i] = $date;
				}
			break;
			case 2:
				if($this->items[$id]->frequency != $every_week && $this->items[$id]->repeat) $new_item = 1;
				
				$rep_data=array('e_date'=>$e_date,'frequency'=>$every_week, 'repeat_days'=>$week_days_csv, 'repeat_days_txt'=>$week_days_txt);
				$week_days_csv_a = split(",",$week_days_csv);
				$wn_cur = date('W',mktime(0,0,0,$m,$d,$y));
				do{
					$time = mktime(0,0,0,$m,$d+$i,$y);
					$dw = date('w',$time);
					$dw or $dw = 7;
					$Wn = date('W',$time);
					if($week_days_csv_a[$dw-1] == 1 && (!(($Wn-$wn_cur)% $every_week) || $Wn==$wn_cur) && $time <= $max_date){
						$map[] = $time;
					}
					$i++;
				}while($time < $max_date);
				echo "MAp<br>";
				print_r($map);
				echo "MAp<br>";
				//exit;
			break;
			case 3:
				if($this->items[$id]->frequency != $every_month && $this->items[$id]->repeat) $new_item = 1;
				$rep_data=array('e_date'=>$e_date,'frequency'=>$every_month);
				while(($date = mktime(0,0,0,$m+$i*$every_month,$d,$y)) <= $max_date){
					$i++;
					$map[$i] = $date;
				}
			break;
			case 4:
				if($this->items[$id]->frequency != $every_year && $this->items[$id]->repeat) $new_item = 1;
				$rep_data=array('e_date'=>$e_date,'frequency'=>$every_year);
				while(($date = mktime(0,0,0,$m,$d,$y+$i*$every_year)) <= $max_date){
					$i++;
					$map[$i] = $date;
				}
			break;
			default :
				$rep_data=array();
		}
		if($new_item){
			$this->items[]= new event(array_merge(array('id'=>$id,'title'=>$ti,'body'=>$bi,'repeat'=>$repeat),$add_par,$rep_data));
			end($this->items);
			$old_id = $id;
			list($id)=each($this->items);
			$this->items[$id]->id = $id;
		}else{
			$this->items[$id]= new event(array_merge(array('id'=>$id,'title'=>$ti,'body'=>$bi,'repeat'=>$repeat),$add_par,$rep_data));
		}
		if($map){
			foreach($map as $k=>$v){
				$_d = date('d',$v);
				$_m = date('m',$v);
				$_y = date('Y',$v);
				if($all_fut){
					$this->items_map[$_y][$_m][$_d] = array_diff($this->items_map[$_y][$_m][$_d],array($old_id));
				}
				if(!@in_array($id,$this->items_map[$_y][$_m][$_d])) $this->items_map[$_y][$_m][$_d][]=$id;
			}
		}
		$this->items_map[$y][$m][$d]['bg_color'] = $cbgc;
		$this->items_map[$y][$m][$d]['bg_image'] = $cbgi;
		$this->items_map[$y][$m][$d]['align'] = $calign;
		$this->save_item();
	}
	/*
	function add_item_url
	input parameters:
		$d - day, $m - month, $y - year, $url
	action:
		update URL parameter for event specified by date and ID
	*/
	function add_item_url($d,$m,$y,$url) {
		$d=sprintf('%02.0f',$d);
		$m=sprintf('%02.0f',$m);
		$y=sprintf('%04.0f',$y);
		$url=$this->str_p($url);
		$this->items_map[$y][$m][$d]['url']=$url;
		$this->save_item();
	}
	/*
	function add_item_title
	input parameters:
		$d - day, $m - month, $y - year, $title
	action:
		update title parameter for event specified by date and ID
	*/
	function add_item_title($d,$m,$y,$title) {
		$d=sprintf('%02.0f',$d);
		$m=sprintf('%02.0f',$m);
		$y=sprintf('%04.0f',$y);
		$title=$this->str_p($title);
		$this->items_map[$y][$m][$d]['title']=$title;
		$this->save_item();
	}
	/*
	function add_item_target
	input parameters:
		$d - day, $m - month, $y - year, $target
	action:
		update target parameter for event specified by date and ID
	*/
	function add_item_target($d,$m,$y,$target) {
		$d=sprintf('%02.0f',$d);
		$m=sprintf('%02.0f',$m);
		$y=sprintf('%04.0f',$y);
		$target=$this->str_p($target);
		$this->items_map[$y][$m][$d]['target']=$target;
		//print_r($this->items_map[$y][$m][$d]);
		$this->save_item();
	}
	/*
	function item_up
	input parameters:
		$d - day, $m - month, $y - year, $id
	action:
		move current event upward by one position
	*/
	function item_up($d,$m,$y,$id) {
		$d=sprintf('%02.0f',$d);
		$m=sprintf('%02.0f',$m);
		$y=sprintf('%04.0f',$y);
		if(is_array($this->items_map[$y][$m][$d])){
			foreach($this->items_map[$y][$m][$d] as $k=>$v){
				if(is_numeric($k)){
					if($k == $id){
						$buff = $k;
						break;
					}
					$buff2 = $k;
					$data_buff = $v;
				}
			}
		}
		if(isset($buff2)){
			$this->items_map[$y][$m][$d][(int)$buff2] = $this->items_map[$y][$m][$d][(int)$buff];
			$this->items_map[$y][$m][$d][(int)$buff]=(int)$data_buff;
			$this->save_item();
		}
	}
	/*
	function item_down
	input parameters:
		$d - day, $m - month, $y - year, $id
	action:
		move current event downward by one position
	*/
	function item_down($d,$m,$y,$id) {
		$d=sprintf('%02.0f',$d);
		$m=sprintf('%02.0f',$m);
		$y=sprintf('%04.0f',$y);
		if(is_array($this->items_map[$y][$m][$d])){
			foreach($this->items_map[$y][$m][$d] as $k=>$v){
				if(is_numeric($k)){
					if(isset($buff)){
						$buff2=$k;
						$data_buff = $v;
						break;
					}
					if($k == $id) $buff = $k;
				}
			}
		}
		if(isset($buff2)){
			$this->items_map[$y][$m][$d][$buff2] = $this->items_map[$y][$m][$d][$buff];
			$this->items_map[$y][$m][$d][$buff]=$data_buff;
			$this->save_item();
		}
	}
}
$events = new events();
?>