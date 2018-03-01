(function ($) {
	"use strict";
	jQuery(function () {
		if (jQuery().jCarouselLite) {
			jQuery(".headline div").imagesLoaded(function () {
				jQuery(".headline div").jCarouselLite({
					btnNext: ".next",
					btnPrev: ".prev",
					visible: 6
				});
			});
		}
	});
// equal height
	function equalHeight(group) {
		var tallest = 0;
		group.each(function () {
			var thisHeight = jQuery(this).height();
			if (thisHeight > tallest) {
				tallest = thisHeight;
			}
		});
		group.height(tallest);
	}

	jQuery(document).ready(function ($) {
		equalHeight(jQuery(".blog_content"));
	});
	jQuery(document).ready(function ($) {
		equalHeight(jQuery(".category-posts"));
	});
	jQuery(document).ready(function ($) {
		equalHeight(jQuery(".hentry_widget .block-content"));
		//equalHeight(jQuery(".hentry_widget1 li"));
	});


	$(window).load(function () {
		if (jQuery().nivoSlider) {
			$('#slider').nivoSlider({
				effect                 : 'random', // Specify sets like: 'fold,fade,sliceDown'
				slices                 : 15, // For slice animations
				boxCols                : 8, // For box animations
				boxRows                : 4, // For box animations
				animSpeed              : 500, // Slide transition speed
				pauseTime              : 5000, // How long each slide will show
				startSlide             : 0, // Set starting Slide (0 index)
				directionNav           : false, // Next & Prev navigation
				directionNavHide       : false, // Only show on hover
				controlNav             : true, // 1,2,3... navigation
				controlNavThumbs       : true, // Use thumbnails for Control Nav
				controlNavThumbsFromRel: true, // Use image rel for thumbs
				controlNavThumbsSearch : '.jpg', // Replace this with...
				controlNavThumbsReplace: '_thumb.jpg', // ...this in thumb Image src
				keyboardNav            : true, // Use left & right arrows
				pauseOnHover           : true, // Stop animation while hovering
				manualAdvance          : false, // Force manual transitions
				captionOpacity         : 1, // Universal caption opacity
				prevText               : 'Prev', // Prev directionNav text
				nextText               : 'Next', // Next directionNav text
				beforeChange           : function () {
				}, // Triggers before a slide transition
				afterChange            : function () {
				}, // Triggers after a slide transition
				slideshowEnd           : function () {
				}, // Triggers after all slides have been shown
				lastSlide              : function () {
				}, // Triggers when last slide is shown
				afterLoad              : function () {
				} // Triggers when slider has loaded

			});
		}
	});

	jQuery(document).ready(function ($) {
		// We only want these styles applied when javascript is enabled
		$('div.navigation').css({'width': '50%', 'float': 'right'});
		$('div.content').css('display', 'block');

		// Initially set opacity on thumbs and add
		// additional styling for hover effect on thumbs
		if (jQuery().opacityrollover) {
			var onMouseOutOpacity = 0.67;
			$('#thumbs ul.thumbs li').opacityrollover({
				mouseOutOpacity  : onMouseOutOpacity,
				mouseOverOpacity : 1.0,
				fadeSpeed        : 'fast',
				exemptionSelector: '.selected'
			});
		}
		if (jQuery().galleriffic) {
			var gallery = $('#thumbs').galleriffic({
				delay                    : 2500,
				numThumbs                : 15,
				preloadAhead             : 10,
				enableTopPager           : false,
				enableBottomPager        : false,
				maxPagesToShow           : 1,
				imageContainerSel        : '#slideshow',
				renderSSControls         : false,
				renderNavControls        : false,
				enableHistory            : false,
				autoStart                : false,
				syncTransitions          : true,
				defaultTransitionDuration: 900,
				onSlideChange            : function (prevIndex, nextIndex) {
					// 'this' refers to the gallery, which is an extension of $('#thumbs')
					this.find('ul.thumbs').children()
						.eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
						.eq(nextIndex).fadeTo('fast', 1.0);
				},
				onPageTransitionOut      : function (callback) {
					this.fadeTo('fast', 0.0, callback);
				},
				onPageTransitionIn       : function () {
					this.fadeTo('fast', 1.0);
				}
			});
		}
		;
	});

	$(function () {
		var next_sub_menu = $('.btn-menu');
		//(Backbone) Router -- Handles page transitions
		next_sub_menu.on('click', function () {
			var $btn = $(this).toggleClass('btn-menu-open');
			var $mainnav = $('.menu-main-menu-container');
			if ($mainnav.hasClass('mainnav-open')) {
				$mainnav.removeClass('mainnav-open').hide();
			} else {
				$mainnav.show().addClass('mainnav-open');
			}
		});
	});
})(jQuery);