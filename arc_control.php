<?php
	/**
	 * @shortdesc		Creates a double pie chart (pro/con) with percent display.
	 * @longdesc		Creates two associated pie charts with linked percentage values, based on TBate flat design UI, using bare SVG on the HTML side, along with inline styling for programmatic access.
	 *
	 * @author			Marjan Stojnev, Foundation IDEA Southeast Europe
	 * @revision		0.8, 09.07.2014
	 *
	 * @param  integer	$pro_percent		Value of percentage for the pro (affirmative) pie.
	 * @param  integer	$control_width		Width in pixels for the container of the individal pie control. Equal to height.
	 * @param  integer	$control_offset		Offset in pixels from the border of the container to the outline of the pie control.
	 * @param  integer	$control_mirror		Optional. Mirror flag (1/0) to indicate whether the arc display is side by side or mirrored when drawn.
	 * @param  integer	$con_percent		Optional. Value of percentage for the con (negative) pie. Only use if the sum of the pro and con percent is different than 100.
	 * @param  string	$pro_color_inner	Optional. Value (in hex) for the color of the inner section of the pro pie. Defaults to #189382.
	 * @param  string	$pro_color_outer	Optional. Value (in hex) for the color of the outer section of the pro pie. Defaults to #87cec4.
	 * @param  string	$con_color_inner	Optional. Value (in hex) for the color of the inner section of the con pie. Defaults to #f97e76.
	 * @param  string	$con_color_outer	Optional. Value (in hex) for the color of the outer section of the con pie. Defaults to #fec3bf.
	 *
	 * @return string	$arc_control		Returns a string value of the drawn control.
	 */
	
	function create_arc_control($pro_percent, $control_width, $control_offset, $control_mirror = 1, $con_percent = -1, $pro_color_inner = '#189382', $pro_color_outer = '#87cec4', $con_color_inner = '#f97e76', $con_color_outer = '#fec3bf')
	{
		if ($pro_percent > 100) { $pro_percent = 100; }
		if ($pro_percent < 0) { $pro_percent = 0; }
		if ($con_percent == -1) { $con_percent = 100 - $pro_percent; }
		$control_radius = $control_width / 2 - $control_offset;
		$control_internal_radius = $control_radius * 0.77;
		$control_center = $control_radius + $control_offset;
		$control_text_size = $control_width / 4;
		$text_x = $control_center;
		$text_y = $control_center + (0.075 * $control_width);
		$arc_control = '';
		$pro_arc_1 = 0; $pro_arc_2 = 0;
		if ($pro_percent > 50) { $pro_arc_1 = 360 * (50 / 100); $pro_arc_2 = 360 * (($pro_percent - 50) / 100); }
		else { $pro_arc_1 = 360 * ($pro_percent / 100); $pro_arc_2 = 0; }
		$pro_x_1 = $control_center + $control_radius * sin(deg2rad($pro_arc_1));
		$pro_y_1 = $control_center - $control_radius * cos(deg2rad($pro_arc_1));
		if ($pro_percent_1 > 25) { $pro_y_1 = $control_center + $control_radius * cos(deg2rad($pro_arc_1)); }
		$pro_path = '<path d="M'.$control_center.','.$control_center.' L'.$control_center.','.$control_offset.' A'.$control_radius.','.$control_radius.' 1 0,1 '.$pro_x_1.','.$pro_y_1;
		if ($pro_arc_2 != 0)
		{
			$pro_x_2 = $control_center - $control_radius * sin(deg2rad($pro_arc_2));
			$pro_y_2 = $control_center + $control_radius * cos(deg2rad($pro_arc_2));
			$pro_path .= ' A'.$control_radius.','.$control_radius.' 1 0,1 '.$pro_x_2.','.$pro_y_2;
		}
		$pro_path .= ' z" style="fill: '.$pro_color_outer.'"></path>';

		$arc_control .= '<svg style="width: '.$control_width.'px; height: '.$control_width.'px;">';
		$arc_control .= $pro_path;
		$arc_control .= '<circle cx="'.$control_center.'" cy="'.$control_center.'" r="'.$control_internal_radius.'" style="fill: '.$pro_color_inner.'"></circle>';
		$arc_control .= '<text text-anchor="middle" x="'.$text_x.'" y="'.$text_y.'" style="font-family: \'Tahoma\'; font-size: '.$control_text_size.'px; fill: '.$pro_color_outer.';">'.$pro_percent.'</text>';
		$arc_control .= '</svg>';
		$con_arc = '0,1'; $con_percent_value = $con_percent;

		if ($con_percent == 100) { $control_mirror = 0; }
		if ($control_mirror == 1) { $con_arc = '1,0'; $con_percent = $pro_percent; }
		$con_arc_1 = 0; $con_arc_2 = 0;
		if ($con_percent > 50) { $con_arc_1 = 360 * (50 / 100); $con_arc_2 = 360 * (($con_percent - 50) / 100); }
		else { $con_arc_1 = 360 * ($con_percent / 100); $con_arc_2 = 0; }
		$con_x_1 = $control_center + $control_radius * sin(deg2rad($con_arc_1));
		$con_y_1 = $control_center - $control_radius * cos(deg2rad($con_arc_1));
		if ($con_percent_1 > 25) { $con_y_1 = $control_center + $control_radius * cos(deg2rad($con_arc_1)); }
		$con_path = '<path d="M'.$control_center.','.$control_center.' L'.$control_center.','.$control_offset.' A'.$control_radius.','.$control_radius.' 1 '.$con_arc.' '.$con_x_1.','.$con_y_1;
		if ($con_arc_2 != 0)
		{
			$con_x_2 = $control_center - $control_radius * sin(deg2rad($con_arc_2));
			$con_y_2 = $control_center + $control_radius * cos(deg2rad($con_arc_2));
			$con_path .= ' A'.$control_radius.','.$control_radius.' 1 0,1 '.$con_x_2.','.$con_y_2;
		}
		$con_path .= ' z" style="fill: '.$con_color_outer.'"></path>';

		$arc_control .= '<svg style="width: '.$control_width.'px; height: '.$control_width.'px;">';
		$arc_control .= $con_path;
		$arc_control .= '<circle cx="'.$control_center.'" cy="'.$control_center.'" r="'.$control_internal_radius.'" style="fill: '.$con_color_inner.'"></circle>';
		$arc_control .= '<text text-anchor="middle" x="'.$text_x.'" y="'.$text_y.'" style="font-family: \'Tahoma\'; font-size: '.$control_text_size.'px; fill: '.$con_color_outer.';">'.$con_percent_value.'</text>';
		$arc_control .= '</svg>';
		
		return $arc_control;
	}
	
	/*
		Example
		echo create_arc_control(62, 80, 5);
	*/
?>