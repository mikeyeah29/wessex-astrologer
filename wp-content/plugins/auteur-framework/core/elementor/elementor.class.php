<?php
// Do not allow directly accessing this file.
use Elementor\Core\Files\CSS\Post;
use Elementor\Core\Settings\Page\Manager;
use Elementor\Plugin;

if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if (!class_exists('G5P_Core_Elementor')) {
	class G5P_Core_Elementor
	{
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}


		public function init()
		{
			add_filter('ube_get_element_configs', array($this, 'change_ube_get_element_configs'));
			add_filter('ube_autoload_file_dir', array($this, 'change_ube_autoload_file_dir'), 10, 2);
			add_action('elementor/frontend/after_enqueue_styles', array($this, 'elementor_custom_css'));

			add_action('elementor/document/after_save', array($this,'update_theme_color'), 10, 2);

			add_action('gsf_after_change_options/g5plus_auteur_options', array($this,'update_elementor_accent_color') , 10, 2);
			add_action('gsf_after_change_options/g5plus_auteur_skin_options', array($this,'update_elementor_color') , 11, 2);
			add_action( 'init', array( $this, 'register_scripts' ) );
			add_action( 'init', array( $this, 'register_style' ) );



			G5P()->loadFile(G5P()->pluginDir('core/elementor/templates.php'));
		}

		public function update_theme_color($obj, $data) {
			if (is_a($obj, 'Elementor\Core\Kits\Documents\Kit')) {
				/**
				 * @var $obj Elementor\Core\Kits\Documents\Kit
				 */
				$map_colors = array(
					'accent' => 'accent_color',
					'primary' => 'primary_color',
					'text' => 'text_color',
					'border' => 'border_color',
					'muted' => 'disable_color',
				);

				$system_colors = isset($data['settings']['system_colors']) ? $data['settings']['system_colors'] : array();

				$theme_options = get_option(G5P()->getOptionName(), array());

				$skin_options = get_option(G5P()->getOptionSkinName(), array());

				$current_skin = G5P()->options()->getOptions('content_skin');

				foreach ($map_colors as $k => $v) {
					$current_color = array();
					foreach ($system_colors as $cl) {
						if ($cl['_id'] === $k) {
							$current_color = $cl;
							break;
						}
					}
					if (isset($current_color['color'])) {
						if (in_array($k,array('accent','primary'))) {
							if (isset($theme_options[$v])) {
								$theme_options[$v] = $current_color['color'];
							}
						} else {
							if (isset($skin_options['color_skin'])) {
								foreach ($skin_options['color_skin'] as &$color_option) {
									if (isset($color_option['skin_id']) && ($color_option['skin_id'] === $current_skin)) {
										if (isset($color_option[$v])) {
											$color_option[$v] = $current_color['color'];
											break;
										}

									}
								}
							}
						}
					}
				}

				update_option(G5P()->getOptionName(), $theme_options);
				update_option(G5P()->getOptionSkinName(), $skin_options);

			}
		}

		public function update_elementor_accent_color($options, $preset) {
			if ($preset === '') {
				$map_colors = array(
					'accent' => 'accent_color',
					'primary' => 'primary_color',
				);

				if (class_exists('Elementor\Plugin')) {
					$kit_id = Elementor\Plugin::$instance->kits_manager->get_active_id();

					$kit = Elementor\Plugin::$instance->documents->get( $kit_id );
					$meta_key = Elementor\Core\Settings\Page\Manager::META_KEY;
					$kit_raw_settings = $kit->get_meta( $meta_key );

					if (!isset($kit_raw_settings['system_colors'])) {
						return;
					}

					foreach ($map_colors as $k => $v) {
						if (isset($options[$v])) {
							foreach ($kit_raw_settings['system_colors'] as &$cl) {
								if ($cl['_id'] === $k) {
									$cl['color'] = $options[$v];
								}
							}
						}
					}

					$kit->update_meta($meta_key, $kit_raw_settings);

					$post_css = Elementor\Core\Files\CSS\Post::create( $kit_id );
					$post_css->delete();
				}
			}
		}

		public function update_elementor_color($options, $preset) {
			if ($preset === '') {
				$current_skin = G5P()->options()->getOptions('content_skin');
				if (!isset($options['color_skin'])) {
					return;
				}

				$current_skin_option = array();

				foreach ($options['color_skin'] as $skin) {
					if (isset($skin['skin_id']) && ($skin['skin_id'] === $current_skin)) {
						$current_skin_option = $skin;
						break;
					}
				}

				if (count($current_skin_option) === 0) {
					return;
				}


				$map_colors = array(
					'text' => 'text_color',
					'border' => 'border_color',
					'muted' => 'disable_color',
				);

				if (class_exists('Elementor\Plugin')) {
					$kit_id = Elementor\Plugin::$instance->kits_manager->get_active_id();

					$kit = Elementor\Plugin::$instance->documents->get( $kit_id );
					$meta_key = Elementor\Core\Settings\Page\Manager::META_KEY;
					$kit_raw_settings = $kit->get_meta( $meta_key );

					if (!isset($kit_raw_settings['system_colors'])) {
						return;
					}

					foreach ($map_colors as $k => $v) {
						if (isset($current_skin_option[$v])) {
							foreach ($kit_raw_settings['system_colors'] as &$cl) {
								if ($cl['_id'] === $k) {
									$cl['color'] = $current_skin_option[$v];
								}
							}
						}
					}

					$kit->update_meta($meta_key, $kit_raw_settings);

					$post_css = Elementor\Core\Files\CSS\Post::create( $kit_id );
					$post_css->delete();
				}
			}
		}

		private function get_elements()
		{
			$element_event = $element_portfolio = $element_product = array();

			if(class_exists('Tribe__Events__Main')) {
				$element_event = array(
					'Events' => esc_html__('Auteur Events', 'auteur-framework'),
					'Events_Slider' => esc_html__('Auteur Events Slider', 'auteur-framework'),
					'Event_Countdown' => esc_html__('Event Countdown', 'auteur-framework'),
				);
			}

			$custom_post_type_disable = G5P()->options()->get_custom_post_type_disable();
			if(!in_array('portfolio', $custom_post_type_disable)) {
				$element_portfolio = array(
					'Portfolios'          => esc_html__( 'Portfolios', 'auteur-framework' ),
					'Portfolios_Slider'   => esc_html__( 'Portfolios Slider', 'auteur-framework' ),
					'Portfolios_Singular' => esc_html__( 'Portfolios Singular', 'auteur-framework' ),
					'Portfolios_Category' => esc_html__( 'Portfolios Category', 'auteur-framework' ),
				);
			}

			if (class_exists('WooCommerce')) {
				$element_product = array(
					'Product_Singular' => esc_html__('Product Singular', 'auteur-framework'),
					'Products' => esc_html__('Products', 'auteur-framework'),
					'Products_Slider' => esc_html__('Products Slider', 'auteur-framework'),
					'Product_Tabs' => esc_html__('Product Tabs', 'auteur-framework'),
					'Product_Tabs_Slider' => esc_html__('Product Tabs Slider', 'auteur-framework'),
					'Products_Review' => esc_html__('Products Review', 'auteur-framework'),
					'Products_Authors' => esc_html__('Products Authors', 'auteur-framework'),
				);
			}

			$element = array(
				'Posts' => esc_html__('Auteur Post', 'auteur-framework'),
				'Posts_Slider' => esc_html__('Auteur Posts Slider', 'auteur-framework'),
			);

			return apply_filters('auteur_elements', array_merge($element_event,$element_portfolio,$element_product,$element));
		}

		public function register_scripts() {
			wp_register_script(G5P()->assetsHandle('posts'),G5P()->helper()->getAssetUrl('assets/js/elementor/posts.min.js'),array(),G5P()->pluginVer());
			wp_register_script(G5P()->assetsHandle('posts-slider'),G5P()->helper()->getAssetUrl('assets/js/elementor/posts-slider.min.js'),array(),G5P()->pluginVer());
			wp_register_script(G5P()->assetsHandle('products'),G5P()->helper()->getAssetUrl('assets/js/elementor/products.min.js'),array(),G5P()->pluginVer());
			wp_register_script(G5P()->assetsHandle('products-slider'),G5P()->helper()->getAssetUrl('assets/js/elementor/products-slider.min.js'),array(),G5P()->pluginVer());
			wp_register_script(G5P()->assetsHandle('product-tabs'),G5P()->helper()->getAssetUrl('assets/js/elementor/product-tabs.min.js'),array(),G5P()->pluginVer());
			wp_register_script(G5P()->assetsHandle('product-tabs-slider'),G5P()->helper()->getAssetUrl('assets/js/elementor/product-tabs-slider.min.js'),array(),G5P()->pluginVer());
			wp_register_script(G5P()->assetsHandle('products-review'),G5P()->helper()->getAssetUrl('assets/js/elementor/products-review.min.js'),array(),G5P()->pluginVer());
			wp_register_script(G5P()->assetsHandle('products-authors'),G5P()->helper()->getAssetUrl('assets/js/elementor/products-authors.min.js'),array(),G5P()->pluginVer());
			wp_register_script(G5P()->assetsHandle('events'),G5P()->helper()->getAssetUrl('assets/js/elementor/events.min.js'),array(),G5P()->pluginVer());
			wp_register_script(G5P()->assetsHandle('events-slider'),G5P()->helper()->getAssetUrl('assets/js/elementor/events-slider.min.js'),array(),G5P()->pluginVer());
			wp_register_script(G5P()->assetsHandle('event-countdown'),G5P()->helper()->getAssetUrl('assets/js/elementor/event-countdown.min.js'),array(),G5P()->pluginVer());
			wp_register_script(G5P()->assetsHandle('portfolios'),G5P()->helper()->getAssetUrl('assets/js/elementor/portfolios.min.js'),array(),G5P()->pluginVer());
			wp_register_script(G5P()->assetsHandle('portfolios-slider'),G5P()->helper()->getAssetUrl('assets/js/elementor/portfolios-slider.min.js'),array(),G5P()->pluginVer());
			wp_register_script(G5P()->assetsHandle('portfolios-singular'),G5P()->helper()->getAssetUrl('assets/js/elementor/portfolios-singular.min.js'),array(),G5P()->pluginVer());
		}

		public function register_style() {
			wp_register_style(G5P()->assetsHandle('product-singular'), G5P()->helper()->getAssetUrl('shortcodes/product-singular/assets/scss/product-singular.min.css'), array(), G5P()->pluginVer());
			wp_register_style(G5P()->assetsHandle('product-reviews'), G5P()->helper()->getAssetUrl('shortcodes/product-reviews/assets/scss/product-reviews.min.css'), array(), G5P()->pluginVer());
			wp_register_style(G5P()->assetsHandle('portfolio-singular'), G5P()->helper()->getAssetUrl('shortcodes/portfolio-singular/assets/scss/portfolio-singular.min.css'), array(), G5P()->pluginVer());
			wp_register_style(G5P()->assetsHandle('event-countdown'), G5P()->helper()->getAssetUrl('shortcodes/countdown/assets/scss/countdown.min.css'), array(), G5P()->pluginVer());
			wp_register_style(G5P()->assetsHandle('portfolio-category'), G5P()->helper()->getAssetUrl('shortcodes/portfolio-category/assets/scss/portfolio-category.min.css'), array(), G5P()->pluginVer());
		}

		public function change_ube_get_element_configs($configs)
		{

			$elements = $this->get_elements();

			$g5_elements = isset($configs['auteur_elements']) ? $configs['auteur_elements'] : array(
				'title' => esc_html__('Auteur Elements', 'auteur-framework'),
				'items' => array()
			);

			foreach ($elements as $k => $v) {
				$g5_elements['items']["Auteur_{$k}"] = array(
					'title' => $v
				);
			}

			$configs['auteur_elements'] = $g5_elements;
			return $configs;
		}

		public function change_ube_autoload_file_dir($path, $class)
		{
			$prefix = 'UBE_Element_Auteur_';
			if (strpos($class, $prefix) === 0) {
				$file_name = substr($class, strlen($prefix));
				$file_name = str_replace('_', '-', $file_name);
				$file_name = strtolower($file_name);
				return G5P()->pluginDir("elements/{$file_name}/config.php");
			}
			return $path;
		}

		public function elementor_custom_css()
		{
			$body_font = G5P()->options()->get_body_font();
			$body_font = GSF()->core()->fonts()->processFont($body_font);
			$body_font_family = GSF()->core()->fonts()->getFontFamily($body_font['font_family']);

			$primary_font = G5P()->options()->get_primary_font();
			$primary_font_family = GSF()->core()->fonts()->getFontFamily($primary_font['font_family']);

			$custom_css = <<<CSS
			body.elementor-page {
	--e-global-typography-primary-font-family: '{$primary_font_family}';
	
	--e-global-typography-text-font-family : '{$body_font_family}';
	--e-global-typography-text-font-weight: {$body_font['font_weight']};
}	
			
			
		.elementor-column-gap-default > .elementor-column > .elementor-element-populated {
			padding: 15px;
		}
CSS;
			wp_add_inline_style('elementor-frontend', $custom_css);
		}

	}
}