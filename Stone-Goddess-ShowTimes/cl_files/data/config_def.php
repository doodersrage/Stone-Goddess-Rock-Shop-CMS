<?php $settings = array(
	'REDIRECT' => array(
		'redirect_url'=>'show.php',
		'redirect_target'=>'_blank'
	),
	'TEMPLATE' => array(
		'is_american' => 0,
		'is_vertical' => 0,
		'days_location' => 1,
		'weeks_location' => 1,
		'show_year' => 1,
		'title_format' => 'M - Y',
		'time_format' => 1,
		'time_gradation' => 1,
		'is_show_title' => 0,
		'publicity' => 0,
		'events_type' => 0,
		'date_type' => 0,
		'event_list_templ' => "<tr>\n\t<td>\$num</td>\n\t<td><b>\$title</b></td>\n\t<td>\$body</td>\n</tr>",
		'date_gradation' => array('Exclude time','Include time'),
		'period_gradation' => array('By weekday', 'By day of month', 'By hours'),
		'period_type' => 0,
		'timezone' => 0,
		'timezoneID' => 0
	),
	'LOCALIZATION' => array(
		'days' => array('Su','Mo','Tu','We','Th','Fr','Sa'),
		'months' => array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec')
	),
	'LOOK' => array(
		'table_bg_color' => '#4682B4',
		'header_bg_color' => '#4682B4',
		'header_font_color' => 'Cheader',
		'header2_bg_color' => '#87cefa',
		'header2_font_color' => 'Cheader2',
		'we_bg_color' => '#dbeaf5',
		'we_font_color' => 'Cwe',
		'body_bg_color' => '#ffffff',
		'body_font_color' => 'Cbody',
		'bodyh_bg_color' => '#ffffff',
		'bodyh_font_color' => 'Cbodyh',
		'cur_bg_color' => '#ffb6c1',
		'cur_font_color' => 'Ccur',
		'showb_bg_color' => '#ffffff',
		'showt_bg_color' => '#ffffff',
		'td_width' => '25',
		'td_height' => '25',
		'def_event_bgcolor' => '',
		'def_nonevent_image' => '',
		'def_event_image' => '',
		'def_event_align' => 'center',
		'def_event_valign' => 'center',
		'def_align' => 'center',
		'def_valign' => 'center',
		'cell_padding' => '0',
		'cell_spacing' => '0',
		'cell_border' => '0'
	)
)
?>