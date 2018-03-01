<?php
// Typography
$font_sizes = array();
for ( $i = 10; $i <= 50; $i ++ ) {
	$font_sizes[ $i . 'px' ] = $i . 'px';
}

$panel = 'typography';

$panels[] = array(
	'id'       => $panel,
	'title'    => esc_html__( 'Typography', 'laveo' ),
	'priority' => '81'
);

// font family body
$font_family_body = 'font_family_body';
$sections[]       = array(
	'panel'    => $panel,
	'id'       => $font_family_body,
	'title'    => esc_html__( 'Body', 'laveo' ),
	'priority' => '1'
);

$options['font_family_body'] = array(
	'id'      => 'font_family_body',
	'label'   => esc_html__( 'Font Family', 'laveo' ),
	'section' => $font_family_body,
	'type'    => 'select',
	'choices' => laveo_customizer_get_font_choices(),
	'default' => 'Lora'
);

$options['font_size_body']   = array(
	'id'      => 'font_size_body',
	'label'   => esc_html__( 'Font Size', 'laveo' ),
	'section' => $font_family_body,
	'type'    => 'select',
	'choices' => $font_sizes,
	'default' => '14px'
);

// font family heading
$font_family_heading = 'font_family_heading';
$sections[]          = array(
	'panel'    => $panel,
	'id'       => $font_family_heading,
	'title'    => esc_html__( 'Heading', 'laveo' ),
	'priority' => '2'
);

$options['font_family_heading'] = array(
	'id'      => 'font_family_heading',
	'label'   => esc_html__( 'Font Family', 'laveo' ),
	'section' => $font_family_heading,
	'type'    => 'select',
	'choices' => laveo_customizer_get_font_choices(),
	'default' => 'ColaborateRegular'
);