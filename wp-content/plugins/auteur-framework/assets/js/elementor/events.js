(function ($) {
    'use strict';
    var Events_Handler = function ($scope, $) {
        new G5_Core_Animation($scope);
    };
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/auteur-events.default', Events_Handler);
    });

})(jQuery);