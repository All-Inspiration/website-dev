<?php
$section = 'general-colors';


$sections[]             = array(
	'id'       => $section,
	'title'    => esc_html__( 'General Color', 'laveo' ),
	'priority' => '80'
);

$options['color1']      = array(
	'id'      => 'color1',
	'label'   => esc_html__( 'Primary Color', 'laveo' ),
	'section' => $section,
	'type'    => 'color',
	'default' => '#ef4d4e',
);

$options['color2'] = array(
	'id'      => 'color2',
	'label'   => esc_html__( 'Secondary Color', 'laveo' ),
	'section' => $section,
	'type'    => 'color',
	'default' => '#ff9c31',
);

$options['color3'] = array(
	'id'      => 'color3',
	'label'   => esc_html__( 'Color 3', 'laveo' ),
	'section' => $section,
	'type'    => 'color',
	'default' => '#a9c053',
);

$options['color4'] = array(
	'id'      => 'color4',
	'label'   => esc_html__( 'Color 4', 'laveo' ),
	'section' => $section,
	'type'    => 'color',
	'default' => '#27aac5',
);

$options['color5'] = array(
	'id'      => 'color5',
	'label'   => esc_html__( 'Color 5', 'laveo' ),
	'section' => $section,
	'type'    => 'color',
	'default' => '#1e73be',
);

$options['color6'] = array(
	'id'      => 'color2',
	'label'   => esc_html__( 'Color 6', 'laveo' ),
	'section' => $section,
	'type'    => 'color',
	'default' => '#8224e3',
);

$options['color7'] = array(
	'id'      => 'color7',
	'label'   => esc_html__( 'Color 7', 'laveo' ),
	'section' => $section,
	'type'    => 'color',
	'default' => '#3f6338',
);
?>