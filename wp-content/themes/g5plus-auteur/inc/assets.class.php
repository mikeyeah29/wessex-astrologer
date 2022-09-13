<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('G5Plus_Auteur_Assets')) {
	class G5Plus_Auteur_Assets
	{
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function registerAssets()
		{
			// Bootstrap
			wp_register_style('bootstrap', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/bootstrap-4.0.0/css/bootstrap.min.css'), array(), '4.0.0');
			wp_register_script('popper', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/popper/popper.min.js'), array('jquery'), '1.0.0', true);
			wp_register_script('bootstrap-affix', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/bootstrap-4.0.0/js/bootstrap.affix.min.js'), array('jquery'), '1.0.0', true);
			wp_register_script('bootstrap', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/bootstrap-4.0.0/js/bootstrap.min.js'), array('jquery', 'popper', 'bootstrap-affix'), '4.0.0', true);
			wp_register_style('custom-bootstrap', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/bootstrap-4.0.0/css/custom-bootstrap.min.css'), array('bootstrap'), '4.0.0');


			//Owl.Carousel
			wp_register_style('owl-carousel', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/owl.carousel/assets/owl.carousel.min.css'), array(), '2.2.0');
			wp_register_style('owl-carousel-theme-default', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/owl.carousel/assets/owl.theme.default.min.css'), array(), '2.2.0');
			wp_register_script('owl-carousel', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/owl.carousel/owl.carousel.min.js'), array('jquery'), '2.2.0', true);

			// isotope
			wp_register_script('isotope', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/isotope/isotope.pkgd.min.js'), array('jquery'), '3.0.5', true);

			// jquery.cookie
			wp_register_script('jquery-cookie', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/jquery.cookie/jquery.cookie.min.js'), array('jquery'), '1.4.1', true);

			// Perfect-scrollbar
			wp_register_script('perfect-scrollbar', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js'), array('jquery'), '0.6.15', true);
			wp_register_style('perfect-scrollbar', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/perfect-scrollbar/css/perfect-scrollbar.min.css'), array(), '0.6.15');


			// Magnific Popup
			wp_register_style('magnific-popup', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/magnific-popup/magnific-popup.min.css'), array(), '1.1.0');
			wp_register_script('magnific-popup', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/magnific-popup/jquery.magnific-popup.min.js'), array('jquery'), '1.1.0', true);

			// waypoints
			wp_register_script('waypoints', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/waypoints/jquery.waypoints.min.js'), array('jquery'), '4.0.1', true);

			// animated
			wp_register_style('animate-css', G5Plus_Auteur()->helper()->getAssetUrl('assets/css/animate.min.css'), array(), '1.0');

			//ladda
			wp_register_style('ladda', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/ladda/ladda-themeless.min.css'), array(), '1.0.5');
			wp_register_script('ladda-spin', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/ladda/spin.min.js'), array('jquery'), '1.0.5', true);
			wp_register_script('ladda', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/ladda/ladda.min.js'), array('jquery', 'ladda-spin'), '1.0.5', true);
			wp_register_script('ladda-jquery', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/ladda/ladda.jquery.min.js'), array('jquery', 'ladda'), '1.0.5', true);


			// hc-sticky
			wp_register_script('hc-sticky', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/hc-sticky/jquery.hc-sticky.min.js'), array('jquery'), '1.2.43', true);

			// Justified
			wp_register_style('justified-css', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/justified/justifiedGallery.min.css'), array(), '3.6.3');
			wp_register_style('custom-justified-css', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/justified/custom-justified.min.css'), array(), '1.0.0');
			wp_register_script('justified', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/justified/jquery.justifiedGallery.min.js'), array('jquery'), '3.6.3', true);

			// lazy-load
			wp_register_script('jquery-lazyload', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/lazyload/jquery.lazyload.min.js'), array('jquery'), '1.9.3', true);


			// modernizr
			wp_register_script('modernizr', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/modernizr/modernizr.js'), array('jquery'), '3.5.0', true);

			// imagesloaded
			wp_register_script('imagesloaded', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/imagesloaded/imagesloaded.pkgd.min.js'), array('jquery'), '4.1.3', true);

			// jquery.easing
			wp_register_script('jquery-easing', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/jquery.easing/jquery.easing.1.3.js'), array('jquery'), '1.3', true);

			// jquery.countdown
			wp_register_script('jquery-countdown', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/jquery.countdown/jquery.countdown.min.js'), array('jquery'), '2.2.0', true);

			// jquery.nav
			wp_register_script('jquery-nav', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/jquery.nav/jquery.nav.min.js'), array('jquery'), '3.0.0', true);


			wp_register_script(G5Plus_Auteur()->helper()->assetsHandle('core'), G5Plus_Auteur()->helper()->getAssetUrl('assets/js/core.min.js'), array('jquery'), '1.0', true);

			wp_register_script(G5Plus_Auteur()->helper()->assetsHandle('woocommerce'), G5Plus_Auteur()->helper()->getAssetUrl('assets/js/woocommerce.min.js'), array(G5Plus_Auteur()->helper()->assetsHandle('core')), '1.0', true);

			wp_register_script(G5Plus_Auteur()->helper()->assetsHandle('woocommerce-swatches'), G5Plus_Auteur()->helper()->getAssetUrl('assets/js/woocommerce-swatches.min.js'), array(G5Plus_Auteur()->helper()->assetsHandle('woocommerce')), '1.0', true);
			wp_localize_script(G5Plus_Auteur()->helper()->assetsHandle('woocommerce-swatches'), 'woocommerce_swatches_var', array(
				'price_selector' => apply_filters('gf_price_selector', '.price'),
				'localization' => array(
					'add_to_cart_text' => esc_html__('Add to cart', 'g5plus-auteur'),
					'read_more_text' => esc_html__('Read more', 'g5plus-auteur'),
					'select_options_text' => esc_html__('Select options', 'g5plus-auteur'),
				),
			));

			wp_register_script(G5Plus_Auteur()->helper()->assetsHandle('portfolio'), G5Plus_Auteur()->helper()->getAssetUrl('assets/js/portfolio.min.js'), array(G5Plus_Auteur()->helper()->assetsHandle('core')), '1.0', true);
			wp_register_style(G5Plus_Auteur()->helper()->assetsHandle('portfolio'), G5Plus_Auteur()->helper()->getAssetUrl('assets/css/portfolio.min.css'));

			wp_register_script(G5Plus_Auteur()->helper()->assetsHandle('main'), G5Plus_Auteur()->helper()->getAssetUrl('assets/js/main.min.js'), array('jquery'), '1.0', true);

			wp_register_style('font-awesome-5pro', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/font-awesome/css/fontawesome.min.css'), array(), '5.1.0');

			wp_register_script('pretty-tabs', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/pretty-tabs/jquery.pretty-tabs.min.js'), array('jquery'), '1.0', true);

			//slick slider
			wp_register_style('slick', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/slick/css/slick.min.css'), array(),'1.8.0');

			wp_register_script('slick', G5Plus_Auteur()->helper()->getAssetUrl('assets/vendors/slick/js/slick.min.js'), array('jquery'), '1.8.0', true);

			wp_register_style(G5Plus_Auteur()->helper()->assetsHandle('woocommerce'), G5Plus_Auteur()->helper()->getAssetUrl('assets/css/woocommerce.min.css'));

			wp_register_style(G5Plus_Auteur()->helper()->assetsHandle('tribe-events'), G5Plus_Auteur()->helper()->getAssetUrl('assets/css/tribe-events.min.css'));
		}


		public function enqueueAssets()
		{

			// modernizr
			wp_enqueue_script('modernizr');

			// modernizr
			wp_enqueue_script('imagesloaded');

			// jquery.easing
			wp_enqueue_script('jquery-easing');

			// jquery.countdown
			wp_enqueue_script('jquery-countdown');


			// Bootstrap
			wp_enqueue_style('bootstrap');
			wp_enqueue_script('bootstrap');
			wp_enqueue_style('custom-bootstrap');

			// Owl.Carousel
			wp_enqueue_style('owl-carousel');
			wp_enqueue_style('owl-carousel-theme-default');
			wp_enqueue_script('owl-carousel');

			//isotope
			wp_enqueue_script('isotope');

			// Perfect-scrollbar
			wp_enqueue_style('perfect-scrollbar');
			wp_enqueue_script('perfect-scrollbar');

			wp_enqueue_style('font-awesome-5pro');

			// Magnific Popup
			wp_enqueue_style('magnific-popup');
			wp_enqueue_script('magnific-popup');
			wp_enqueue_script('jquery-cookie');

			// animated
			wp_enqueue_style('animate-css');

			//waypoints
			wp_enqueue_script('waypoints');

			//ladda
			wp_enqueue_style('ladda');
			wp_enqueue_script('ladda-jquery');


			// hc-sticky
			wp_enqueue_script('hc-sticky');

			wp_enqueue_script('pretty-tabs');

			//slick
			wp_enqueue_style('slick');
			wp_enqueue_script('slick');


			// comment
			if (is_singular()) wp_enqueue_script('comment-reply');


			// lazyLoad
			$lazy_load_images = G5Plus_Auteur()->options()->get_lazy_load_images();
			if ($lazy_load_images === 'on') {
				wp_enqueue_script('jquery-lazyload');
			}

			$is_one_page = G5Plus_Auteur()->metaBox()->get_is_one_page();
			if ($is_one_page === 'on') {
				wp_enqueue_script('jquery-nav');
			}

			// js Core
			wp_enqueue_script(G5Plus_Auteur()->helper()->assetsHandle('core'));



			$loading_animation = G5Plus_Auteur()->options()->get_loading_animation();
			if (in_array($loading_animation,array(
				'chasing-dots',
				'circle',
				'cube',
				'double-bounce',
				'fading-circle',
				'folding-cube',
				'pulse',
				'three-bounce',
				'wave'
			))) {
				wp_enqueue_style('loading-animation', G5Plus_Auteur()->helper()->getAssetUrl("assets/css/loading/{$loading_animation}.min.css"), array());
			}

			// js Main
			wp_enqueue_script(G5Plus_Auteur()->helper()->assetsHandle('main'));

			// js variable
			wp_localize_script(
				G5Plus_Auteur()->helper()->assetsHandle('main'),
				'g5plus_variable',
				array(
					'ajax_url' => admin_url('admin-ajax.php'),
					'theme_url' => G5Plus_Auteur()->themeUrl(),
					'site_url' => site_url(),
					'pretty_tabs_more_text' => wp_kses_post(__('More <span class="caret"></span>', 'g5plus-auteur'))
				)
			);


			wp_enqueue_style(G5Plus_Auteur()->helper()->assetsHandle('main'), G5Plus_Auteur()->helper()->getAssetUrl('style.min.css'));

			// js woocommerce
			if (class_exists('WooCommerce')) {
				wp_enqueue_script(G5Plus_Auteur()->helper()->assetsHandle('woocommerce'));
				wp_enqueue_style(G5Plus_Auteur()->helper()->assetsHandle('woocommerce'));
				$swatches_enable = G5Plus_Auteur()->options()->get_product_swatches_enable();
				$single_swatches_enable = G5Plus_Auteur()->options()->get_product_single_swatches_enable();
				if ('on' === $swatches_enable || 'on' === $single_swatches_enable) {
					wp_enqueue_script(G5Plus_Auteur()->helper()->assetsHandle('woocommerce-swatches'));
				}
			}

			// js portfolio
			$custom_post_type_disable = G5Plus_Auteur()->options()->get_custom_post_type_disable();
			if (!in_array('portfolio', $custom_post_type_disable)) {
				wp_enqueue_script(G5Plus_Auteur()->helper()->assetsHandle('portfolio'));
				wp_enqueue_style(G5Plus_Auteur()->helper()->assetsHandle('portfolio'));
				wp_enqueue_script('justified');
				wp_enqueue_style('justified-css');
				wp_enqueue_style('custom-justified-css');
			}

			if (class_exists('Tribe__Events__Main')) {
				wp_enqueue_style(G5Plus_Auteur()->helper()->assetsHandle('tribe-events'));
			}

			$rtl = is_rtl() || G5Plus_Auteur()->options()->get_rtl_enable() === 'on' || isset($_GET['RTL']);
			if ($rtl) {
				wp_enqueue_style(G5Plus_Auteur()->helper()->assetsHandle('rtl'), G5Plus_Auteur()->helper()->getAssetUrl('assets/css/rtl.min.css'));
				wp_add_inline_style(G5Plus_Auteur()->helper()->assetsHandle('main'), $this->rtl_responsive_css());
			}


		}


		public function rtl_responsive_css()
		{
			$responsive_break_point = absint(G5Plus_Auteur()->options()->get_header_responsive_breakpoint());
			$responsive_break_point_2 = $responsive_break_point + 1;
			return <<<CUSTOM_CSS

/**
* base/Header RTL
* ----------------------------------------------------------------------------
*/
			
@media screen and (min-width: {$responsive_break_point_2}px) {
	header.main-header.header-1 .no-menu {
    text-align: left;
  }
  header.main-header.header-3 .logo-header {
    margin-left: 100px;
    margin-right: 0;
  }
  header.main-header.header-3 .no-menu {
    text-align: right;
  }
  header.main-header.header-2 .logo-header {
    margin-left: 30px;
    margin-right: 0;
  }
  header.main-header.header-5 .primary-menu-inner {
    padding-left: 30px;
    padding-right: 0;
  }
  header.main-header.header-7 .gf-menu-canvas {
    margin-right: var(--g5-header-customize-nav-spacing);
    margin-left: 0;
  }
  header.main-header.header-vertical {
    left: 0;
    right: auto;
  }

  body.header-left {
    padding-right: 100px;
    padding-left: 0;
  }
  body.header-right {
    padding-left: 100px;
    padding-right: 0;
  }
  body.header-right header.main-header.header-vertical {
    right: auto;
    left: 0;
  }

  body.bordered .back-to-top {
    left: 40px;
    right: auto;
  }
}

/**
* Header Mobile RTL
* ----------------------------------------------------------------------------
*/

@media (max-width: {$responsive_break_point}px) {
  header.mobile-header.header-1 .mobile-header-menu {
    text-align: right;
  }
  header.mobile-header.header-2 ul.header-customize-mobile > li:last-child {
    margin-left: var(--g5-header-customize-mobile-spacing);
    margin-right: 0;
  }
  header.mobile-header.header-2 ul.header-customize-mobile + .mobile-header-menu {
    margin-right: var(--g5-header-customize-mobile-spacing);
    margin-left: 0;
  }
  header.mobile-header.header-3 ul.header-customize-mobile > li:first-child {
    margin-right: var(--g5-header-customize-mobile-spacing);
    margin-left: 0;
  }

  .mobile-header-search .search-form input[type=search] {
    padding-right: 0;
    padding-left: 40px;
  }
  .mobile-header-search .search-form button[type=submit] {
    left: -15px;
    right: auto;
  }
}

/**
* Footer RTL
* ----------------------------------------------------------------------------
*/

@media screen and (min-width: {$responsive_break_point_2}px) {
  body.header-left footer.footer-fixed {
    right: 300px;
    left: auto;
  }

  body.header-right footer.footer-fixed {
    left: 300px;
    right: auto;
  }
}

CUSTOM_CSS;

		}


		public function enqueue_icon_font()
		{
			if (!function_exists('G5P')) {
				$icon_font_css = G5Plus_Auteur()->fontIcons()->registerAssets();
				foreach ($icon_font_css as $font_key => $font_value) {
					wp_enqueue_style($font_key, $font_value['url'], array(), $font_value['ver']);
				}
				wp_enqueue_style('google_fonts', 'https://fonts.googleapis.com/css?family=Libre+Baskerville%3Aregular%2C400i%2C700%7CNunito+Sans%3A200%2C200i%2C300%2C300i%2Cregular%2C400i%2C600%2C600i%2C700%2C700i%2C800%2C800i%2C900%2C900i&subset=latin%2Clatin-ext%2Cvietnamese');

			}
		}

		public function getCustomCss()
		{
			$custom_css = '';

			/**
			 * Custom Background
			 */
			$custom_background = array(
				'body_background' => array(
					'selector' => 'body',
					'default' => ''
				),
				'header_background' => array(
					'selector' => '.main-header',
					'default' => ''
				),
				'header_sticky_background' => array(
					'selector' => '.main-header .header-sticky.affix',
					'default' => ''
				),
				'mobile_header_background' => array(
					'selector' => '.mobile-header',
					'default' => ''
				),
				'mobile_header_sticky_background' => array(
					'selector' => '.mobile-header .header-sticky.affix',
					'default' => ''
				)
			);
			foreach ($custom_background as $key => $value) {
				$background = G5Plus_Auteur()->options()->getOptions($key);
				$background_attributes = array();
				if (isset($background['background_color']) && !empty($background['background_color'])) {
					$background_attributes[] = "background-color: {$background['background_color']} !important";
				}

				if (isset($background['background_image_url']) && !empty($background['background_image_url'])) {
					$background_repeat = isset($background['background_repeat']) ? $background['background_repeat'] : '';
					$background_position = isset($background['background_position']) ? $background['background_position'] : '';
					$background_size = isset($background['background_size']) ? $background['background_size'] : '';
					$background_attachment = isset($background['background_attachment']) ? $background['background_attachment'] : '';

					$background_attributes[] = "background-image: url('{$background['background_image_url']}')";

					if (!empty($background_repeat)) {
						$background_attributes[] = "background-repeat: {$background_repeat}";
					}

					if (!empty($background_position)) {
						$background_attributes[] = "background-position: {$background_position}";
					}

					if (!empty($background_size)) {
						$background_attributes[] = "background-size: {$background_size}";
					}

					if (!empty($background_attachment)) {
						$background_attributes[] = "background-attachment: {$background_attachment}";
					}

				}

				$background_css = implode('; ', array_filter($background_attributes));

				$custom_css .= <<<CSS
			{$value['selector']} {
				{$background_css}
			}
CSS;
			}

			/**
			 * Custom Background Color
			 */
			$custom_background_color = array(
				'loading_animation_bg_color' => array('.site-loading' => 'background-color'), /* loading background color */
				'content_background_color' => array('#gf-wrapper' => 'background-color'), /* content background color */
				'top_drawer_background_color' => array('.top-drawer-wrap' => 'background-color', '.top-drawer-toggle' => 'border-top-color'), /* top drawer background color */
				'menu_background_color' => array('.main-header.header-4 .primary-menu' => 'background-color',
					'#popup-canvas-menu .modal-content' => 'background-color'), /* menu background color */
				'menu_sticky_background_color' => array('.main-header.header-4 .header-sticky.affix.primary-menu' => 'background-color'), /* menu sticky background color */
				'submenu_background_color' => array('.main-menu .sub-menu' => 'background-color'), /* submenu background color*/
				'canvas_sidebar_background_color' => array('.canvas-sidebar-wrapper' => 'background-color'), /* Canvas Sidebar Background Color */
				'page_title_background_color' => array('.gf-page-title' => 'background-color'), /* Page Title Background Color */
			);
			foreach ($custom_background_color as $key => $value) {
				$color = G5Plus_Auteur()->options()->getOptions($key);
				if (!empty($color)) {
					foreach ($value as $selector => $property) {
						$custom_css .= <<<CSS
				{$selector} {
					{$property}: {$color} !important;
				}
CSS;
					}
				}
			}

			/* Custom scroll */
			$custom_scroll = G5Plus_Auteur()->options()->get_custom_scroll();
			if ($custom_scroll === 'on') {
				$custom_scroll_width = G5Plus_Auteur()->options()->get_custom_scroll_width();
				$custom_scroll_color = G5Plus_Auteur()->options()->get_custom_scroll_color();
				$custom_scroll_thumb_color = G5Plus_Auteur()->options()->get_custom_scroll_thumb_color();

				$custom_css .= <<<CSS
				body::-webkit-scrollbar {
					width: {$custom_scroll_width}px;
					background-color: {$custom_scroll_color};
				}
				body::-webkit-scrollbar-thumb {
				background-color: {$custom_scroll_thumb_color};
				}
CSS;
			}

			$header_responsive_breakpoint = G5Plus_Auteur()->options()->get_header_responsive_breakpoint();
			$header_responsive_breakpoint = (int)$header_responsive_breakpoint;
			$header_responsive_breakpoint_desktop = $header_responsive_breakpoint + 1;

			/* Custom Padding*/
			$custom_padding = array(
				'top_drawer_padding' => '.top-drawer-content',
				'header_padding' => '.header-inner',
				'mobile_header_padding' => '.mobile-header-inner',
				'content_padding' => '#primary-content',
				'woocommerce_customize_padding' => '.gsf-catalog-full-width .woocommerce-custom-wrap > .container, .gsf-catalog-full-width #gf-filter-content > .container, .gsf-catalog-full-width .clear-filter-wrap > .container'
			);
			$custom_padding = apply_filters('gsf_custom_padding', $custom_padding);

			foreach ($custom_padding as $optionKey => $selector) {
				$padding = G5Plus_Auteur()->options()->getOptions($optionKey);
				if (is_array($padding)) {
					$padding_css = '';
					foreach ($padding as $key => $value) {

						if ($value !== '') {
							$padding_css .= <<<CSS
                            padding-{$key}: {$value}px;
CSS;
						}
					}
					if ($padding_css !== '') {
						if (in_array($optionKey, array('content_padding', 'woocommerce_customize_padding'))) {
							$custom_css .= <<<CSS
                            @media (min-width: {$header_responsive_breakpoint_desktop}px) {
                                {$selector} {
                                    {$padding_css}
                                }
                            }
CSS;
						} else {
							$custom_css .= <<<CSS
                            {$selector} {
                                {$padding_css}
                            }
CSS;
						}
					}
				}
			}

			/* Custom Padding Mobile */

			$custom_padding_mobile = array(
				'mobile_content_padding' => '#primary-content'
			);
			$custom_padding_mobile = apply_filters('gsf_custom_padding_mobile', $custom_padding_mobile);

			foreach ($custom_padding_mobile as $optionKey => $selector) {
				$padding = G5Plus_Auteur()->options()->getOptions($optionKey);
				if (is_array($padding)) {
					$padding_css = '';
					foreach ($padding as $key => $value) {

						if ($value !== '') {
							$padding_css .= <<<CSS
                            padding-{$key}: {$value}px;
CSS;
						}
					}
					if ($padding_css !== '') {
						$custom_css .= <<<CSS
                        @media (max-width: {$header_responsive_breakpoint}px) {
                            {$selector} {
                                {$padding_css}
                            }
                        }

CSS;
					}
				}

			}

			/* Image Size */
			global $_wp_additional_image_sizes;
			foreach (get_intermediate_image_sizes() as $_size) {
				$width = $height = 0;
				if (in_array($_size, array('thumbnail', 'medium', 'medium_large', 'large'))) {
					$width = get_option("{$_size}_size_w");
					$height = get_option("{$_size}_size_h");
				} elseif (isset($_wp_additional_image_sizes[$_size])) {
					$width = $_wp_additional_image_sizes[$_size]['width'];
					$height = $_wp_additional_image_sizes[$_size]['height'];
				}
				if ($height > 0 && $width > 0) {
					$ratio = ($height / $width) * 100;
					$custom_css .= <<<CSS
                .embed-responsive-{$_size}:before,    
                .thumbnail-size-{$_size}:before {
                    padding-top: {$ratio}%;
                }
CSS;
				}
			}

			$stripes_url = G5Plus_Auteur()->helper()->getAssetUrl('assets/images/diagonal-stripes.png');
			$stripes1_url = G5Plus_Auteur()->helper()->getAssetUrl('assets/images/diagonal-stripes-01.png');
			$custom_css .= <<<CSS
            .product-author-wrap .author-avatar-wrap:after {
              background-image: url('{$stripes_url}');
            }

            .single-author-info .single-author-thumbnail .author-thumbnail-inner:before {
              background-image: url('{$stripes1_url}');
            }
CSS;
			$custom_css .= $this->header_responsive_css();
			$custom_css .= G5Plus_Auteur()->options()->get_custom_css();
			$custom_css = strip_tags(apply_filters('g5plus_custom_css', $custom_css));
			wp_add_inline_style(G5Plus_Auteur()->helper()->assetsHandle('main'), $custom_css);
		}


		public function header_responsive_css()
		{
			$responsive_break_point = absint(G5Plus_Auteur()->options()->get_header_responsive_breakpoint());
			$responsive_break_point_2 = $responsive_break_point + 1;
			return <<<CUSTOM_CSS
@media screen and (max-width: {$responsive_break_point}px) {
.gf-hidden-mobile {
		display: none;
	}
	
	body.off-canvas-in .canvas-overlay{
			max-width: 100%;
			opacity: 1;
			visibility: visible;
	}
	
}


@media (min-width: {$responsive_break_point_2}px) {
	body.header-left footer.footer-fixed {
		left: 300px;
	}

	body.header-right footer.footer-fixed {
		right: 300px;
	}
}

@media screen and (min-width:  {$responsive_break_point_2}px) {
	.header-customize-separator {
		width: 1px;
		height: 18px;
	}
}

/**
* Header Desktop
* ----------------------------------------------------------------------------
*/

@media screen and (min-width: {$responsive_break_point_2}px) {
	header.mobile-header {
		display: none;
		height: 0;
	}
	
	body.header-left {
        padding-left: 100px;
	}
	body.header-right {
	  padding-right: 100px;
	}
	body.header-right header.main-header.header-menu-vertical {
	  left: auto;
	  right: 0;
	}
	body.header-menu-left {
	  padding-left: 300px;
	}
	body.header-menu-right {
	  padding-right: 300px;
	}
	body.header-menu-right header.main-header.header-menu-vertical {
	  left: auto;
	  right: 0;
	}
	
	body.framed,
	body.boxed,
	body.bordered {
	  background-color: #eee;
	}
	
	body.framed #gf-wrapper,
	body.boxed #gf-wrapper {
	  max-width: 1236px;
	  margin: auto;
	  position: relative;
	}
	body.framed .header-sticky.affix,
	body.boxed .header-sticky.affix {
	  max-width: 1236px;
	}
	
	body.framed #gf-wrapper {
	  margin-top: 50px;
	  margin-bottom: 50px;
	}
	
	body.bordered #gf-wrapper {
	  margin: 30px;
	}
	body.bordered:before, body.bordered:after {
	  content: "";
	  display: block;
	  position: fixed;
	  left: 0;
	  right: 0;
	  z-index: 9999;
	  background: inherit;
	  height: 30px;
	}
	body.bordered:before {
	  top: 0;
	}
	body.bordered:after {
	  bottom: 0;
	}
	body.bordered.admin-bar:before {
	  top: 32px;
	}
	body.bordered .back-to-top {
	  bottom: 40px;
	  right: 40px;
	}
}


/**
* Header Mobile
* ----------------------------------------------------------------------------
*/

@media (max-width: {$responsive_break_point}px) {
	header.main-header {
		display: none;
	}
	
	.header-sticky.affix .gf-toggle-icon > span {
      background-color: var(--g5-mobile-menu-customize-sticky-text-color);
	}
	.header-sticky.affix .gf-toggle-icon > span:after, .header-sticky.affix .gf-toggle-icon > span:before {
	  background-color: var(--g5-mobile-menu-customize-sticky-text-color);
	}
	.header-sticky.affix .gf-toggle-icon:hover span,
	.header-sticky.affix .gf-toggle-icon:hover span:before,
	.header-sticky.affix .gf-toggle-icon:hover span:after {
	  background-color: var(--g5-mobile-menu-customize-text-hover-color);
	}
	.header-sticky.affix .customize-search > a,
	.header-sticky.affix .item-wishlist a,
	.header-sticky.affix .item-my-account a {
	  color: var(--g5-mobile-menu-customize-sticky-text-color);
	}
	.header-sticky.affix .customize-search > a:hover, .header-sticky.affix .customize-search > a:focus, .header-sticky.affix .customize-search > a:active,
	.header-sticky.affix .item-wishlist a:hover,
	.header-sticky.affix .item-wishlist a:focus,
	.header-sticky.affix .item-wishlist a:active,
	.header-sticky.affix .item-my-account a:hover,
	.header-sticky.affix .item-my-account a:focus,
	.header-sticky.affix .item-my-account a:active {
	  color: var(--g5-mobile-menu-customize-text-hover-color);
	}
	.header-sticky.affix .header-sticky.affix .customize-search > a,
	.header-sticky.affix .header-sticky.affix .item-wishlist a,
	.header-sticky.affix .header-sticky.affix .item-my-account a {
	  color: var(--g5-mobile-menu-customize-sticky-text-color);
	}
	.header-sticky.affix .header-sticky.affix .customize-search > a:hover, .header-sticky.affix .header-sticky.affix .customize-search > a:focus, .header-sticky.affix .header-sticky.affix .customize-search > a:active,
	.header-sticky.affix .header-sticky.affix .item-wishlist a:hover,
	.header-sticky.affix .header-sticky.affix .item-wishlist a:focus,
	.header-sticky.affix .header-sticky.affix .item-wishlist a:active,
	.header-sticky.affix .header-sticky.affix .item-my-account a:hover,
	.header-sticky.affix .header-sticky.affix .item-my-account a:focus,
	.header-sticky.affix .header-sticky.affix .item-my-account a:active {
	  color: var(--g5-mobile-menu-customize-text-hover-color);
	}
	.header-sticky.affix .customize-social-networks .gf-social-icon > li {
	  color: var(--g5-mobile-menu-customize-sticky-text-color);
	}
	.header-sticky.affix .customize-social-networks .gf-social-icon > li a:hover {
	  color: var(--g5-mobile-menu-customize-text-hover-color);
	}


}

@media (min-width: {$responsive_break_point_2}px) {
	.gsf-catalog-filter .woocommerce-custom-wrap{
		display: block;
	}
	
	.gsf-catalog-filter .woocommerce-custom-wrap-mobile{
		display: none;
	}
}

CUSTOM_CSS;

		}


		public function custom_script()
		{
			// Custom javascript
			$custom_js = G5Plus_Auteur()->options()->get_custom_js();
			if (!empty($custom_js)) {
				if (preg_match('/\\<script/', $custom_js)) {
					echo sprintf('%s', $custom_js);
				} else {
					echo sprintf('<script type="text/javascript">%s</script>', $custom_js);
				}
			}
		}

		public function getFontFamily($name)
		{
			if ((strpos($name, ',') === false) || (strpos($name, ' ') === false)) {
				return $name;
			}
			return "'{$name}'";
		}

		public function processFont($fonts)
		{
			if (isset($fonts['font_weight']) && (($fonts['font_weight'] === '') || ($fonts['font_weight'] === 'regular'))) {
				$fonts['font_weight'] = '400';
			}

			if (isset($fonts['font_style']) && ($fonts['font_style'] === '')) {
				$fonts['font_style'] = 'normal';
			}
			return $fonts;
		}

		public function enqueue_block_editor_assets()
		{
			if (!function_exists('G5P')) {
				wp_enqueue_style('google_fonts', 'https://fonts.googleapis.com/css?family=Libre+Baskerville%3Aregular%2C400i%2C700%7CNunito+Sans%3A200%2C200i%2C300%2C300i%2Cregular%2C400i%2C600%2C600i%2C700%2C700i%2C800%2C800i%2C900%2C900i&subset=latin%2Clatin-ext%2Cvietnamese');
			}
			wp_enqueue_style(G5Plus_Auteur()->helper()->assetsHandle('editor-blocks'), G5Plus_Auteur()->helper()->getAssetUrl('assets/css/editor/blocks.min.css'));
			$preset = G5Plus_Auteur()->helper()->getCurrentPreset();
			wp_enqueue_style('gsf_custom_css_block_editor', admin_url('admin-ajax.php') . '?action=gsf_custom_css_block_editor&preset=' . $preset);
		}

		public function custom_editor_styles($stylesheets)
		{
			if (!function_exists('G5P')) {
				$stylesheets[] = 'https://fonts.googleapis.com/css?family=Libre+Baskerville%3Aregular%2C400i%2C700%7CNunito+Sans%3A200%2C200i%2C300%2C300i%2Cregular%2C400i%2C600%2C600i%2C700%2C700i%2C800%2C800i%2C900%2C900i&subset=latin%2Clatin-ext%2Cvietnamese';
			}

			$preset = G5Plus_Auteur()->helper()->getCurrentPreset();
			$stylesheets[] = admin_url('admin-ajax.php') . '?action=gsf_custom_css_editor&preset=' . $preset;
			return $stylesheets;
		}


		public function custom_css_editor()
		{
			$preset = isset($_REQUEST['preset']) ? $_REQUEST['preset'] : '';
			$GLOBALS['gsf_current_preset'] = $preset;

			$sidebar_layout = G5Plus_Auteur()->options()->get_sidebar_layout();
			$sidebar_width = G5Plus_Auteur()->options()->get_sidebar_width();
			$sidebar = G5Plus_Auteur()->cache()->get_sidebar();


			$custom_sidebar_layout = G5Plus_Auteur()->metaBox()->get_sidebar_layout();
			if (!empty($custom_sidebar_layout)) {
				$sidebar_layout = $custom_sidebar_layout;
			}
			$content_width = 1170;
			$sidebar_text = esc_html__('Sidebar', 'g5plus-auteur');
			if ($sidebar_width === 'large') {
				$sidebar_width = 770;
			} else {
				$sidebar_width = 870;
			}

			$custom_css = '';
			if ($sidebar_layout !== 'none' && is_active_sidebar($sidebar)) {
				$content_width = $sidebar_width;

				$custom_css .= <<<CSS
				.mceContentBody::after {
				    content: '{$sidebar_text}';
				}
CSS;
			}


			$custom_css .= <<<CSS
            body {
              margin: 9px 10px;
            }

			.mceContentBody[data-site_layout="left"],
			.mceContentBody[data-site_layout="right"]{
			    max-width: {$sidebar_width}px;
			}
			
			.mceContentBody[data-site_layout="left"]::after,
			 .mceContentBody[data-site_layout="right"]::after{
				    content: '{$sidebar_text}';
				}

			.mceContentBody {
				max-width: {$content_width}px;
			}
			
CSS;

			/*font*/
			$custom_fonts = array(
				'body_font' => array(
					'body',
				),
				'h1_font' => array(
					'h1'
				),
				'h2_font' => array(
					'h2'
				),
				'h3_font' => array(
					'h3'
				),
				'h4_font' => array(
					'h4'
				),
				'h5_font' => array(
					'h5'
				),
				'h6_font' => array(
					'h6'
				)
			);

			foreach ($custom_fonts as $optionKey => $selectors) {
				$selector = implode(',', $selectors);
				$fonts = G5Plus_Auteur()->options()->getOptions($optionKey);
				$fonts = $this->processFont($fonts);
				$fonts_attributes = array();
				if (isset($fonts['font_family'])) {
					$fonts['font_family'] = $this->getFontFamily($fonts['font_family']);
					$fonts_attributes[] = "font-family: '{$fonts['font_family']}'";
				}

				if (isset($fonts['font_size'])) {
					$fonts_attributes[] = "font-size: {$fonts['font_size']}";
				}

				if (isset($fonts['font_weight'])) {
					$fonts_attributes[] = "font-weight: {$fonts['font_weight']}";
				}

				if (isset($fonts['font_style'])) {
					$fonts_attributes[] = "font-style: {$fonts['font_style']}";
				}

				if (sizeof($fonts_attributes) > 0) {
					$fonts_css = implode(';', $fonts_attributes);

					$custom_css .= <<<CSS
                {$selector} {
                    {$fonts_css}
                }
CSS;
				}
			}

			$custom_font_family = array(
				'body_font' => array('.body-font'),
				'primary_font' => array('.primary-font', '.has-drop-cap:not(:focus):first-letter')
			);

			foreach ($custom_font_family as $optionKey => $selectors) {
				$selector = implode(',', $selectors);
				$fonts = G5Plus_Auteur()->options()->getOptions($optionKey);
				$fonts = $this->processFont($fonts);
				if (isset($fonts['font_family'])) {
					$fonts['font_family'] = $this->getFontFamily($fonts['font_family']);
					$custom_css .= <<<CSS
                {$selector} {
                    font-family: '{$fonts['font_family']}';
                }
CSS;
				}
			}

			// Remove comments
			$custom_css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $custom_css);
			// Remove space after colons
			$custom_css = str_replace(': ', ':', $custom_css);
			// Remove whitespace
			$custom_css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $custom_css);
			return $custom_css;
		}

		public function custom_css_editor_callback()
		{
			$custom_css = $this->custom_css_editor();

			/**
			 * Make sure we set the correct MIME type
			 */
			header('Content-Type: text/css');
			/**
			 * Render RTL CSS
			 */
			echo sprintf('%s', $custom_css);
			die();
		}


		public function custom_css_block_editor()
		{

			$preset = isset($_REQUEST['preset']) ? $_REQUEST['preset'] : '';
			$GLOBALS['gsf_current_preset'] = $preset;

			$sidebar_layout = G5Plus_Auteur()->options()->get_sidebar_layout();
			$sidebar_width = G5Plus_Auteur()->options()->get_sidebar_width();
			$sidebar = G5Plus_Auteur()->cache()->get_sidebar();

			$custom_sidebar_layout = G5Plus_Auteur()->metaBox()->get_sidebar_layout();
			if (!empty($custom_sidebar_layout)) {
				$sidebar_layout = $custom_sidebar_layout;
			}
			$content_width = 770;
			if ($sidebar_width === 'large') {
				$sidebar_width = 770;
			} else {
				$sidebar_width = 870;
			}

			$content_wide_width = 1170;
			$custom_css = '';
			if ($sidebar_layout !== 'none' && is_active_sidebar($sidebar)) {
				$content_width = $sidebar_width;
				$content_wide_width = $sidebar_width;


			}
			$custom_css .= <<<CSS
            
            .editor-styles-wrapper[data-site_layout="left"] .wp-block,
			.editor-styles-wrapper[data-site_layout="right"] .wp-block,
			.editor-styles-wrapper[data-site_layout="left"] .wp-block[data-align="wide"],
			.editor-styles-wrapper[data-site_layout="right"] .wp-block[data-align="wide"],
			.editor-styles-wrapper[data-site_layout="left"] .wp-block[data-align="full"],
			.editor-styles-wrapper[data-site_layout="right"] .wp-block[data-align="full"]{
			    max-width: {$sidebar_width}px;
			}
			
			.editor-styles-wrapper[data-site_layout="left"] .wp-block[data-align="full"],
			.editor-styles-wrapper[data-site_layout="right"] .wp-block[data-align="full"] {
			    margin-left: auto;
			    margin-right: auto;
			}
			
			@media (min-width: 600px) {
              .editor-styles-wrapper[data-site_layout="right"] .wp-block[data-align=full]>.editor-block-list__block-edit,
              .editor-styles-wrapper[data-site_layout="left"] .wp-block[data-align=full]>.editor-block-list__block-edit {
                margin-left: -28px;
                margin-right: -28px;
              }
            }
			
            .editor-styles-wrapper .wp-block {
                max-width: {$content_width}px;
            }
            
            .editor-styles-wrapper .wp-block[data-align="wide"] {
                max-width: {$content_wide_width}px;
            }
			
CSS;

			if ($sidebar_layout !== 'none' && is_active_sidebar($sidebar)) {
				$custom_css .= <<<CSS
            .editor-styles-wrapper .wp-block[data-align="full"] {
                max-width: {$sidebar_width}px;
            }

            .block-editor-block-list__layout .wp-block[data-align="full"] {
                margin-left: auto !important;
                margin-right: auto !important;
            }
            
            @media (min-width: 600px) {
              .block-editor-block-list__layout .wp-block[data-align=full]>.editor-block-list__block-edit {
                margin-left: -28px;
                margin-right: -28px;
              }
            }

CSS;
			} else {
				$custom_css .= <<<CSS
            .editor-styles-wrapper .wp-block[data-align="full"] {
                max-width: none;
            }
CSS;
			}


			/*font*/
			$custom_fonts = array(
				'body_font' => array(
					'.editor-styles-wrapper.editor-styles-wrapper',
				),
				'h1_font' => array(
					'.editor-styles-wrapper.editor-styles-wrapper h1'
				),
				'h2_font' => array(
					'.editor-styles-wrapper.editor-styles-wrapper h2'
				),
				'h3_font' => array(
					'.editor-styles-wrapper.editor-styles-wrapper h3'
				),
				'h4_font' => array(
					'.editor-styles-wrapper.editor-styles-wrapper h4'
				),
				'h5_font' => array(
					'.editor-styles-wrapper.editor-styles-wrapper h5'
				),
				'h6_font' => array(
					'.editor-styles-wrapper.editor-styles-wrapper h6'
				),
			);

			foreach ($custom_fonts as $optionKey => $selectors) {
				$selector = implode(',', $selectors);
				$fonts = G5Plus_Auteur()->options()->getOptions($optionKey);
				$fonts = $this->processFont($fonts);
				$fonts_attributes = array();
				if (isset($fonts['font_family'])) {
					$fonts['font_family'] = $this->getFontFamily($fonts['font_family']);
					$fonts_attributes[] = "font-family: '{$fonts['font_family']}'";
				}

				if (isset($fonts['font_size'])) {
					$fonts_attributes[] = "font-size: {$fonts['font_size']}";
				}

				if (isset($fonts['font_weight'])) {
					$fonts_attributes[] = "font-weight: {$fonts['font_weight']}";
				}

				if (isset($fonts['font_style'])) {
					$fonts_attributes[] = "font-style: {$fonts['font_style']}";
				}

				if (sizeof($fonts_attributes) > 0) {
					$fonts_css = implode(';', $fonts_attributes);

					$custom_css .= <<<CSS
                {$selector} {
                    {$fonts_css}
                }
CSS;
				}
			}

			$custom_font_family = array(
				'body_font' => array('.editor-styles-wrapper.editor-styles-wrapper .body-font'),
				'primary_font' => array(
					'.editor-styles-wrapper.editor-styles-wrapper .primary-font',
					'.editor-styles-wrapper.editor-styles-wrapper .has-drop-cap:not(:focus):first-letter',
					'.editor-post-title__block.editor-post-title__block .editor-post-title__input'
				)
			);

			foreach ($custom_font_family as $optionKey => $selectors) {
				$selector = implode(',', $selectors);
				$fonts = G5Plus_Auteur()->options()->getOptions($optionKey);
				$fonts = $this->processFont($fonts);
				if (isset($fonts['font_family'])) {
					$fonts['font_family'] = $this->getFontFamily($fonts['font_family']);
					$custom_css .= <<<CSS
                {$selector} {
                    font-family: '{$fonts['font_family']}';
                }
CSS;
				}
			}

			// Remove comments
			$custom_css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $custom_css);
			// Remove space after colons
			$custom_css = str_replace(': ', ':', $custom_css);
			// Remove whitespace
			$custom_css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $custom_css);

			return $custom_css;
		}

		public function custom_css_block_editor_callback()
		{
			$custom_css = $this->custom_css_block_editor();

			/**
			 * Make sure we set the correct MIME type
			 */
			header('Content-Type: text/css');
			/**
			 * Render RTL CSS
			 */
			echo sprintf('%s', $custom_css);
			die();
		}

	   public function enqueue_assets_content_block() {
		   $content_block_ids = G5Plus_Auteur()->helper()->get_content_block_ids();
		   if ($content_block_ids === false) {
			   return;
		   }

		   $custom_css        = '';
		   $is_built_with_elementor = false;
		   $is_built_with_vc = false;
		   foreach ( $content_block_ids as $post_id ) {
			   if ( $post_id !== '' ) {
			   	    $page_used_elementor = G5Plus_Auteur()->helper()->page_used_elementor($post_id);
				    $page_used_vc = G5Plus_Auteur()->helper()->page_used_vc($post_id);
			   	    if ($page_used_elementor) {
				        $is_built_with_elementor = true;
				        if (class_exists('Elementor\Core\Files\CSS\Post')) {
					        $css_file = Elementor\Core\Files\CSS\Post::create( $post_id );
					        if ( ! empty( $css_file ) ) {
						        $custom_css .= $css_file->get_content();
					        }
				        }
			        } else if ($page_used_vc) {
				        $is_built_with_vc = true;

				        /**
				         * Post Custom Css
				         */
				        $post_custom_css = get_post_meta($post_id, '_wpb_post_custom_css', true);
						if (!empty($post_custom_css)) {
							$custom_css .= $post_custom_css;
						}

				        /**
				         * Shortcodes Custom Css
				         */
				        $shortcodes_custom_css = get_post_meta($post_id, '_wpb_shortcodes_custom_css', true);
						if (!empty($shortcodes_custom_css)) {
							$custom_css .= $shortcodes_custom_css;
						}

						do_action('g5plus_enqueue_assets_content_block',$post_id);
			        }

			   }
		   }

		   if ($is_built_with_elementor) {
			   Elementor\Plugin::$instance->frontend->enqueue_styles();
		   }

		   if ($is_built_with_vc) {
			   wp_enqueue_style('js_composer_front');
		   }

		   wp_add_inline_style(G5Plus_Auteur()->helper()->assetsHandle('main'), $custom_css);
	   }

	}
}