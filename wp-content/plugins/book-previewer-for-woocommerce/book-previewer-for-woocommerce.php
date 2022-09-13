<?php
/**
 * Plugin Name: Book Previewer for Woocommerce
 * Plugin URI: https://wordpress.org/plugins/book-previewer-for-woocommerce/
 * Description: Change product gallery into book previewer for book store
 * Version: 1.0.6
 * Author: G5Theme
 * Author URI: https://themeforest.net/user/g5theme
 *
 * Text Domain: bpfw
 * Domain Path: /languages/
 * License:      GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 *
 **/
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('BookPreviewerForWoocommerce')):
	class BookPreviewerForWoocommerce
	{
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == null) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public $meta_prefix = 'bpfw_';

		public function __construct()
		{
			add_action('plugins_loaded', array($this, 'plugin_notice'), 11 );
			add_action('plugins_loaded', array($this, 'load_text_domain'), 11);
		}

		/**
		 * Init plugin
		 */
		public function init()
		{
			spl_autoload_register(array($this, 'auto_load'));
			$this->includes();
			Bpfw_Install::get_instance()->init();
			Bpfw_Assets::getInstance()->init();
			Bpfw_Admin::getInstance()->init();
			Bpfw_Ajax::getInstance()->init();
		}

		public function plugin_notice() {
			if ( ! function_exists( 'WC' ) || function_exists('RBA')) {
				if (! function_exists( 'WC' )) {
					add_action( 'admin_notices', array($this, 'woocommerce_admin_notice') );
				}
				if ( function_exists( 'RBA' )) {
					add_action( 'admin_notices', array($this, 'conflict_read_book_addons_for_book_store_admin_notice') );
				}

			} else {
				$this->init();
			}
		}

		public function get_active_deactivate_link($plugin, $action) {
			if ( strpos( $plugin, '/' ) ) {
				$plugin = str_replace( '\/', '%2F', $plugin );
			}
			$url = sprintf( admin_url( 'plugins.php?action=' . $action . '&plugin=%s&plugin_status=all&paged=1&s' ), $plugin );
			$_REQUEST['plugin'] = $plugin;
			$url = wp_nonce_url( $url, $action . '-plugin_' . $plugin );
			return $url;
		}

		public function woocommerce_admin_notice() {
			?>
			<div class="error">
				<p><?php esc_html_e( 'Book Previewer For Woocommerce is enabled but not effective. It requires WooCommerce in order to work.', 'bpfw' ); ?></p>
			</div>
			<?php
		}

		public function conflict_read_book_addons_for_book_store_admin_notice() {
			$deactivate_url = $this->get_active_deactivate_link('read-book-addons-for-book-store/read-book-addons-for-book-store.php', 'deactivate');
			?>
			<div class="error">
				<p><?php echo wp_kses_post(sprintf(__( 'Book Previewer For Woocommerce is enabled but not effective. Please <a href="%s">deactivate</a> plugin Read Book Addons For Book Store (deprecated version).', 'bpfw' ),
						$deactivate_url)); ?></p>
			</div>
			<?php
		}

		/**
		 * Autoloader library class for plugin
		 *
		 * @param $class
		 */
		public function auto_load($class)
		{
			$file_name = preg_replace('/^Bpfw_/', '', $class);
			if ($file_name !== $class) {
				$path      = '';
				$file_name = strtolower($file_name);
				$file_name = str_replace('_', '-', $file_name);
				$this->load_file($this->plugin_dir("inc/{$path}{$file_name}.class.php"));
			}
		}

		public function load_text_domain() {
            load_plugin_textdomain('bpfw', false, $this->plugin_dir('languages'));
        }

		/**
		 * Include library for plugin
		 */
		public function includes()
		{
			$this->load_file($this->plugin_dir('inc/functions.php'));
		}

		/**
		 * Get plugin directory
		 *
		 * @param string $path
		 *
		 * @return string
		 */
		public function plugin_dir($path = '')
		{
			return plugin_dir_path(__FILE__) . $path;
		}

		/**
		 * Get plugin url
		 *
		 * @param string $path
		 *
		 * @return string
		 */
		public function plugin_url($path = '')
		{
			return trailingslashit(plugins_url(basename(__DIR__))) . $path;
		}

		public function plugin_ver()
		{
			return '1.0.5';
		}

		/**
		 * Get plugin assets handler
		 *
		 * @param string $handle
		 *
		 * @return string
		 */
		public function assets_handle($handle = '')
		{
			return "bpfw-{$handle}";
		}

		/**
		 * Get plugin assets url (CSS file or JS file)
		 *
		 * @param $file
		 *
		 * @return string
		 */
		public function asset_url($file)
		{
			return $this->plugin_url(untrailingslashit($file));
		}

		/**
		 * Include library for plugin
		 *
		 * @param $path
		 *
		 * @return bool
		 */
		public function load_file($path)
		{
			if ($path && is_readable($path)) {
				include_once $path;

				return true;
			}

			return false;
		}

		/**
		 * Locate template path from template name
		 *
		 * @param $template_name
		 * @param $args
		 *
		 * @return mixed|string|void
		 */
		public function locate_template($template_name, $args = array())
		{
			$located = '';

			// Theme or child theme template
			$template = trailingslashit(get_stylesheet_directory()) . 'bpfw/' . $template_name;
			if (file_exists($template)) {
				$located = $template;
			}

			// Plugin template
			if (!$located) {
				$located = $this->plugin_dir() . 'templates/' . $template_name;
			}

			$located = apply_filters('bpfw_locate_template', $located, $template_name, $args);

			// Return what we found.
			return $located;
		}

		/**
		 * Render template
		 *
		 * @param $template_name
		 * @param array $args
		 *
		 * @return mixed|string|void
		 */
		public function get_template($template_name, $args = array())
		{
			if (!empty($args) && is_array($args)) {
				extract($args);
			}

			$located = $this->locate_template($template_name, $args);
			if (!file_exists($located)) {
				_doing_it_wrong(__FUNCTION__, sprintf('<code>%s</code> does not exist.', $located), '1.0.5');

				return '';
			}

			do_action('bpfw_before_template_part', $template_name, $located, $args);
			include($located);
			do_action('bpfw_after_template_part', $template_name, $located, $args);

			return $located;
		}

		/**
		 * Render plugin template
		 *
		 * @param $template_name
		 * @param array $args
		 *
		 * @return string
		 */
		public function get_plugin_template($template_name, $args = array())
		{
			if ($args && is_array($args)) {
				extract($args);
			}

			$located = $this->plugin_dir($template_name);
			if (!file_exists($located)) {
				_doing_it_wrong(__FUNCTION__, sprintf('<code>%s</code> does not exist.', $template_name), '1.0.5');

				return '';
			}

			do_action('bpfw_before_plugin_template', $template_name, $located, $args);
			include($located);
			do_action('bpfw_after_plugin_template', $template_name, $located, $args);

			return $located;
		}
	}

	function BPFW()
	{
		return BookPreviewerForWoocommerce::getInstance();
	}

    BPFW();
endif;