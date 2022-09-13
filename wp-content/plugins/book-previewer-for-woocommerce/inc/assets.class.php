<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('Bpfw_Assets')) {
	class Bpfw_Assets
	{
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == null) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init()
		{
			add_action('init', array($this, 'register_assets'));
			add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_backend_assets' ) );
		}

		public function register_assets()
		{
			// Vendors assets
			wp_register_style('magnific-popup', BPFW()->asset_url('assets/vendors/magnific-popup/magnific-popup.min.css'), array(), BPFW()->plugin_ver());
			wp_register_script('magnific-popup' , BPFW()->asset_url('assets/vendors/magnific-popup/jquery.magnific-popup.min.js'), array('jquery'), '1.1.0', true);

			// Plugin assets
			wp_register_style(BPFW()->assets_handle('bpfw'), BPFW()->asset_url('assets/css/bpfw.css'), array(), BPFW()->plugin_ver());
			wp_register_script(BPFW()->assets_handle('bpfw'), BPFW()->asset_url('assets/js/bpfw.js'), array('jquery'), BPFW()->plugin_ver(), true);

			// Plugin admin assets
			wp_register_style(BPFW()->assets_handle('bpfw-admin'), BPFW()->asset_url('admin/assets/css/bpfw-admin.css'), array(), BPFW()->plugin_ver());
			wp_register_script(BPFW()->assets_handle('bpfw-admin'), BPFW()->asset_url('admin/assets/js/bpfw-admin.js'), array('jquery'), BPFW()->plugin_ver(), true);
		}

		public function enqueue_assets()
		{
			wp_enqueue_style('magnific-popup');
			wp_enqueue_script('magnific-popup');

			wp_enqueue_style(BPFW()->assets_handle('bpfw'));
			wp_enqueue_script(BPFW()->assets_handle('bpfw'));
		}

		public function enqueue_backend_assets() {
			wp_enqueue_media();
			wp_enqueue_style(BPFW()->assets_handle('bpfw-admin'));
			wp_enqueue_script(BPFW()->assets_handle('bpfw-admin'));
		}
	}
}