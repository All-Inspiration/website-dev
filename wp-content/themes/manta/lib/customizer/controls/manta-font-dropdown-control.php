<?php
/**
 * Custom Customize API: Manta_Font_Dropdown_Control class
 *
 * @package	 Manta
 * @since 1.1
 */

/**
 * Customize Custom fonts dropdown control class.
 *
 * @since 1.1
 */
class Manta_Font_Dropdown_Control extends WP_Customize_Control {

	/**
	 * Type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'select';

	/**
	 * Constructor.
	 *
	 * @since 1.1
	 *
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      Control ID.
	 * @param array                $args    Optional. Arguments to override class property defaults.
	 */
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Render the content of the category dropdown
	 *
	 * @since 1.1
	 */
	public function render_content() {
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<select <?php $this->link(); ?> class="fonts">
				<?php
				$fonts = Manta_Customizer_Data::get_google_sans_fonts_list();
				if ( ! empty( $fonts ) ) {
				    printf( '<optgroup label="%s" class="google_label">', sprintf( __( 'Sans Serif web fonts', 'manta' ) ) ); // WPCS : xss ok.
				    foreach ( $fonts as $font ) {
				        printf( '<option value="%s" %s>%s</option>', esc_attr( $font ), selected( $this->value(), $font, false ), esc_html( $font ) );
				    }
				    printf( '</optgroup>' );
				}
				$fonts = Manta_Customizer_Data::get_google_serif_fonts_list();
				if ( ! empty( $fonts ) ) {
				    printf( '<optgroup label="%s" class="google_label">', sprintf( __( 'Serif web fonts', 'manta' ) ) ); // WPCS : xss ok.
				    foreach ( $fonts as $font ) {
				        printf( '<option value="%s" %s>%s</option>', esc_attr( $font ), selected( $this->value(), $font, false ), esc_html( $font ) );
				    }
				    printf( '</optgroup>' );
				}
				?>
			</select>
		</label>
		<?php
	}
}
