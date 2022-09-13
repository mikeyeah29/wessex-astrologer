<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('Bpfw_Install')) {
	class Bpfw_Install {
		private static $_instance;
		public static function get_instance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_action('init', array($this, 'check_update'));
		}

		public function check_update() {
			if ( ! defined( 'IFRAME_REQUEST' ) && get_option( 'bpfw_version' ) !== BPFW()->plugin_ver() ) {
				$this->run_update();
				do_action( 'bpfw_updated' );
			}
		}

		public function run_update() {
			if ( ! is_blog_installed() ) {
				return;
			}
			if ( 'yes' === get_transient( 'bpfw_installing' ) ) {
				return;
			}

			$this->update();

			set_transient( 'bpfw_installing', 'yes', MINUTE_IN_SECONDS * 10 );
			update_option( 'bpfw_version', BPFW()->plugin_ver());
			delete_transient( 'bpfw_installing' );
		}

		public function update() {
			$this->fix_conflict_read_book_addons_for_book_store();
		}

		/**
		 * Fix: Conflict with plugin Read Book Addons For Book Store
		 */
		public function fix_conflict_read_book_addons_for_book_store() {
			if (get_option( 'bpfw_fix_conflict_read_book_addons_for_book_store' ) === 'yes') {
				return;
			}

			global $wpdb;
			$rows = $wpdb->get_results( $wpdb->prepare( "SELECT meta_id, post_id, meta_value FROM $wpdb->postmeta WHERE meta_key = %s", 'rba_back_img' ) );
			foreach ($rows as $row) {
				update_post_meta($row->post_id, 'bpfw_back_img', $row->meta_value);
			}
			update_option('bpfw_fix_conflict_read_book_addons_for_book_store', true);
		}
	}
}