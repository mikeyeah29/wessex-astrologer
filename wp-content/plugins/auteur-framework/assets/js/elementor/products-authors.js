
(function ($) {
	'use strict';
	var Products_Authors_Handler = function ($scope, $) {
		G5_Core.owlCarousel.init($scope);
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/auteur-products-authors.default', Products_Authors_Handler);
	});

})(jQuery);