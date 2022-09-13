<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!class_exists('G5P_Inc_Updater')) {
	class G5P_Inc_Updater {
		private static $_instance;
		public static function getInstance() {
			if (self::$_instance == NULL) { self::$_instance = new self(); }
			return self::$_instance;
		}

		public function updater() {
			$current_version = G5P()->pluginVer();
			$pre_version = get_option( 'auteur_version', '1.0');

			// fix data elementor widget product singular
			if (version_compare($pre_version,'4.3','<')) {
				global $wpdb;
				$pages = $wpdb->get_results( "SELECT ID FROM $wpdb->posts WHERE post_type <> 'attachment'" );
				foreach ($pages as $page) {
					$_elementor_data = get_post_meta($page->ID, '_elementor_data', true);
					if ($_elementor_data) {
						$_elementor_data = json_decode($_elementor_data,true);
						if (is_array($_elementor_data)) {
							$this->update_data_widget_product_singular($_elementor_data);
							update_post_meta($page->ID, '_elementor_data', wp_slash(json_encode($_elementor_data)));
						}
					}
				}
				update_option('auteur_version', $current_version);
			}
		}

		private function update_data_widget_product_singular(&$data) {
			if (is_array($data)) {
				foreach ($data as &$el) {
					if (isset($el['widgetType']) && $el['widgetType'] === 'auteur-product-singular' && isset($el['settings']) && is_array($el['settings'])) {
						foreach ($el['settings'] as $k => $v) {
							if ($k === 'id') {
								$el['settings']['ids'] = $v;
								unset($el['settings'][$k]);
							}
						}
					}

					if (isset($el['elements'])) {
						$this->update_data_widget_product_singular( $el['elements']);
					}
				}
			}
		}
	}
}