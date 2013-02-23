<?php 
// Title: PHP Event Calendar
// URL: http://www.softcomplex.com/products/php_event_calendar/
// Version: 1.5.1
// Date: 03/04/2005 (mm/dd/yyyy)
// Tech. support: http://www.softcomplex.com/forum/forumdisplay.php?fid=55
// Notes: Script is free for non commercial use. Visit official site for details.

error_reporting (E_ALL ^ E_NOTICE);
if(!is_writable(session_save_path()))session_save_path("/tmp");
session_start();
ob_start();
$__SESSION__=$HTTP_SESSION_VARS['__SESSION__'];
foreach($HTTP_POST_VARS as $k=>$v){
	if(!is_array($v))${urldecode($k)}=urldecode($v);
}

extract($HTTP_GET_VARS);
if(!@include './data/global.php'){
	echo "Can't open ./data/global.php";
	exit;
}

extract($PATHS);
include $path_to_calendar."calendar.php";
$calendar->is_admin = true;
$gl = read_data($calendar->s_DataDir.'global.txt');
if(is_array($gl)) reset($gl);
$name or $name = key($gl);
$calendar->init($name);
//exit;
include $calendar->s_FilesDir.'auth.php';

$g_text = $calendar->read_file("groups",".php",1);
$g_text = str_replace("<?php ","",$g_text);
$g_text = str_replace("?>","",$g_text);
$a_groups = unserialize($g_text);

if($addname) {
	if($addname === htmlspecialchars($addname)) {
		$gl = $calendar->create_new($addname);
	}else{ 
		$c_err = 'Calendar name $addname incorect.';
	}
}

if($del_c) {
	$calendar->drop($sl_name);
	$gl = read_data($calendar->s_DataDir.'global.txt');
	if(is_array($gl)) reset($gl);
	$name or $name = key($gl);
	$calendar->init($name);
}


include $calendar->s_FilesDir.'zones.php';

