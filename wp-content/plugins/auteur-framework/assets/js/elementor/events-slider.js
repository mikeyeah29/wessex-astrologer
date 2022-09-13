(function ($) {
    'use strict';
    var Events_Slider_Handler = function ($scope, $) {
        new G5_Core_Animation($scope);
        G5_Core.owlCarousel.init($scope);
    };
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/auteur-events-slider.default', Events_Slider_Handler);
    });

})(jQuery);