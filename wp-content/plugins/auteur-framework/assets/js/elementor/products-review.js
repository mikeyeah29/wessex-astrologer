
(function ($) {
	'use strict';
	var Products_Review_Handler = function ($scope, $) {
		G5_Core.owlCarousel.init($scope);
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/auteur-products-review.default', Products_Review_Handler);
	});

})(jQuery);