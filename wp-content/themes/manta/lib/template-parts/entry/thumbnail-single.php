<?php
/**
 * The template part for displaying post thumbnails
 *
 * @package Manta
 * @since 1.0.0
 */

?>
<div <?php manta_attr( 'single-thumb' ); ?>>

	<?php
	the_post_thumbnail( 'large', array(
		'alt'   => the_title_attribute( 'echo=0' ),
		'class' => 'aligncenter',
	) );
	?>

</div>
