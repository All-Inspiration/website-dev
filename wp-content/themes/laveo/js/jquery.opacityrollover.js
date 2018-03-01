/**
 * jQuery Opacity Rollover plugin
 *
 * Copyright (c) 2009 Trent Foley (http://trentacular.com)
 * Licensed under the MIT License:
 *   http://www.opensource.org/licenses/mit-license.php
 */

!function (a) {
	var b = {
		mouseOutOpacity  : .67,
		mouseOverOpacity : 1,
		fadeSpeed        : "fast",
		exemptionSelector: ".selected"
	};
	a.fn.opacityrollover = function (c) {
		function e(b, c) {
			var e = a(b);
			d.exemptionSelector && (e = e.not(d.exemptionSelector)), e.fadeTo(d.fadeSpeed, c)
		}

		a.extend(this, b, c);
		var d = this;
		return this.css("opacity", this.mouseOutOpacity).hover(function () {
			e(this, d.mouseOverOpacity)
		}, function () {
			e(this, d.mouseOutOpacity)
		}), this
	}
}(jQuery);