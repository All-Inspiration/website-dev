<?php
$sections[] = array(
	'id'       => 'custom-css',
	'title'    => esc_html__( 'Custom Css', 'laveo' ),
	'priority' => '91',
);

$options['laveo_custom_css'] = array(
	'id'      => 'laveo_custom_css',
	'label'   => esc_html__( 'Custom Css', 'laveo' ),
	'section' => 'custom-css',
	'type'    => 'textarea',
	'default' => ''
);
