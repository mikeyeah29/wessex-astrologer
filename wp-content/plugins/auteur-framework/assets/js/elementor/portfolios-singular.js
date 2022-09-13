(function ($) {
	'use strict';
	var Portfolios_Singular_Handler = function ($scope, $) {
		G5_Core.owlCarousel.init($scope);
		$('.gsf-portfolio-singular').each(function () {
			var owl_carousel = $('.portfolio-singular-wrap.owl-carousel', $(this)),
				portfolio_index = $('.portfolio-index-wrap', $(this));
			owl_carousel.on('changed.owl.carousel', function(el) {
				var item = $('[data-item-index="' + el.item.index + '"]', portfolio_index);
				portfolio_index.find('.active').removeClass('active');
				item.addClass('active');
			});
			$('.index-item', portfolio_index).on('click', function (event) {
				event.preventDefault();
				if ($(this).hasClass('active')) return;
				var index = $(this).data('item-index');
				owl_carousel.data('owl.carousel').to(index, 300,true);
			});
		});
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/auteur-portfolios-singular.default', Portfolios_Singular_Handler);
	});

})(jQuery);