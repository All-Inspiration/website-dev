/**
 * customizer-control.js
 */
( function ( $, api ) {
	api.bind( 'ready', function () {
		var customize = this;
		var toggler = function ( setting, controls, trueValue ) {
			customize( setting, function ( value ) {
				$.each( controls, function ( index, id ) {
					customize.control( id, function ( control ) {
						var toggle = function ( to ) {
							if ( trueValue && 1 !== trueValue ) {
								control.toggle( trueValue === to );
							}
							else {
								control.toggle( to );
							}
						};
						toggle( value.get() );
						value.bind( toggle );
					} );
				} );
			} );
		};
		toggler( 'manta_excerpt_option', [
				'manta_excerpt_length',
				'manta_excerpt_teaser',
				'manta_thumbnails_display',
			], 'excerpt' );
		toggler( 'manta_enforce_global', [
				'manta_post_layout',
				'manta_page_layout',
				'manta_project_layout',
			], 1 );
	} );
} )( jQuery, wp.customize );
