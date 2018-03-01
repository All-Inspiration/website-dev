<?php
$section    = 'logo';
$sections[] = array(
	'id'       => $section,
	'title'    => esc_html__( 'Logo', 'laveo' ),
	'priority' => '30',
);

$options['laveo_logo'] = array(
	'id'      => 'laveo_logo',
	'label'   => esc_html__( 'Upload Logo', 'laveo' ),
	'section' => $section,
	'type'    => 'image',
	'default' => ''
);
$options['show_search'] = array(
	'id'      => 'show_search',
	'label'   => esc_html__( 'Show Search Header', 'laveo' ),
	'section' => $section,
	'type'    => 'checkbox',
	'default' => true,
);