$action=$page;
if($upload){
	if($HTTP_POST_FILES['p']['tmp_name']) {
		@copy($HTTP_POST_FILES['p']['tmp_name'],$calendar->s_ImgDir."p_".$calendar->s_calendar_index.".gif");
	}
	if($HTTP_POST_FILES['n']['tmp_name']) {
		@copy($HTTP_POST_FILES['n']['tmp_name'],$calendar->s_ImgDir."n_".$calendar->s_calendar_index.".gif");
	}
	if($HTTP_POST_FILES['py']['tmp_name']) {
		@copy($HTTP_POST_FILES['py']['tmp_name'],$calendar->s_ImgDir."py_".$calendar->s_calendar_index.".gif");
	}
	if($HTTP_POST_FILES['ny']['tmp_name']) {
		@copy($HTTP_POST_FILES['ny']['tmp_name'],$calendar->s_ImgDir."ny_".$calendar->s_calendar_index.".gif");
	}
	header("Location: index.php?CLd=$CLd&CLm=$CLm&CLy=$CLy&name=".$calendar->s_calendar_index."&type=$type&action=$action&page=s");
	exit;
}
function help($part){
	if(is_file('help.dat')){
		include 'help.dat';
		if($help[$part])return "&nbsp;<a href=# onclick='return PopUp(\"help.php?part=$part\")'><img src=\"img/help.gif\" width=\"10\" height=\"10\" border=\"0\" alt=\"More details\" align=\"absmiddle\"></a>";
		else return '';
	}else return '';
}
$page or $page = 'e';
if($page =="l"){
	$HTTP_SESSION_VARS = array();
	header("Location: index.php");
	exit;
}
$CLd = $calendar->a_selected_date['d'];
$CLm = $calendar->a_selected_date['m'];
$CLy = $calendar->a_selected_date['y'];
?>
<html>
<head>
<title>PHP Event Calendar > <?php echo $pages[$page]?><?php echo ($page=='e'?" > Event List (".date ('d M, Y',mktime(0,0,0,$CLm,$CLd,$CLy)).')':'')?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
	a, A:link, a:visited, a:active
		{color: #0000aa; text-decoration: none; font-family: Tahoma, Verdana; font-size: 11px}
	A:hover
		{color: #ff0000; text-decoration: none; font-family: Tahoma, Verdana; font-size: 11px}
	p, tr, td, ul, li
		{color: #000000; font-family: Tahoma, Verdana; font-size: 11px}
	.header1, h1
		{color: #ffffff; background: #4682B4; font-weight: bold; font-family: Tahoma, Verdana; font-size: 13px; margin: 0px; padding: 2px;}
	.header2, h2
		{color: #000000; background: #DBEAF5; font-weight: bold; font-family: Tahoma, Verdana; font-size: 12px;}
	.list
		{font-weight: bold; font-family: Tahoma, Verdana; font-size: 12px;}
	.btn
		{font-family: Tahoma, Verdana; font-size: 11px;}
	.inpt
		{font-family: Tahoma, Verdana; font-size: 11px; width: 100%}
	.inptbar
		{font-family: Tahoma, Verdana; font-size: 11px;}
	.intd
		{color: #000000; font-family: Tahoma, Verdana; font-size: 11px; padding-left: 15px;}
	.active
		{color: #000000; font-family: Tahoma, Verdana; font-size: 11px;font-style : italic;}
	.event_leyer
		{
		border-color: #4682B4;
		border-style : solid;
		border-width : 1px;
		background-color : #DBEAF5;
		}
	.Cheader
		{color: #ffffff; font-family: Tahoma, Verdana; font-size: 11px;}
	.Cheader2
		{color: #ffffff; font-family: Tahoma, Verdana; font-size: 11px;}
	.Ccur
		{color: #000000; font-family: Tahoma, Verdana; font-size: 11px;}
	.Cbody
		{color: #000000; font-family: Tahoma, Verdana; font-size: 11px;}
	.Cbodyh
		{color: #606060; font-family: Tahoma, Verdana; font-size: 11px;}
	.Cwe
		{color: #000000; font-family: Tahoma, Verdana; font-size: 11px;}

	.C2header
		{color: #4682B4; font-family: Tahoma, Verdana; font-size: 11px;}
	.C2header2
		{color: #4682B4; font-family: Tahoma, Verdana; font-size: 11px;}
	.C2cur
		{color: #000000; font-family: Tahoma, Verdana; font-size: 11px;}
	.C2body
		{color: #000000; font-family: Tahoma, Verdana; font-size: 11px;}
	.C2bodyh
		{color: #99CCFF; font-family: Tahoma, Verdana; font-size: 11px;}
	.C2we
		{color: #FF33CC; font-family: Tahoma, Verdana; font-size: 11px;}
</style>
<script language="JavaScript" src="calendar1.js"></script>
<script language="JavaScript" type="text/javascript">
function event_pos(){return}
function dropcalendar(name){
	var ans = window.confirm("Delete: are you sure you want to delete calendar " + name + "?");
	if(ans){
		document.formadd.del_c.value = 1
		document.formadd.sl_name.value = name
		document.formadd.submit();
	}
}
function PopUp(URL){
	window.open(URL, '', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=600,height=300,left = 100,top = 50');
	return false;
}
var n_x,n_y;
</script>
</head>
<body bottommargin="15" topmargin="15" leftmargin="15" rightmargin="15" marginheight="15" marginwidth="15" bgcolor="white"  <?php if($page=='e'){?>onload="init()" onresize ="init(1)"<?php }?>>
<!-- Header -->
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
	<td width="350" rowspan="2"><img src="img/php_ec.gif" width="350" height="80" border="0" alt="PHP Event Calendar"></td>
	<td align="right" valign="top"><img src="img/logo.gif" width="178" height="30" border="0" alt="Softcomplex logo"></td>
</tr>
<tr>
	<td align="right" valign="bottom" nowrap>
		<?php 
		if($a_groups[$__SESSION__['group']]['ev_add'] || $a_groups[$__SESSION__['group']]['ev_edit']){
			echo "|&nbsp;<a href=\"index.php?page=e".($calendar->s_calendar_index?"&name=".$calendar->s_calendar_index:'')."\">".($page=='e'?'<b>':'').'Events Editor'.($page=='e'?'</b>':'')."</a>&nbsp;";
		}
		if($a_groups[$__SESSION__['group']]['cal_cfg']){
			echo "|&nbsp;<a href=\"index.php?page=s".($calendar->s_calendar_index?"&name=".$calendar->s_calendar_index:'')."\">".($page=='s'?'<b>':'').'Calendars Config'.($page=='s'?'</b>':'')."</a>&nbsp;";
		}
		if($a_groups[$__SESSION__['group']]['tem_cfg']){
			echo "|&nbsp;<a href=\"index.php?page=t".($calendar->s_calendar_index?"&name=".$calendar->s_calendar_index:'')."\">".($page=='t'?'<b>':'').'Templates Config'.($page=='t'?'</b>':'')."</a>&nbsp;";
		}
		echo "|&nbsp;<a href=\"index.php?page=a".($calendar->s_calendar_index?"&name=".$calendar->s_calendar_index:'')."\">".($page=='a'?'<b>':'').'Change password'.($page=='a'?'</b>':'')."</a>&nbsp;";
		echo "|&nbsp;<a href=\"index.php?page=l".($calendar->s_calendar_index?"&name=".$calendar->s_calendar_index:'')."\">".($page=='a'?'<b>':'').'Logout'.($page=='a'?'</b>':'')."</a>&nbsp;";
		if($a_groups[$__SESSION__['group']]['is_admin']){
			echo "|&nbsp;<a href=\"index.php?page=admin".($calendar->s_calendar_index?"&name=".$calendar->s_calendar_index:'')."\">".($page=='admin'?'<b>':'').'Users config'.($page=='admin'?'</b>':'')."</a>&nbsp;";
		}
		?>|
	</td>
</tr>
<tr><td><img src="/img/pixel.gif" width="1" height="5" border="0"></td></tr>
</table>
<!-- /Header -->

<!-- Body -->
<table cellpadding="0" cellspacing="0" width="100%" border="0" bgcolor="#4682B4"><tr><td>
<table cellpadding="0" cellspacing="1" width="100%" border="0">
	<tr>
		<td colspan=2>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td class="header1" valign="top">PHP Event Calendar > <?php echo $pages[$page]?><?php echo ($page=='e'?" > Event List (".date ('d M, Y',($CLm&&$CLd&&$CLy?mktime(0,0,0,$CLm,$CLd,$CLy):time())).')':'')?></td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
	<!-- Products -->
	<td valign="top" bgcolor="#FFFFFF" width="20%">
	<table cellspacing="0" cellpadding="4" width="100%" border="0">
	<form name="choose" method="get" action="index.php">
	<input type="hidden" name="page" value=<?php echo  $page?>>
	<input type="hidden" name="action" value=<?php echo  $action?>>
	<input type="hidden" name="type" value=<?php echo  $type?>>
	<tr><td class="header2">Choose Calendar</td></tr>
	<tr><td align="center">
	<?php $action=$page;
	if($adde) {
		$events->load_item();
		if($ti&&$bi) {
			if(!$edit)$events->add_item($CLd,$CLm,$CLy);
			else $events->update_item($CLd,$CLm,$CLy,(int)($id-1));
			unset($edit);
			header("Location: index.php?CLd=$CLd&CLm=$CLm&CLy=$CLy&name=".$calendar->s_calendar_index."&type=$type&action=$action");
			exit;
		}else{
			header("Location: index.php?CLd=$CLd&CLm=$CLm&CLy=$CLy&name=".$calendar->s_calendar_index."&type=$type&action=$action&err='Field Title and Body must be have value'");
			exit;
		}
	}
	if($dele) {
		$events->load_item();
		$events->del_item($CLd,$CLm,$CLy,($dele-1));
		header("Location: index.php?CLd=$CLd&CLm=$CLm&CLy=$CLy&name=".$calendar->s_calendar_index."&type=$type&action=$action");
		exit;
	}
	if($addu){
		$events->load_item();
		$events->add_item_url($CLd,$CLm,$CLy,$itemurl);
		$events->add_item_title($CLd,$CLm,$CLy,$itemtitle);
		$events->add_item_target($CLd,$CLm,$CLy,$itemtarget);
		header("Location: index.php?CLd=$CLd&CLm=$CLm&CLy=$CLy&name=".$calendar->s_calendar_index."&type=$type&action=$action");
		exit;
	}?>
	<select name="name" class="inpt" onChange="document.choose.submit();">
	<?php 
	foreach($gl as $k=>$v) {?>
		<option value="<?php echo  $k?>" <?php echo ($calendar->s_calendar_index==$k?'selected':'')?>><?php  echo $k?></option>
	<?php }?>
	</select></td></tr></form></table>
	<?php include'view.php';?>
	<table cellspacing=1 cellpadding=3 width="100%" border=0>
	<tr><td><img src="/img/pixel.gif" width="200" height="1" border="0"></td></tr>
	<?php if($a_groups[$__SESSION__['group']]['cal_cfg']){?>
	<tr><td class="header2">New&nbsp;calendar&nbsp;</td></tr>
	<tr><td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<form name="formadd" method="post" action="index.php">
		<input type="hidden" name=sl_name>
		<input type="hidden" name=del_c>
		<?php if($c_err){?>
		<tr><td colspan="4"><?php echo htmlspecialchars($c_err)?></td></tr>
		<?php }?>
		<tr>
			<td width="27">Title:</td>
			<td><input type="text" name="addname" size="15" class="inpt"></td>
			<td width="3"><img src="/img/pixel.gif" width="3" height="1" border="0"></td>
			<td width="50"><input type="submit" value="Create" class="btn"></td>
		</tr></form>
		</table>
	</td></tr>
	<tr><td><img src="/img/pixel.gif" width="1" height="5" border="0"></td></tr>
	<?php }?>
	<tr><td class="header2">Links</td></tr>
	<tr>
	<td class=intd><b>
	<li><a href="../index.php">Back to welcome page</a>
	<li><a href="http://www.softcomplex.com/products/php_event_calendar/">Product page</a>
	<li><a href="http://www.softcomplex.com/products/php_event_calendar/docs/index.html">Documentation</a> 
	<li><a href="http://www.softcomplex.com/forum/forumdisplay.php?fid=51">PHP Event Calendar forum</a>
	<li><a href="http://www.softcomplex.com/">SoftComplex.com site</a>
	</b></td></tr>
	<tr><td><img src="/img/pixel.gif" width="1" height="1" border="0"></td></tr>
	</table>

	</td>
	<td valign="top" bgcolor="#FFFFFF">
	<?php 
	switch($action) {
		case 'admin':
			if($a_groups[$__SESSION__['group']]['is_admin']) include'admin.php';
		break;
		case 'a':
		include'user.php';
		break;
		case 's':
			if($a_groups[$__SESSION__['group']]['cal_cfg']) include'property.php';
		break;
		case 'e':
			if($a_groups[$__SESSION__['group']]['ev_add'] || $a_groups[$__SESSION__['group']]['ev_edit']) include'edit.php';
		break;
		case 't':
			if($a_groups[$__SESSION__['group']]['tem_cfg']) include'templ.php';
		break;
	}
	$HTTP_SESSION_VARS['__SESSION__']=$__SESSION__;
	ob_end_flush();
?>

	</td>
	</tr>
</table></td></tr></table>
<!-- /Body -->
<!-- Footer -->
<table cellpadding="3" cellspacing="0" width="100%" border="0">
<tr bgcolor="#4682B4">
	<td nowrap><font color="white">Copyright &copy; <?php echo $calendar->get_date('Y')?> SoftComplex Inc.</font></td>
	<td align="right"><a href="http://www.softcomplex.com/support.html" style="color: #FFFFFF;">support</a></td>
</tr>
</table>
<!-- /Footer -->
</body>
</html>

<?php if($action=='e'){?>
<script language="JavaScript" type="text/javascript">
function getabspos (s_coord,obj) {  
	var n_pos = 0,e_o = obj;
	while (e_o){
		n_pos += e_o["offset" + s_coord];
		e_o = e_o.offsetParent;
	}
	return n_pos;
}
function get_element (s_id) {
	return (document.all ? document.all[s_id] : (document.getElementById ? document.getElementById(s_id) : (document.layers ? document.layers[s_id]:null))
	);
}
function init(n){
	if(n){
		<?php if($show_type == 1){?>set_bar_pos();<?php }?>
		a_events_list = []
		event_pos();
	}else if(!n_x){
		<?php if($show_type == 1){?>set_bar_pos();<?php }?>
		event_pos();
		<?php if($show_type == 1){?>week_init();<?php }?>
	}
}
function set_bar_pos(){
	var o_p = get_element('bar_position');
	if(!o_p) o_p = document.images['bar_position'];
	if(!o_p) return;
	n_x = o_p.x ? o_p.x : getabspos('Left',o_p);
	n_y = (o_p.y ? o_p.y : getabspos('Top',o_p));
	show_bar(<?php echo (int)$o_e->repeat?>);
}

var a_events_list = [] ,start_x=0;
function set_pos(s_h,s_m,e_h,e_m,n,base,x_shift,wdth){
	var e_event = get_element(n);
	var o_ps = get_element(base + s_h);
	if(!o_ps) o_ps = document.images[base + s_h];
	var o_pe = get_element(base + e_h);
	if(!o_ps) o_pe = document.images[base + e_h];
	start_x = (o_ps.x ? o_ps.x : getabspos('Left',o_ps));
	var n_eys = (o_ps.y ? o_ps.y : getabspos('Top',o_ps));
	var n_eye = (o_pe.y ? o_pe.y : getabspos('Top',o_pe));
	n_eys += 30/60*s_m;
	n_eye += 30/60*e_m;
	if(e_event.style){
		e_event.style.left = x_shift + start_x;
		e_event.style.top = n_eys;
		e_event.style.height = n_eye - n_eys;
		e_event.style.width = wdth;
		e_event.style.visibility= 'visible';
	}else{
		e_event.left =  x_shift + start_x;
		e_event.top = n_eys;
		e_event.height = n_eye - n_eys;
		e_event.width = wdth;
		e_event.visibility = 'show';
	}
	a_events_list[a_events_list.length] = {'o':e_event, 'x':-500,'y':n_eys,'height':(n_eye - n_eys),'width':wdth,'at_line':0,'at_line_data':[]};
}
if(!n_x){
	init();
}
</script>
<?php }
?>

