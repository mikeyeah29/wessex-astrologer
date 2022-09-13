(function ($) {
	"use strict";

	var BPFW = {
		init: function () {
			this.actionFlipBack();
			this.actionReadBook();
			this.actionZoomIn();
			this.actionZoomOut();
			this.variation();
		},

		actionFlipBack: function () {
			$(document).on('click', '.bpfw-action-flip', function (e) {
				e.preventDefault();
				$('.bpfw-flip-wrapper').toggleClass('bpfw-view');
			});
		},
		actionReadBook: function () {
			$(document).on('click', '.bpfw-action-read-book', function (e) {
				e.preventDefault();

				var $this = $(this),
					urlPopup = $this.attr('href');

				$.ajax({
					'type': 'get',
					'url': urlPopup,
					'success': function (res) {
						if ($('#bpfw-popup').length > 0) {
							$('#bpfw-popup').remove();
						}

						var mfOptions = {
							closeOnBgClick: true,
							closeBtnInside: true,
							mainClass: 'mfp-zoom-in',
							midClick: true,
							items: {
								'src': urlPopup,
								'type': 'ajax'
							},
							callbacks: {
								ajaxContentAdded: function() {
									var popup_height = $(window).height() - 150;
									$('.bpfw-popup-content-wrapper').css('height', popup_height);
								}
							}
						};
						$.magnificPopup.open(mfOptions);
					}
				});
			});
		},
		actionZoomIn: function () {
			$(document).on('click', '.bpfw-preview-zoom-in', function (e) {
				e.preventDefault();

				var wrapWidth = $('.bpfw-popup-content-wrapper').width();
				var contentWidth = $('.bpfw-popup-content').width();

				if (contentWidth < wrapWidth) {
					contentWidth = contentWidth + 100;
					$('.bpfw-popup-content').css('width', contentWidth);
				}
			});
		},
		actionZoomOut: function () {
			$(document).on('click', '.bpfw-preview-zoom-out', function (e) {
				e.preventDefault();
				var contentWidth = $('.bpfw-popup-content').width();
				if (contentWidth > 600) {
					contentWidth = contentWidth - 100;
					$('.bpfw-popup-content').css('width', contentWidth);
				}
			});
		},
		variation: function () {
			var $current_image_front =  $('.bpfw-images .bpfw-flip-front img');
			var $current_image =   $('.bpfw-flip-wrapper > img');

			if (typeof $current_image.attr('src') !== 'undefined') {
				$current_image.attr('data-src',$current_image.attr('src'));
			}

			if (typeof $current_image.attr('width') !== 'undefined') {
				$current_image.attr('data-width',$current_image.attr('width'));
			}

			if (typeof $current_image.attr('height') !== 'undefined') {
				$current_image.attr('data-height',$current_image.attr('height'));
			}


			if (typeof $current_image_front.attr('src') !== 'undefined') {
				$current_image_front.attr('data-src',$current_image_front.attr('src'));
			}

			if (typeof $current_image_front.attr('width') !== 'undefined') {
				$current_image_front.attr('data-width',$current_image_front.attr('width'));
			}

			if (typeof $current_image_front.attr('height') !== 'undefined') {
				$current_image_front.attr('data-height',$current_image_front.attr('height'));
			}

			if (typeof $current_image_front.attr('sizes') !== 'undefined') {
				$current_image_front.attr('data-sizes',$current_image_front.attr('sizes'));
			}

			if (typeof $current_image_front.attr('srcset') !== 'undefined') {
				$current_image_front.attr('data-srcset',$current_image_front.attr('srcset'));
			}

			if ($current_image_front.length === 0 || $current_image.length === 0) return;
			$(document).on('found_variation', function (event, variation) {
				if ((typeof variation !== 'undefined') && (typeof variation.image !== 'undefined')) {
					if (typeof variation.image.src !== 'undefined') {
						$current_image_front.attr('src',variation.image.src);
						$current_image.attr('src',variation.image.src);
					}

					if (typeof variation.image.src_w !== 'undefined') {
						$current_image_front.attr('width',variation.image.src_w);
						$current_image.attr('width',variation.image.src_w);
					}

					if (typeof variation.image.src_h !== 'undefined') {
						$current_image_front.attr('height',variation.image.src_h);
						$current_image.attr('height',variation.image.src_h);
					}

					if (typeof variation.image.sizes !== 'undefined') {
						$current_image_front.attr('sizes',variation.image.sizes);
					}

					if (typeof variation.image.srcset !== 'undefined') {
						$current_image_front.attr('srcset',variation.image.srcset);
					}
				}
			});

			$(document).on('reset_data', function (event) {
				if (typeof $current_image.attr('data-src') !== 'undefined') {
					$current_image.attr('src',$current_image.attr('data-src'));
				}

				if (typeof $current_image.attr('data-width') !== 'undefined') {
					$current_image.attr('width',$current_image.attr('data-width'));
				}

				if (typeof $current_image.attr('data-height') !== 'undefined') {
					$current_image.attr('height',$current_image.attr('data-height'));
				}


				if (typeof $current_image_front.attr('data-src') !== 'undefined') {
					$current_image_front.attr('src',$current_image_front.attr('data-src'));
				}

				if (typeof $current_image_front.attr('data-width') !== 'undefined') {
					$current_image_front.attr('width',$current_image_front.attr('data-width'));
				}

				if (typeof $current_image_front.attr('data-height') !== 'undefined') {
					$current_image_front.attr('height',$current_image_front.attr('data-height'));
				}

				if (typeof $current_image_front.attr('data-sizes') !== 'undefined') {
					$current_image_front.attr('sizes',$current_image_front.attr('data-sizes'));
				}

				if (typeof $current_image_front.attr('data-srcset') !== 'undefined') {
					$current_image_front.attr('srcset',$current_image_front.attr('data-srcset'));
				}

			});
		}
	};

	$(document).ready(function () {
		BPFW.init();
	});
})(jQuery);