(function(jQuery) {
'use strict';
jQuery(document).ready(function($) {
	
	/* ## Document Scroll - Window Scroll */
	if( $("#sticker").length){
		$("#sticker").sticky();
	}



	/* -- Responsive Caret */
	if( $(".ddl-switch").length ){
		$(".ddl-switch").on("click", function() {

			var li = $(this).parent();
			if ( li.hasClass("ddl-active") || li.find(".ddl-active").length !== 0 || li.find(".dropdown-menu").is(":visible") ) {
				li.removeClass("ddl-active");
				li.children().find(".ddl-active").removeClass("ddl-active");
				li.children(".dropdown-menu").slideUp();
			}
			else {
				li.addClass("ddl-active");
				li.children(".dropdown-menu").slideDown();
			}
			
		});
	}
	
	
	
	/* -- image-popup */
	if( $('.image-popup').length ){
		 $('.image-popup').magnificPopup({
			closeBtnInside : true,
			type           : 'image',
			mainClass      : 'mfp-with-zoom'
		});
	}
	
	
	
	/* -- Client Section */
	if( $(".owlGallery").length ) {
		$(".owlGallery").owlCarousel({
			navText: [ '<i class="fa fa-chevron-right"></i>', '<i class="fa fa-chevron-left"></i>' ],
			stagePadding: 0,
			loop: true,
			autoplay: true,
			autoplayTimeout: 2000,
			margin: 10,
			nav: true,
			dots: false,
			smartSpeed: 1000,
			responsive: {
				0: {
					items: 1
				},
				600: {
					items: 1
				},
				1000: {
					items: 1
				}
			}
		});
	}
	
	
	/* -- popup-search */
	if( $("#popup-search").length){
		$('#popup-search').on('click', function(e) {
			e.preventDefault();
			$('.popup-search').fadeIn();
		});
	}
	
	/* -- close-popup-search */
	if( $(".close-popup").length){
		$('.close-popup').on('click', function(e) {
			e.preventDefault();
			$('.popup-search').hide();
		});
	}




});
})(jQuery);