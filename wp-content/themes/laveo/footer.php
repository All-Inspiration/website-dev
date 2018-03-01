<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package laveo
 */

?>

<div class="clear"></div>
<footer id="footer_area" class="full_width" role="contentinfo">
	<div class="page">
		<div id="footer">
			<?php
			if ( is_active_sidebar( 'footer_widget' ) ) {
				echo '<ul>';
				dynamic_sidebar( 'footer_widget' );
				echo '</ul>';
			}
			?>
			<div class="clear"></div>
			<div class="copyright">
				<?php printf( __( '&copy; %1s %2s. Designed by %3s.', 'laveo' ), date( 'Y' ), '<a href="' . esc_url( 'http://laveo.physcode.com/' ) . '"> Laveo WordPress Theme</a>' , '<a href="' . esc_url( 'http://physcode.com/' ) . '">PhysCode</a>' ); ?>

			</div>
		</div>
	</div>
</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
