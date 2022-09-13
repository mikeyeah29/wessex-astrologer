var BPFW_ADMIN;
(function ($) {
	"use strict";

	BPFW_ADMIN = {
		init: function () {
			var $wrap = $('.bpfw-back-image-wrap'),
				$imageLink = $wrap.find('.bpfw-back-image'),
				$backImageID = $wrap.find('.back-image-id'),
				$setImageBtn = $wrap.find('.bpfw-set-image-button'),
				$removeImageBtn = $wrap.find('.bpfw-remove-image-button');

			var mediaPopup = wp.media({
				title: $setImageBtn.data('title'),
				library: {
					type: 'image'
				},
				button: {
					text: $setImageBtn.data('button')
				},
				multiple: false
			});

			/**
			 * Select Image
			 */
			mediaPopup.on('select', function () {
				var attachment = mediaPopup.state().get('selection').first().toJSON();

				$imageLink.html('<img class="true_pre_image" src="' + attachment.url + '" />');
				$backImageID.val(attachment.id);
				$wrap.addClass('has-back-image');
			});

			/**
			 * Click set image
			 */
			$setImageBtn.on('click', function (e) {
				e.preventDefault();
				mediaPopup.open();
			});

			/**
			 * Change image
			 */
			$imageLink.on('click', function (e) {
				e.preventDefault();
				mediaPopup.open();
				var selection = mediaPopup.state().get( 'selection' );
				selection.add( wp.media.attachment( parseInt($backImageID.val())));
			});

			/**
			 * Remove Image
			 */
			$removeImageBtn.on('click', function (e) {
				e.preventDefault();
				$imageLink.html('');
				$backImageID.val('');
				$wrap.removeClass('has-back-image');
			});
		}
	};
	$(document).ready(function () {
		BPFW_ADMIN.init();
	});
})(jQuery);
