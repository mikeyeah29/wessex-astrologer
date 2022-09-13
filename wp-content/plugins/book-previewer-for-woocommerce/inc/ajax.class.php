<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!class_exists('Bpfw_Ajax')) {
	class Bpfw_Ajax
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
			add_action('wp_ajax_bpfw_read_book', array($this, 'read_book_template'));
			add_action('wp_ajax_nopriv_bpfw_read_book', array($this, 'read_book_template'));
		}

		public function read_book_template() {
			if (!isset($_GET['acds_read_book_nonce']) || !wp_verify_nonce($_GET['acds_read_book_nonce'], 'acds_read_book_action')) {
				return;
			}
			$product_id = $_GET['product_id'];
			BPFW()->get_template('popup.php', array('product_id' => $product_id));
			die();
		}
	}
}